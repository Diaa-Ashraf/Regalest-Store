<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\AbandonedCartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected AbandonedCartService $abandonedCartService
    ) {}

    public function cart(): View
    {
        $items = $this->cartService->getItems();
        $totals = $this->cartService->getTotals();

        // Capture abandoned cart snapshot for follow up
        if (!empty($items)) {
            $this->abandonedCartService->recordSnapshot($items, $totals, auth()->user());
        }

        return view('site.cart', compact('items', 'totals'));
    }

    public function addtocart(Request $request, int $id): JsonResponse
    {
        $quantity = max(1, (int)$request->input('quantity', 1));
        $result = $this->cartService->addProduct($id, $quantity);

        // Update abandoned cart tracker
        $this->abandonedCartService->recordSnapshot(
            $this->cartService->getItems(),
            $this->cartService->getTotals(),
            auth()->user()
        );

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function addBundle(Request $request): JsonResponse
    {
        $bundleId = (int)$request->input('bundle_id');
        $result = $this->cartService->addBundle($bundleId);

        // Update abandoned cart tracker
        $this->abandonedCartService->recordSnapshot(
            $this->cartService->getItems(),
            $this->cartService->getTotals(),
            auth()->user()
        );

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function updateQuantity(Request $request): JsonResponse
    {
        $itemKey = (string)$request->input('item_key');
        $quantity = (int)$request->input('quantity', 1);

        $result = $this->cartService->updateQuantity($itemKey, $quantity);
        $result['cart_payload'] = $this->getCartPayload()->getData(true);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function removefromcart(Request $request): JsonResponse
    {
        $itemKey = (string)$request->input('item_key');
        $result = $this->cartService->removeItem($itemKey);
        $result['cart_payload'] = $this->getCartPayload()->getData(true);

        return response()->json($result);
    }

    public function clearCart(): JsonResponse
    {
        $this->cartService->clear();
        $payload = $this->getCartPayload()->getData(true);
        return response()->json([
            'success' => true,
            'message' => __('تم تفريغ السلة.'),
            'cart_payload' => $payload
        ]);
    }

    public function getCartCount(): JsonResponse
    {
        return response()->json(['count' => $this->cartService->getCount()]);
    }

    public function getCartPayload(): JsonResponse
    {
        $items = $this->cartService->getItems();
        $totals = $this->cartService->getTotals();
        $subtotalUsd = (float)($totals['subtotal'] ?? 0);
        $rate = get_exchange_rate();
        $subtotalSyp = $subtotalUsd * $rate;

        $formattedItems = [];
        foreach ($items as $key => $item) {
            $priceUsd = (float)$item['price'];
            $totalUsd = (float)$item['total'];
            $formattedItems[] = [
                'key' => $key,
                'id' => $item['id'],
                'type' => $item['type'] ?? 'product',
                'name' => $item['name'],
                'image' => $item['image'],
                'quantity' => (int)$item['quantity'],
                'price_usd' => $priceUsd,
                'price_syp' => $priceUsd * $rate,
                'formatted_price_usd' => '$' . number_format($priceUsd, 2),
                'formatted_price_syp' => number_format($priceUsd * $rate, 0) . ' ' . __('ل.س'),
                'total_usd' => $totalUsd,
                'total_syp' => $totalUsd * $rate,
                'formatted_total_usd' => '$' . number_format($totalUsd, 2),
                'formatted_total_syp' => number_format($totalUsd * $rate, 0) . ' ' . __('ل.س'),
            ];
        }

        $taxRate = (float)($totals['tax_rate'] ?? 0);
        $taxAmount = (float)($totals['tax_amount'] ?? 0);
        $grandTotal = (float)($totals['grand_total'] ?? $subtotalUsd);
        $grandTotalSyp = $grandTotal * $rate;

        return response()->json([
            'count' => $this->cartService->getCount(),
            'items' => $formattedItems,
            'subtotal' => $subtotalUsd,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'grand_total' => $grandTotal,
            'subtotal_usd' => $subtotalUsd,
            'subtotal_syp' => $subtotalSyp,
            'formatted_subtotal_usd' => '$' . number_format($subtotalUsd, 2),
            'formatted_subtotal_syp' => number_format($subtotalSyp, 0) . ' ' . __('ل.س'),
            'formatted_subtotal' => format_currency($subtotalUsd),
            'formatted_tax' => format_currency($taxAmount),
            'formatted_total' => format_currency($grandTotal),
            'formatted_grand_total_syp' => format_currency($grandTotal, 'SYP'),
        ]);
    }
}
