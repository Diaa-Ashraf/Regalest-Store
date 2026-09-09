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
     * Top 5 most ordered products (optimized without N+1)
     */
    public function getTopProducts(int $limit = 5): array
    {
        $topItems = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(total_price) as total_revenue'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();

        if ($topItems->isEmpty()) {
            return [];
        }

        $productIds = $topItems->pluck('product_id')->toArray();
        $products = Product::query()
            ->select(['id', 'image', 'price', 'slug'])
            ->with(['translations'])
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        return $topItems->map(function ($item) use ($products) {
            $product = $products->get($item->product_id);
            return [
                'product_id' => $item->product_id,
                'name' => $product?->name ?? 'منتج #' . $item->product_id,
                'image' => $product?->image_url,
                'total_sold' => (int)$item->total_sold,
                'total_revenue' => (float)$item->total_revenue,
            ];
        })->toArray();
    }

    /**
     * Get Comprehensive Reports Data with Caching & High Performance
     */
    public function getComprehensiveReports(string $period = 'month'): array
    {
        $cacheKey = "admin_reports_v2_{$period}_" . Carbon::today()->format('Y-m-d');

        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 600, function () use ($period) {
            $now = Carbon::now();
            $startDate = match ($period) {
                'today' => Carbon::today(),
                'week' => Carbon::now()->startOfWeek(),
                'month' => Carbon::now()->startOfMonth(),
                'year' => Carbon::now()->startOfYear(),
                default => Carbon::now()->subDays(30),
            };

            // 1. Sales & Revenue KPIs
            $totalSales = (float) Order::query()
                ->where('created_at', '>=', $startDate)
                ->whereNotIn('status', [Order::STATUS_CANCELLED])
                ->sum('total_price');

            $totalOrdersCount = Order::query()
                ->where('created_at', '>=', $startDate)
                ->count();

            $deliveredOrdersCount = Order::query()
                ->where('created_at', '>=', $startDate)
                ->where('status', Order::STATUS_DELIVERED)
                ->count();

            $cancelledOrdersCount = Order::query()
                ->where('created_at', '>=', $startDate)
                ->where('status', Order::STATUS_CANCELLED)
                ->count();

            $averageOrderValue = $totalOrdersCount > 0 ? ($totalSales / $totalOrdersCount) : 0;

            // 2. Orders Grouped by Status
            $ordersByStatus = Order::query()
                ->select('status', DB::raw('count(*) as count'), DB::raw('SUM(total_price) as total_amount'))
                ->where('created_at', '>=', $startDate)
                ->groupBy('status')
                ->get()
                ->keyBy('status')
                ->toArray();

            // 3. WhatsApp Funnel & Conversion
            $totalWhatsappClicks = WhatsappClick::query()
                ->where('created_at', '>=', $startDate)
                ->count();

            $checkoutClicks = WhatsappClick::query()
                ->where('created_at', '>=', $startDate)
                ->where('click_type', 'checkout')
                ->count();

            $inquiryClicks = WhatsappClick::query()
                ->where('created_at', '>=', $startDate)
                ->where('click_type', 'product_inquiry')
                ->count();

            $generalClicks = WhatsappClick::query()
                ->where('created_at', '>=', $startDate)
                ->where('click_type', 'general_contact')
                ->count();

            // WhatsApp conversion rate (completed orders vs checkout clicks)
            $conversionRate = $checkoutClicks > 0 ? round(($totalOrdersCount / $checkoutClicks) * 100, 1) : ($totalOrdersCount > 0 ? 100 : 0);

            // 4. Abandoned Carts Recovery
            $abandonedTotalCount = AbandonedCart::query()
                ->where('created_at', '>=', $startDate)
                ->count();

            $abandonedRecoveredCount = AbandonedCart::query()
                ->where('created_at', '>=', $startDate)
                ->where('is_recovered', true)
                ->count();

            $abandonedUnrecoveredAmount = (float) AbandonedCart::query()
                ->where('created_at', '>=', $startDate)
                ->where('is_recovered', false)
                ->sum('total_amount');

            // 5. Daily Revenue & Orders Trend for Chart (Last 14 days or period)
            $daysToFetch = match ($period) {
                'today' => 1,
                'week' => 7,
                'year' => 365,
                default => 30,
            };

            $dailyTrend = Order::query()
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('count(*) as orders_count'),
                    DB::raw('SUM(CASE WHEN status != "cancelled" THEN total_price ELSE 0 END) as daily_revenue')
                )
                ->where('created_at', '>=', Carbon::today()->subDays($daysToFetch - 1))
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get()
                ->toArray();

            // 6. Top Selling Products
            $topProducts = $this->getTopProducts(6);

            // 7. Inventory & Stock Status Alerts
            $lowStockProducts = Product::query()
                ->select(['id', 'stock_quantity', 'quantity', 'price', 'slug', 'image'])
                ->with(['translations'])
                ->where(function ($q) {
                    $q->whereBetween('stock_quantity', [1, 5])
                      ->orWhereBetween('quantity', [1, 5]);
                })
                ->limit(6)
                ->get();

            $outOfStockCount = Product::query()
                ->where(function ($q) {
                    $q->where(function ($sub) {
                        $sub->where('stock_quantity', '<=', 0)->orWhereNull('stock_quantity');
                    })->where(function ($sub) {
                        $sub->where('quantity', '<=', 0)->orWhereNull('quantity');
                    });
                })
                ->count();

            $totalProductsCount = Product::count();

            return [
                'period' => $period,
                'start_date' => $startDate->format('Y-m-d'),
                'total_sales' => $totalSales,
                'total_orders' => $totalOrdersCount,
                'delivered_orders' => $deliveredOrdersCount,
                'cancelled_orders' => $cancelledOrdersCount,
                'avg_order_value' => $averageOrderValue,
                'orders_by_status' => $ordersByStatus,
                'whatsapp' => [
                    'total' => $totalWhatsappClicks,
                    'checkout' => $checkoutClicks,
                    'inquiry' => $inquiryClicks,
                    'general' => $generalClicks,
                    'conversion_rate' => $conversionRate,
                ],
                'abandoned' => [
                    'total' => $abandonedTotalCount,
                    'recovered' => $abandonedRecoveredCount,
                    'unrecovered_amount' => $abandonedUnrecoveredAmount,
                ],
                'daily_trend' => $dailyTrend,
                'top_products' => $topProducts,
                'low_stock_products' => $lowStockProducts,
                'stock_metrics' => [
                    'total_products' => $totalProductsCount,
                    'out_of_stock' => $outOfStockCount,
                ],
            ];
        });
    }
}

