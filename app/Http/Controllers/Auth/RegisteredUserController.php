<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request, \App\Services\OtpService $otpService): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $phone = $request->string('phone')->toString();

        // ارسال کد تأیید پیامکی و هدایت به صفحه ورود کد؛
        // کاربر فقط پس از تأیید کد ساخته و وارد می‌شود.
        $otpService->send($phone, 'register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $request->session()->put('otp_pending', [
            'phone' => $phone,
            'purpose' => 'register',
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('otp.verify');
    }
}
