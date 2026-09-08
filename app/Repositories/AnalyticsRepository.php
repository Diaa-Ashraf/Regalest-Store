<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\WhatsappClick;
use App\Models\AbandonedCart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsRepository
{
    /**
     * Get summary metrics for the admin dashboard
     */
    public function getDashboardMetrics(): array
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', Order::STATUS_PENDING)->count(),
            'total_revenue' => (float) Order::whereNotIn('status', [Order::STATUS_CANCELLED])->sum('total_price'),
            'today_orders' => Order::whereDate('created_at', $today)->count(),

            // WhatsApp analytics
            'total_whatsapp_clicks' => WhatsappClick::count(),
            'checkout_clicks' => WhatsappClick::where('click_type', 'checkout')->count(),
            'today_whatsapp_clicks' => WhatsappClick::whereDate('created_at', $today)->count(),

            // Abandoned carts
            'abandoned_carts_count' => AbandonedCart::unrecovered()->count(),
            'abandoned_carts_total' => (float) AbandonedCart::unrecovered()->sum('total_amount'),
        ];
    }

    /**
     * Get WhatsApp clicks breakdown grouped by date for charts
     */
    public function getWhatsappClicksChart(int $days = 14): array
    {
        $startDate = Carbon::today()->subDays($days - 1);

        $data = WhatsappClick::query()
            ->select(DB::raw('DATE(created_at) as date'), 'click_type', DB::raw('count(*) as total'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('date', 'click_type')
            ->orderBy('date', 'ASC')
            ->get();

        return $data->toArray();
    }

    /**
     * Top 5 most ordered products
     */
    public function getTopProducts(int $limit = 5): array
    {
        return DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(total_price) as total_revenue'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                $product = Product::with('translations')->find($item->product_id);
                return [
                    'product_id' => $item->product_id,
                    'name' => $product?->name ?? 'منتج #' . $item->product_id,
                    'image' => $product?->image_url,
                    'total_sold' => (int)$item->total_sold,
                    'total_revenue' => (float)$item->total_revenue,
                ];
            })
            ->toArray();
    }
}
