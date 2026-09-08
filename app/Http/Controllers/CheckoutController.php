<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use App\Services\WhatsappService;
use App\Services\AbandonedCartService;
use App\Http\Requests\Site\CheckoutOrderRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected OrderService $orderService,
        protected WhatsappService $whatsappService,
        protected AbandonedCartService $abandonedCartService
    ) {}

    public function index(): View|RedirectResponse
    {
        $items = $this->cartService->getItems();

        if (empty($items)) {
            return redirect()->route('cart')->with('error', __('سلة الشراء فارغة، يرجى إضافة منتجات أولاً.'));
        }

        $totals = $this->cartService->getTotals();

        return view('site.checkout', compact('items', 'totals'));
    }

    /**
     * Process checkout: creates the DB order, marks cart recovered, and redirects directly to WhatsApp
     */
    public function placeOrder(CheckoutOrderRequest $request): JsonResponse|RedirectResponse
    {
        $items = $this->cartService->getItems();

        if (empty($items)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('سلة الشراء فارغة، يرجى إضافة منتجات أولاً.')
                ], 422);
            }
            return redirect()->route('site.home')->with('error', __('سلة الشراء فارغة.'));
        }

        $totals = $this->cartService->getTotals();
        $customerData = $request->validated();
        $user = auth()->user();

        // 1. Create order and deduct stock in DB transaction
        $order = $this->orderService->createOrder($customerData, $items, $totals, $user);

        // 2. Mark abandoned cart recovered
        $this->abandonedCartService->markAsRecovered();

        // 3. Generate rich WhatsApp message and URL
        $whatsappUrl = $this->whatsappService->buildOrderWhatsappUrl($order, $items, $customerData, $user);

        // 4. Clear shopping cart session
        $this->cartService->clear();

        // 5. If JSON/AJAX request, return JSON payload
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('تم تسجيل طلبك بنجاح وجاري فتح واتساب لتأكيد الشحن.'),
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'whatsapp_url' => $whatsappUrl,
            ]);
        }

        // 6. Redirect customer directly to WhatsApp with prefilled message
        return redirect()->away($whatsappUrl);
    }
}
