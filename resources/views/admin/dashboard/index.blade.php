@extends('layouts.admin')

@section('content')
<div class="py-4 px-3 px-md-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 text-white mb-1 fw-bold">لوحة الإدارة الفاخرة | Regalest Dashboard 👑</h2>
            <p class="text-muted small mb-0">نظرة عامة على المبيعات، تحويلات واتساب، ومؤشرات الأداء الرئيسية للمتجر.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-warning">
                📦 عرض الطلبات ({{ $metrics['pending_orders'] ?? 0 }} قيد الانتظار)
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-sm" style="background: #C9A84C; color: #000; font-weight: 600;">
                ➕ إضافة منتج جديد
            </a>
        </div>
    </div>

    {{-- 4 Stat Metric Cards --}}
    <div class="row g-3 mb-4">
        {{-- Total Orders --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="background: #141414; border: 1px solid #262626 !important; border-radius: 12px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small">إجمالي الطلبات</span>
                        <h3 class="text-white fw-bold mb-0 mt-1">{{ number_format($metrics['total_orders'] ?? 0) }}</h3>
                        <small class="text-warning">طلبات اليوم: {{ $metrics['today_orders'] ?? 0 }}</small>
                    </div>
                    <div class="p-3 rounded-circle" style="background: rgba(201, 168, 76, 0.1); color: #C9A84C; font-size: 1.5rem;">
                        📦
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="background: #141414; border: 1px solid #262626 !important; border-radius: 12px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small">إجمالي المبيعات</span>
                        <h3 class="text-white fw-bold mb-0 mt-1" style="color: #E5C568 !important;">
                            {{ format_currency($metrics['total_revenue'] ?? 0) }}
                        </h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background: rgba(76, 175, 80, 0.1); color: #4CAF50; font-size: 1.5rem;">
                        💵
                    </div>
                </div>
            </div>
        </div>

        {{-- WhatsApp Checkout Clicks --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="background: #141414; border: 1px solid #262626 !important; border-radius: 12px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small">نقرات واتساب للشراء</span>
                        <h3 class="text-white fw-bold mb-0 mt-1">{{ number_format($metrics['checkout_clicks'] ?? 0) }}</h3>
                        <small class="text-success">اليوم: {{ $metrics['today_whatsapp_clicks'] ?? 0 }} نقرة</small>
                    </div>
                    <div class="p-3 rounded-circle" style="background: rgba(37, 211, 102, 0.1); color: #25D366; font-size: 1.5rem;">
                        💬
                    </div>
                </div>
            </div>
        </div>

        {{-- Abandoned Carts --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="background: #141414; border: 1px solid #262626 !important; border-radius: 12px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small">سلات تسوق متروكة</span>
                        <h3 class="text-white fw-bold mb-0 mt-1 text-danger">{{ number_format($metrics['abandoned_carts_count'] ?? 0) }}</h3>
                        <small class="text-muted">القيمة: {{ format_currency($metrics['abandoned_carts_total'] ?? 0) }}</small>
                    </div>
                    <div class="p-3 rounded-circle" style="background: rgba(229, 57, 53, 0.1); color: #E53935; font-size: 1.5rem;">
                        🛒
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Content Row: Top Products & Quick Links --}}
    <div class="row g-4">
        {{-- Top Products --}}
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm p-4" style="background: #141414; border: 1px solid #262626 !important; border-radius: 12px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-white fw-bold mb-0">🏆 الساعات والمنتجات الأكثر طلباً</h5>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm text-warning p-0">عرض الكل &larr;</a>
                </div>

                @if(count($topProducts) > 0)
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0" style="background: transparent;">
                            <thead>
                                <tr class="text-muted small border-bottom border-dark">
                                    <th>المنتج</th>
                                    <th>القطع المباعة</th>
                                    <th>إجمالي الإيراد</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $item)
                                    <tr class="align-middle border-bottom border-dark">
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $item['image'] ?? asset('assets/site/img/product/product-1.jpg') }}" alt="" style="width: 44px; height: 44px; object-fit: cover; border-radius: 8px; border: 1px solid #333;">
                                                <span class="text-white fw-semibold">{{ $item['name'] }}</span>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-warning text-dark">{{ $item['total_sold'] }} قطعة</span></td>
                                        <td class="text-white fw-bold">{{ format_currency($item['total_revenue']) }}</td>
                                        <td>
                                            <a href="{{ route('admin.products.edit', $item['product_id']) }}" class="btn btn-sm btn-outline-secondary py-1 px-2">تعديل</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <p>لا توجد مبيعات مسجلة حتى الآن.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Management Tools --}}
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm p-4 h-100" style="background: #141414; border: 1px solid #262626 !important; border-radius: 12px;">
                <h5 class="text-white fw-bold mb-3">⚡ روابط سريعة للإدارة</h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.bundles.create') }}" class="btn text-start p-3" style="background: #1c1c1c; color: #fff; border: 1px solid #333; border-radius: 8px;">
                        🎁 <strong>إنشاء عرض مجمع (Bundle)</strong>
                        <div class="small text-muted">ادمج ساعتين أو أكثر بسعر مخفض</div>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="btn text-start p-3" style="background: #1c1c1c; color: #fff; border: 1px solid #333; border-radius: 8px;">
                        ⚙️ <strong>إعدادات المتجر العامة</strong>
                        <div class="small text-muted">الاسم، الشعار، التواصل، والضرائب</div>
                    </a>
                    <a href="{{ route('admin.abandoned-carts.index') }}" class="btn text-start p-3" style="background: #1c1c1c; color: #fff; border: 1px solid #333; border-radius: 8px;">
                        📞 <strong>متابعة السلات المتروكة</strong>
                        <div class="small text-muted">تواصل مع الزبائن عبر واتساب مباشرة</div>
                    </a>
                    <a href="{{ route('admin.analytics.index') }}" class="btn text-start p-3" style="background: #1c1c1c; color: #fff; border: 1px solid #333; border-radius: 8px;">
                        📈 <strong>تقارير نقرات واتساب التفصيلية</strong>
                        <div class="small text-muted">تحليل مصادر الزوار واهتماماتهم</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
