<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AnalyticsRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(
        protected AnalyticsRepository $analyticsRepo
    ) {}

    public function index(Request $request): View
    {
        $period = $request->get('period', 'month');
        if (!in_array($period, ['today', 'week', 'month', 'year', 'all'])) {
            $period = 'month';
        }

        $reports = $this->analyticsRepo->getComprehensiveReports($period);

        return view('admin.reports.index', compact('reports', 'period'));
    }
}
