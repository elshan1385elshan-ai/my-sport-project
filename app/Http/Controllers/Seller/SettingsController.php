<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }

    public function update(Request $request)
    {
        $user = auth()->guard('seller')->user();

        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_description' => 'nullable|string',
            'shop_slug' => 'nullable|string|max:255|unique:users,shop_slug,' . $user->id,
            'shop_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'shop_social' => 'nullable|json',
        ]);

        if ($request->hasFile('shop_logo')) {
            if ($user->shop_logo) {
                Storage::disk('public')->delete($user->shop_logo);
            }
            $path = $request->file('shop_logo')->store('shops/logos', 'public');
            $validated['shop_logo'] = $path;
        }

        $user->update($validated);

        return back()->with('success', 'تنظیمات فروشگاه به‌روزرسانی شد!');
    }
}