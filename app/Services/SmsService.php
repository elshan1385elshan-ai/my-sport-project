<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * ارسال پیامک. در حالت پیش‌فرض (SMS_DRIVER=log) کد فقط در فایل لاگ
     * ثبت می‌شود تا در محیط توسعه قابل مشاهده باشد. برای اتصال به سرویس
     * واقعی (مثلاً کاوه‌نگار) درایور مربوطه را در این متد پیاده‌سازی کنید
     * و مقادیر را در فایل .env تنظیم نمایید.
     */
    public function send(string $phone, string $message): void
    {
        // تبدیل شماره ایرانی به فرمت بین‌المللی مورد نیاز درگاه‌ها (0912... → 98912...)
        $phone = preg_replace('/^0/', '98', preg_replace('/\D/', '', $phone) ?: '');

        $driver = config('services.sms.driver', 'log');

        match ($driver) {
            'kavenegar' => $this->sendViaKavenegar($phone, $message),
            default => Log::info("SMS to [{$phone}]: {$message}"),
        };
    }

    private function sendViaKavenegar(string $phone, string $message): void
    {
        $apiKey = config('services.sms.kavenegar_key');

        if (! $apiKey) {
            Log::warning('Kavenegar API key is not set. SMS not sent.');

            return;
        }

        try {
            Http::timeout(15)->get("https://api.kavenegar.com/v1/{$apiKey}/sms/send.json", [
                'receptor' => $phone,
                'message' => $message,
            ])->throw();
        } catch (\Throwable $e) {
            // خطای ارسال پیامک کل جریان ثبت‌نام را نباید متوقف کند؛ فقط ثبت می‌شود
            Log::error('Kavenegar SMS failed: '.$e->getMessage());
        }
    }
}
