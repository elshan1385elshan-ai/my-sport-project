<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();

        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'وارد کردن نام دسته‌بندی الزامی است.',
            'name.unique' => 'این نام قبلاً ثبت شده است.',
            'parent_id.exists' => 'دسته‌بندی والد معتبر نیست.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'دسته‌بندی با موفقیت ثبت شد!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with('products.images')->findOrFail($id);
        $products = $category->products()->latest()->paginate(12);

        return view('category.show', compact('category', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::query()->findOrFail($id);
        $categories = Category::whereNull('parent_id')->where('id', '!=', $id)->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::query()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|unique:categories,name,'.$category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'وارد کردن نام دسته‌بندی الزامی است.',
            'name.unique' => 'این نام قبلاً ثبت شده است.',
            'parent_id.exists' => 'دسته‌بندی والد معتبر نیست.',
        ]);

        if ($request->hasFile('image')) {
            if ($category->image && \Storage::disk('public')->exists($category->image)) {
                \Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'دسته‌بندی با موفقیت بروزرسانی شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::query()->findOrFail($id);

        if ($category->image && \Storage::disk('public')->exists($category->image)) {
            \Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'دسته‌بندی با موفقیت حذف شد!');
    }
}
