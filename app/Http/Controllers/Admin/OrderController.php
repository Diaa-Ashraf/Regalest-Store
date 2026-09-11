<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function index(Request $request): View
    {
        $query = Order::query()
            ->select([
                'id',
                'order_number',
                'user_id',
                'customer_name',
                'total_price',
                'status',
                'address',
                'phone',
                'payment_method',
                'notes',
                'cancel_reason',
                'currency',
                'exchange_rate',
                'created_at',
            ])
            ->with(['user', 'orderItems.product.translations'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(int $id): View
    {
        $order = Order::query()
            ->with(['user', 'orderItems.product.translations'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);
        $this->orderService->updateStatus($order, $request->status, $request->cancel_reason);

        return redirect()->back()->with('success', __('تم تحديث حالة الطلب بنجاح ومزامنة المخزون تلقائياً.'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        \Illuminate\Support\Facades\DB::transaction(function () use ($order) {
            // If order was active (not cancelled), restore inventory before deleting
            if ($order->status !== Order::STATUS_CANCELLED) {
                $this->orderService->restoreStockForOrder($order);
            }

            $order->orderItems()->delete();
            $order->delete();
        });

        return redirect()->route('admin.orders.index')->with('success', __('تم حذف الطلب واسترجاع المخزون بنجاح.'));
    }
}
