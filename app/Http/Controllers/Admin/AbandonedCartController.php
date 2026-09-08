<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbandonedCart;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AbandonedCartController extends Controller
{
    public function index(): View
    {
        $carts = AbandonedCart::query()
            ->with('user')
            ->recent()
            ->paginate(15);

        return view('admin.abandoned_carts.index', compact('carts'));
    }

    public function markAsRecovered(int $id): RedirectResponse
    {
        $cart = AbandonedCart::findOrFail($id);
        $cart->update(['is_recovered' => true]);

        return redirect()->back()->with('success', __('تم تحديث حالة السلة إلى مستردة بنجاح.'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $cart = AbandonedCart::findOrFail($id);
        $cart->delete();

        return redirect()->back()->with('success', __('تم حذف سجل السلة المتروكة.'));
    }
}
