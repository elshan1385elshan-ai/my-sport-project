<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function sendOtp(
        Request $request,
        KavenegarService $kavenegar
    ) {
        $request->validate([
            'phone' => ['required', 'string'],
        ]);

        $phone = $request->phone;

        $code = random_int(100000, 999999);

        Cache::put(
            'otp_' . $phone,
            $code,
            now()->addMinutes(2)
        );

        $kavenegar->sendOtp($phone, $code);

        return back()->with(
            'success',
            'کد تأیید برای شما ارسال شد.'
        );
    }
}