<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Group
            [
                'group' => 'general',
                'key' => 'site_name',
                'value' => 'Regalest Store',
                'type' => 'text',
                'description' => 'اسم المتجر الرسمي',
            ],
            [
                'group' => 'general',
                'key' => 'site_logo',
                'value' => 'assets/site/img/logo.png',
                'type' => 'image',
                'description' => 'شعار المتجر (أسود وذهبي)',
            ],
            [
                'group' => 'general',
                'key' => 'default_currency',
                'value' => 'USD',
                'type' => 'text',
                'description' => 'العملة الأساسية لتسعير المنتجات',
            ],
            [
                'group' => 'general',
                'key' => 'exchange_rate',
                'value' => '15000',
                'type' => 'number',
                'description' => 'سعر صرف الدولار مقابل الليرة السورية (USD -> SYP)',
            ],
            [
                'group' => 'general',
                'key' => 'tax_rate',
                'value' => '0',
                'type' => 'number',
                'description' => 'نسبة الضريبة المضافة (افتراضياً 0%)',
            ],

            // Contact Group
            [
                'group' => 'contact',
                'key' => 'whatsapp_number',
                'value' => '+963999999999',
                'type' => 'text',
                'description' => 'رقم الواتساب الرسمي لاستقبال الطلبات',
            ],
            [
                'group' => 'contact',
                'key' => 'phone',
                'value' => '+963112233445',
                'type' => 'text',
                'description' => 'رقم هاتف خدمة العملاء',
            ],
            [
                'group' => 'contact',
                'key' => 'email',
                'value' => 'info@regalest.com',
                'type' => 'text',
                'description' => 'البريد الإلكتروني الرسمي',
            ],
            [
                'group' => 'contact',
                'key' => 'address',
                'value' => 'دمشق، سوريا',
                'type' => 'text',
                'description' => 'عنوان المتجر أو صالة العرض',
            ],

            // Social Group
            [
                'group' => 'social',
                'key' => 'facebook_link',
                'value' => 'https://facebook.com/regalest',
                'type' => 'text',
                'description' => 'رابط صفحة فيسبوك',
            ],
            [
                'group' => 'social',
                'key' => 'instagram_link',
                'value' => 'https://instagram.com/regalest',
                'type' => 'text',
                'description' => 'رابط حساب انستغرام',
            ],
            [
                'group' => 'social',
                'key' => 'twitter_link',
                'value' => 'https://x.com/regalest',
                'type' => 'text',
                'description' => 'رابط حساب تويتر / X',
            ],

            // Features Group
            [
                'group' => 'features',
                'key' => 'google_oauth_enabled',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'تفعيل تسجيل الدخول بواسطة جوجل (يمكن تعطيله في حال وجود قيود إقليمية)',
            ],
            [
                'group' => 'features',
                'key' => 'reviews_enabled',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'تفعيل تقييمات وآراء العملاء',
            ],
            [
                'group' => 'features',
                'key' => 'wishlist_enabled',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'تفعيل قائمة الرغبات / حفظ للمفضلة',
            ],

            // Checkout Group
            [
                'group' => 'checkout',
                'key' => 'min_order_amount',
                'value' => '0',
                'type' => 'number',
                'description' => 'الحد الأدنى للطلب (0 = بدون حد أدنى)',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
