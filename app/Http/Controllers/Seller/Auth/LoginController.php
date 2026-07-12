<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:seller')->except('logout');
    }

    public function showLoginForm()
    {
        return view('seller.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('seller')->attempt($credentials, $request->filled('remember'))) {
            $user = Auth::guard('seller')->user();

            if (! $user->isApprovedSeller()) {
                Auth::guard('seller')->logout();

                return back()->withErrors(['email' => 'حساب فروشنده شما هنوز تأیید نشده یا معلق است.']);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('seller.dashboard'));
        }

        return back()->withErrors(['email' => 'اطلاعات ورود نادرست است.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('seller')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('seller.login');
    }
}
