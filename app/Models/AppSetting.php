<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AppSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function defaults(): array
    {
        return [
            'app_name' => 'خانه قهرمانان',
            'page_title_prefix' => 'Sport',
            'font_family' => "'Vazir', sans-serif",
            'admin_icon' => 'trophy',
            'admin_icon_type' => 'font',
            'admin_icon_custom' => '',
            'public_icon' => 'trophy-fill',
            'public_icon_type' => 'font',
            'public_icon_custom' => '',
            'welcome_message' => 'به فروشگاه {app_name} خوش آمدید',
            'footer_description' => 'فروشگاه تخصصی کالاهای ورزشی با بهترین کیفیت و قیمت. همراه شما در مسیر قهرمانی.',
            'search_placeholder' => 'جستجوی کالای ورزشی...',
            'copyright_text' => 'تمامی حقوق مادی و معنوی این وب‌سایت متعلق به {app_name} می‌باشد',
            'admin_panel_subtitle' => 'پنل مدیریت فروشگاه ورزشی',
            'contact_address' => 'تهران، خیابان ورزش',
            'contact_phone' => '۰۲۱-۱۲۳۴۵۶۷۸',
            'contact_email' => 'info@sportshop.ir',
            'contact_hours' => '۹ صبح تا ۹ شب',
        ];
    }

    public static function fontOptions(): array
    {
        return [
            "'Vazir', sans-serif" => 'وزیر (Vazir)',
            "Tahoma, Arial, sans-serif" => 'تاهوما (Tahoma)',
            "'IRANSans', sans-serif" => 'ایران سنس (IRANSans)',
            "'Yekan', sans-serif" => 'یکان (Yekan)',
            "'Samim', sans-serif" => 'صمیم (Samim)',
            "'Shabnam', sans-serif" => 'شبنم (Shabnam)',
            "'Parasto', sans-serif" => 'پرستو (Parasto)',
        ];
    }

    public static function adminIconOptions(): array
    {
        return [
            'trophy' => 'جام (trophy)',
            'star' => 'ستاره (star)',
            'heart' => 'قلب (heart)',
            'shopping-bag' => 'کیف خرید (shopping-bag)',
            'sitemap' => 'دسته‌بندی (sitemap)',
            'dashboard' => 'داشبورد (dashboard)',
            'cog' => 'تنظیمات (cog)',
            'futbol-o' => 'توپ (futbol-o)',
            'bolt' => 'برق (bolt)',
            'fire' => 'آتش (fire)',
        ];
    }

    public static function publicIconOptions(): array
    {
        return [
            'trophy-fill' => 'جام (trophy-fill)',
            'star-fill' => 'ستاره (star-fill)',
            'shop' => 'فروشگاه (shop)',
            'bag-heart-fill' => 'کیف (bag-heart-fill)',
            'lightning-charge-fill' => 'برق (lightning-charge-fill)',
            'fire' => 'آتش (fire)',
            'balloon-heart-fill' => 'قلب (balloon-heart-fill)',
            'diamond-fill' => 'الماس (diamond-fill)',
        ];
    }

    public static function allSettings(): array
    {
        return Cache::remember('app_settings', 3600, function () {
            $stored = self::query()->pluck('value', 'key')->toArray();

            return array_merge(self::defaults(), $stored);
        });
    }

    public static function get(string $key, ?string $default = null): string
    {
        $settings = self::allSettings();

        return $settings[$key] ?? $default ?? self::defaults()[$key] ?? '';
    }

    public static function setMany(array $values): void
    {
        foreach ($values as $key => $value) {
            self::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        self::clearCache();
    }

    public static function clearCache(): void
    {
        Cache::forget('app_settings');
    }

    public static function copyrightText(array $settings): string
    {
        return str_replace('{app_name}', $settings['app_name'] ?? '', $settings['copyright_text'] ?? '');
    }
}
