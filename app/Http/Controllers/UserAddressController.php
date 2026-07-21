<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserAddressController extends Controller
{
    public function create(): View
    {
        return view('profile.address-create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
        ]);

        $data['user_id'] = Auth::id();

        UserAddress::create($data);

        return redirect()->route('profile.address.show')->with('success', 'آدرس با موفقیت ذخیره شد.');
    }

    public function show(): View
    {
        $address = UserAddress::where('user_id', Auth::id())->first();
        return view('profile.address-show', compact('address'));
    }

    public function edit(): View
    {
        $address = UserAddress::where('user_id', Auth::id())->first();
        return view('profile.address-edit', compact('address'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
        ]);

        UserAddress::where('user_id', Auth::id())->update($data);

        return redirect()->route('profile.address.show')->with('success', 'آدرس با موفقیت به‌روزرسانی شد.');
    }
}
