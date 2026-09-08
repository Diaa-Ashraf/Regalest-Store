<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AnalyticsRepository;
use App\Models\WhatsappClick;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function __construct(
        protected AnalyticsRepository $analyticsRepo
    ) {}

    public function index(): View
    {
        $metrics = $this->analyticsRepo->getDashboardMetrics();
        $chartData = $this->analyticsRepo->getWhatsappClicksChart(30);
        $recentClicks = WhatsappClick::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.analytics.index', compact('metrics', 'chartData', 'recentClicks'));
    }
}
