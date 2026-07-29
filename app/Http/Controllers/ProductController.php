<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SportImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // // متدهای آینده (مثلاً نمایش همه محصولات)
    // public function index()
    // {
    //     $products = Product::all();
    //     return view('products.index', compact('products'));
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('user', 'category', 'images')->latest()->paginate(5);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ],
        [
           'name.required' => 'وارد کردن نام محصول الزامی است.',
           'name.unique'   => 'محصولی با این نام قبلاً ثبت شده است.',
           'price.required' => 'وارد کردن قیمت محصول الزامی است.',
           'price.numeric'   => 'قیمت محصول را صحیح وارد کن.',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->discount ?? 0,
            'slug' => \Str::slug($request->name),
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'user_id' => auth()->id(),
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $fileName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();

                $image->storeAs(
                    'products',
                    $fileName,
                    'public'
                );

                SportImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'products/'.$fileName,
                ]);
            }
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'محصول با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['images', 'category', 'user.shopAddress']);

        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:products,name,'.$product->id,
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'نام محصول الزامی است.',
            'name.unique' => 'این محصول قبلاً ثبت شده است.',
            'price.required' => 'قیمت محصول الزامی است.',
            'price.numeric' => 'قیمت باید عدد باشد.',
            'descriotion.required' => 'توضیحات محصول وارد شده الزامی است.',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->discount ?? 0,
            'slug' => \Str::slug($request->name),
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $fileName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();

                $image->storeAs(
                    'products',
                    $fileName,
                    'public'
                );

                SportImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'products/'.$fileName,
                ]);
            }
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'محصول با موفقیت به‌روزرسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }

    // /**
    //  * جستجوی زنده (Live Search)
    //  */
    public function liveSearch(Request $request)
    {
        $query = $request->get('q');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::with('images', 'category')->where('name', 'LIKE', "%{$query}%")->orWhere('price', 'LIKE', "%{$query}%")->paginate(10);

        return view('search.results', compact('query', 'products'));
    }
}
