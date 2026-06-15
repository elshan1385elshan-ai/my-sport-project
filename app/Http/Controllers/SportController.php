<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;
use App\Models\Category;
class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sport = Sport::with('user')->latest()->paginate(5);
        return view('admin.sports.index' , compact('sport'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.sports.create' , compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ۱. اعتبارسنجی (Validation)
        $request->validate([
            'name'     => 'required|unique:sports,name', // بررسی منحصر‌به‌فرد بودن نام در جدول sports
            'category_id' => 'required|exists:categories,id',
            'price'    => 'required|numeric',
            'discount' => 'nullable|numeric',
            'image'    => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // فقط عکس و حداکثر ۲ مگابایت
        ], [
            // پیام‌های فارسی برای کاربر
            'name.unique' => 'این نام محصول قبلاً ثبت شده است.',
            'name.required' => 'وارد کردن نام محصول الزامی است.',
            'image.required' => 'لطفاً یک تصویر انتخاب کنید.',
            'image.image' => 'فایل انتخاب شده باید یک تصویر معتبر باشد.',
        ]);

        // ۲. اگر اعتبارسنجی موفق بود، کد زیر اجرا می‌شود
        
        // آپلود عکس
        $path = $request->file('image')->store('sports', 'public');

        // ذخیره در دیتابیس
        Sport::create([
            'name'     => $request->name,
            'price'    => $request->price,
            'category_id' => $request->category_id,
            'discount' => $request->discount,
            'image'    => $path,
        ]);

        return redirect()->route('sport.index')->with('success', 'محصول با موفقیت ثبت شد!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport)
    {
        $sport->delete();
        return redirect()->route('sport.index');
    }
}
