<?php

namespace App\Services;

use App\Models\OtpCode;
use Illuminate\Support\Facades\Hash;

class OtpService
{
    /**
     * تولید، ذخیره و ارسال کد تأیید برای شماره تلفن.
     */
    public function send(string $phone, string $purpose, array $extra = []): OtpCode
    {
        // کدهای قبلیِ استفاده‌نشده‌ی این شماره را باطل می‌کنیم
        OtpCode::where('phone', $phone)
            ->where('purpose', $purpose)
            ->whereNull('verified_at')
            ->delete();

        // $code = (string) random_int(100000, 999999);
        $code = "123456";
        $otp = OtpCode::create([
            'phone' => $phone,
            'code' => Hash::make($code),
            'purpose' => $purpose,
            'name' => $extra['name'] ?? null,
            'email' => $extra['email'] ?? null,
            'password' => isset($extra['password']) ? Hash::make($extra['password']) : null,
            'expires_at' => now()->addMinutes(5),
        ]);

        app(SmsService::class)->send($phone, "کد تأیید شما در فروشگاه ورزشی: {$code}");

        return $otp;
    }

    /**
     * بررسی صحت کد وارد شده توسط کاربر.
     */
    public function verify(string $phone, string $purpose, string $code): ?OtpCode
    {
        $otp = OtpCode::where('phone', $phone)
            ->where('purpose', $purpose)
            ->latest()
            ->first();

        if (! $otp || ! $otp->isValid() || ! Hash::check($code, $otp->code)) {
            if ($otp) {
                $otp->increment('attempts');
            }

            return null;
        }

        $otp->update(['verified_at' => now()]);

        return $otp;
    }
}
