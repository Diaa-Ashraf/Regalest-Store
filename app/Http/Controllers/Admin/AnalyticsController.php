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

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $click = WhatsappClick::findOrFail($id);
        $click->delete();

        return redirect()->back()->with('success', __('تم حذف سجل النقرة بنجاح.'));
    }

    public function bulkDestroy(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
    {
        $ids = $request->input('ids', []);
        
        if ($request->input('delete_all') == '1') {
            WhatsappClick::truncate();
            return redirect()->back()->with('success', __('تم حذف كافة سجلات نقرات واتساب بالكامل.'));
        }

        if (is_array($ids) && count($ids) > 0) {
            WhatsappClick::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', __('تم حذف السجلات المحددة بنجاح (:count سجل).', ['count' => count($ids)]));
        }

        return redirect()->back()->with('error', __('يرجى تحديد عنصر واحد على الأقل للحذف.'));
    }
}
