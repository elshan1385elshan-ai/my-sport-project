<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request, \App\Services\OtpService $otpService): RedirectResponse
    {
        $request->ensureIsNotRateLimited();

        $phone = $request->string('phone')->toString();

        $user = \App\Models\User::where('phone', $phone)->first();

        if ($user && ! empty($user->password)) {
            // کاربر رمز عبور دارد؛ ابتدا اعتبار آن بررسی می‌شود
            if (! \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
                \Illuminate\Support\Facades\RateLimiter::hit($request->throttleKey());

                throw \Illuminate\Validation\ValidationException::withMessages([
                    'password' => trans('auth.failed'),
                ]);
            }
        } elseif (! $user && $request->filled('password')) {
            // شماره ثبت نشده و رمز هم وارد شده؛ ثبت‌نام با رمز ممکن نیست
            throw \Illuminate\Validation\ValidationException::withMessages([
                'phone' => 'این شماره تلفن ثبت نشده است. لطفاً ثبت‌نام کنید.',
            ]);
        }

        // ارسال کد تأیید پیامکی و هدایت به صفحه ورود کد
        $otpService->send($phone, 'login', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $request->session()->put('otp_pending', [
            'phone' => $phone,
            'purpose' => 'login',
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('otp.verify');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
