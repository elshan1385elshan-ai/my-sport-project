<?php

namespace App\Http\Controllers;

use App\Models\ShopAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function create()
    {
        return view('admin.address.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
        ]);

        ShopAddress::updateOrCreate(
            ['admin_id' => auth('admin')->id()],
            $request->only('address', 'city', 'province', 'postal_code', 'phone')
        );

        return redirect()->route('address.show')->with('success', 'آدرس فروشگاه با موفقیت ثبت شد');
    }

    public function show()
    {
        $address = ShopAddress::where('admin_id', auth('admin')->id())->first();

        return view('admin.address.show', compact('address'));
    }

    public function edit()
    {
        $address = ShopAddress::where('admin_id', auth('admin')->id())->firstOrFail();

        return view('admin.address.edit', compact('address'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
        ]);

        $address = ShopAddress::where('admin_id', auth('admin')->id())->firstOrFail();
        $address->update($request->only('address', 'city', 'province', 'postal_code', 'phone'));

        return redirect()->route('address.show')->with('success', 'آدرس فروشگاه با موفقیت ویرایش شد');
    }
}
