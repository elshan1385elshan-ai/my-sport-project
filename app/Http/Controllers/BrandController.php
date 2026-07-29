<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(10);

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('brands', 'public');
        }

        Brand::create($validated);

        return redirect()->route('brands.index')->with('success', 'برند با موفقیت ایجاد شد');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($brand->image && \Storage::disk('public')->exists($brand->image)) {
                \Storage::disk('public')->delete($brand->image);
            }
            $validated['image'] = $request->file('image')->store('brands', 'public');
        }

        $brand->update($validated);

        return redirect()->route('brands.index')->with('success', 'برند با موفقیت ویرایش شد');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->image && \Storage::disk('public')->exists($brand->image)) {
            \Storage::disk('public')->delete($brand->image);
        }

        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'برند با موفقیت حذف شد');
    }

    public function show(Brand $brand)
    {
        $brand->load('products.images');
        $products = $brand->products()->latest()->paginate(12);

        return view('brand.show', compact('brand', 'products'));
    }
}
