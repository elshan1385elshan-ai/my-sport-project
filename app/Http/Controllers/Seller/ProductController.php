<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SportImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }

    public function index()
    {
        $products = auth()->guard('seller')->user()->products()
            ->with(['category', 'images'])
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = auth()->guard('seller')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'user_id' => $user->id,
            'is_active' => true,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('products', $fileName, 'public');

                SportImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'products/' . $fileName,
                ]);
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'محصول با موفقیت ثبت شد!');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'is_active' => $request->boolean('is_active'),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('products', $fileName, 'public');

                SportImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'products/' . $fileName,
                ]);
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'محصول با موفقیت به‌روزرسانی شد!');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();
        return redirect()->route('seller.products.index')->with('success', 'محصول حذف شد!');
    }

    public function deleteImage(Product $product, SportImage $image)
    {
        $this->authorize('update', $product);

        if ($image->product_id !== $product->id) {
            abort(403);
        }

        \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }
}