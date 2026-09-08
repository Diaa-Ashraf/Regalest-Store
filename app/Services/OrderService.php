<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class OrderService
{
    /**
     * Create an order from cart items
     */
    public function createOrder(array $customerData, array $cartItems, array $totals, ?User $user = null): Order
    {
        return DB::transaction(function () use ($customerData, $cartItems, $totals, $user) {
            $currency = get_active_currency();
            $exchangeRate = get_exchange_rate();

            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => $user?->id,
                'total_price' => (float)($totals['grand_total'] ?? 0),
                'status' => Order::STATUS_PENDING,
                'address' => $customerData['address'] ?? '',
                'phone' => $customerData['phone'] ?? '',
                'payment_method' => 'whatsapp_checkout',
                'notes' => $customerData['notes'] ?? null,
                'currency' => $currency,
                'exchange_rate' => $exchangeRate,
            ]);

            foreach ($cartItems as $item) {
                if ($item['type'] === 'product') {
                    $order->orderItems()->create([
                        'product_id' => $item['id'],
                        'price' => $item['price'],
                        'total_price' => $item['total'],
                        'quantity' => $item['quantity'],
                    ]);

                    // Deduct stock
                    $product = Product::lockForUpdate()->find($item['id']);
                    if ($product) {
                        $newStock = max(0, $product->stock_quantity - $item['quantity']);
                        $product->update([
                            'stock_quantity' => $newStock,
                            'is_available' => $newStock > 0,
                        ]);
                    }
                } elseif ($item['type'] === 'bundle') {
                    // For bundles, handle associated products
                    if (isset($item['products']) && is_array($item['products'])) {
                        foreach ($item['products'] as $bundleProduct) {
                            $product = Product::lockForUpdate()->find($bundleProduct['id']);
                            if ($product) {
                                $newStock = max(0, $product->stock_quantity - $item['quantity']);
                                $product->update([
                                    'stock_quantity' => $newStock,
                                    'is_available' => $newStock > 0,
                                ]);
                            }
                        }
                    }
                }
            }

            return $order;
        });
    }

    /**
     * Update order status with corresponding timestamp
     */
    public function updateStatus(Order $order, string $status, ?string $reason = null): Order
    {
        $updateData = ['status' => $status];

        match ($status) {
            Order::STATUS_CONFIRMED => $updateData['confirmed_at'] = now(),
            Order::STATUS_SHIPPED => $updateData['shipped_at'] = now(),
            Order::STATUS_DELIVERED => $updateData['delivered_at'] = now(),
            Order::STATUS_CANCELLED => [
                $updateData['cancelled_at'] = now(),
                $updateData['cancel_reason'] = $reason,
            ],
            default => null,
        };

        $order->update($updateData);

        return $order;
    }

    /**
     * Generate unique sequential order number
     */
    public function generateOrderNumber(): string
    {
        $prefix = 'RGL-' . date('Ymd') . '-';
        $random = strtoupper(Str::random(4));
        $number = $prefix . $random;

        while (Order::where('order_number', $number)->exists()) {
            $number = $prefix . strtoupper(Str::random(4));
        }

        return $number;
    }
}
