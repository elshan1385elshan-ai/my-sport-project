<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public function index()
    {
        $address = UserAddress::where('user_id', auth()->id())->first();

        return view('user.address.index', compact('address'));
    }

    public function create()
    {
        $address = UserAddress::where('user_id', auth()->id())->first();

        if ($address) {
            return redirect()->route('addresses.edit', $address->id)
                ->with('info', 'شما قبلاً یک آدرس ثبت کرده‌اید. می‌توانید آن را ویرایش کنید.');
        }

        return view('user.address.create');
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

        UserAddress::create([
            'user_id' => auth()->id(),
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'phone' => $request->phone,
        ]);

        return redirect()->route('addresses.index')->with('success', 'آدرس با موفقیت ثبت شد');
    }

    public function show($id)
    {
        return redirect()->route('addresses.index');
    }

    public function edit($id)
    {
        $address = UserAddress::where('user_id', auth()->id())->findOrFail($id);

        return view('user.address.edit', compact('address'));
    }

    public function update(Request $request, $id)
    {
        $address = UserAddress::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
        ]);

        $address->update($request->only('address', 'city', 'province', 'postal_code', 'phone'));

        return redirect()->route('addresses.index')->with('success', 'آدرس با موفقیت ویرایش شد');
    }

    public function destroy($id)
    {
        $address = UserAddress::where('user_id', auth()->id())->findOrFail($id);
        $address->delete();

        return redirect()->route('addresses.index')->with('success', 'آدرس با موفقیت حذف شد');
    }
}
