<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    public function __construct(private OtpService $otpService) {}

    /**
     * نمایش صفحه ورود کد تأیید پیامکی.
     */
    public function create(Request $request): View
    {
        $pending = $request->session()->get('otp_pending');

        if (! $pending) {
            return redirect()->route('login');
        }

        return view('auth.otp-verify', [
            'phone' => $pending['phone'],
            'purpose' => $pending['purpose'],
        ]);
    }

    /**
     * ارسال مجدد کد.
     */
    public function resend(Request $request): RedirectResponse
    {
        $pending = $request->session()->get('otp_pending');

        if (! $pending) {
            return redirect()->route('login');
        }

        $this->otpService->send($pending['phone'], $pending['purpose'], $pending);

        return back()->with('status', 'کد تأیید جدید ارسال شد.');
    }

    /**
     * بررسی کد وارد شده و تکمیل ورود / ثبت‌نام.
     */
    public function store(Request $request): RedirectResponse
    {
        $pending = $request->session()->get('otp_pending');

        if (! $pending) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $otp = $this->otpService->verify(
            $pending['phone'],
            $pending['purpose'],
            $validated['code'],
        );

        if (! $otp) {
            return back()->withErrors(['code' => 'کد وارد شده صحیح نیست یا منقضی شده است.']);
        }

        $user = User::where('phone', $pending['phone'])->first();

        if (! $user) {
            // ثبت‌نام: کاربر جدید ساخته می‌شود
            $user = User::create([
                'name' => $otp->name ?: 'کاربر',
                'phone' => $otp->phone,
                'email' => $otp->email,
                'password' => $otp->password,
                'is_seller' => true,
                'seller_status' => 'approved',
            ]);
        }

        $request->session()->forget('otp_pending');
        $request->session()->regenerate();

        Auth::login($user, remember: true);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }
}
