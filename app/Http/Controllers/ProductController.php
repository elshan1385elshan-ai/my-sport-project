<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SportImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private function jalaliToGregorian($jalaliDate): ?\Carbon\Carbon
    {
        $jalaliDate = trim($jalaliDate);
        $time = '00:00:00';
        if (preg_match('/(\d{4}\/\d{1,2}\/\d{1,2})\s+(\d{1,2}):(\d{1,2})/', $jalaliDate, $m)) {
            $jalaliDate = $m[1];
            $time = sprintf('%02d:%02d:00', (int)$m[2], (int)$m[3]);
        }
        $parts = explode('/', str_replace(['\\', '-', '.'], '/', $jalaliDate));
        if (count($parts) !== 3) return null;
        $jY = (int)$parts[0];
        $jM = (int)$parts[1];
        $jD = (int)$parts[2];
        if ($jY < 1300 || $jY > 1500 || $jM < 1 || $jM > 12 || $jD < 1 || $jD > 31) return null;
        $baseJalali = \Carbon\Carbon::create(2024, 3, 20);
        $daysInJalaliMonth = [0,31,31,31,31,31,31,30,30,30,30,30,29];
        if ($jY % 4 === 3) $daysInJalaliMonth[12] = 30;
        $totalDays = 0;
        for ($y = 1403; $y < $jY; $y++) { $totalDays += ($y % 4 === 3) ? 366 : 365; }
        for ($m2 = 1; $m2 < $jM; $m2++) { $totalDays += $daysInJalaliMonth[$m2]; }
        $totalDays += $jD - 1;
        $gregorian = $baseJalali->copy()->addDays($totalDays);
        list($h, $mi, $s) = explode(':', $time);
        $gregorian->setTime((int)$h, (int)$mi, (int)$s);
        return $gregorian;
    }

    private function shamsiToGregorian(?string $date): ?\Carbon\Carbon
    {
        if (empty($date)) return null;
        $date = trim($date);
        if (preg_match('/^1[34]\d{2}\//', $date)) {
            $date = str_replace(['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'], ['0','1','2','3','4','5','6','7','8','9'], $date);
            $date = str_replace(['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'], ['0','1','2','3','4','5','6','7','8','9'], $date);
            return $this->jalaliToGregorian($date);
        }
        try { return \Carbon\Carbon::parse($date); } catch (\Exception $e) { return null; }
    }

    private function normalizePersianNumerals(?string $value): ?string
    {
        if ($value === null) return null;
        return str_replace(['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'], ['0','1','2','3','4','5','6','7','8','9'], $value);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('user', 'categories', 'images')->latest()->paginate(5);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('childrenRecursive')->whereNull('parent_id')->get();
        $brands = Brand::all();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'discount' => $this->normalizePersianNumerals($request->input('discount')),
            'discount_ends_at' => $this->normalizePersianNumerals($request->input('discount_ends_at')),
        ]);

        $request->validate([
            'name' => 'required|unique:products,name',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|integer',
            'discount_ends_at' => 'nullable|date',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'feature_values' => 'required|array',
            'feature_values.*' => 'exists:feature_values,id',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ],
        [
           'name.required' => 'وارد کردن نام محصول الزامی است.',
           'name.unique'   => 'محصولی با این نام قبلاً ثبت شده است.',
           'price.required' => 'وارد کردن قیمت محصول الزامی است.',
           'price.numeric'   => 'قیمت محصول را صحیح وارد کن.',
           'categories.required' => 'حداقل یک دسته‌بندی برای محصول انتخاب کنید.',
           'feature_values.required' => 'حداقل یک مقدار ویژگی برای محصول انتخاب کنید.',
           'feature_values.array' => 'مقادیر ویژگی‌ها باید آرایه باشند.',
        ]);

        $discountEndsAt = $this->shamsiToGregorian($request->input('discount_ends_at'));

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->discount ?? 0,
            'discount_ends_at' => $discountEndsAt,
            'slug' => \Str::slug($request->name),
            'brand_id' => $request->brand_id,
            'user_id' => auth()->id(),
            'description' => $request->description,
        ]);

        $product->categories()->sync($request->categories);

        $product->featureValues()->sync($request->feature_values);

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
        $product->load(['images', 'categories', 'user.shopAddress', 'featureValues.feature', 'reviews.user']);

        $relatedIds = $product->categories->pluck('id');
        $relatedProducts = Product::whereHas('categories', function ($query) use ($relatedIds) {
            $query->whereIn('categories.id', $relatedIds);
        })
        ->where('id', '!=', $product->id)
        ->latest()
        ->limit(3)
        ->get();

        $avgRating = round($product->reviews->avg('rating'), 1);
        $reviews = $product->reviews;
        $userReview = auth()->check()
            ? $reviews->firstWhere('user_id', auth()->id())
            : null;

        return view('product.show', compact('product', 'relatedProducts', 'avgRating', 'reviews', 'userReview'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::with('childrenRecursive')->whereNull('parent_id')->get();
        $brands = Brand::all();
        $selectedCategories = $product->categories()->pluck('categories.id')->toArray();

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'selectedCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->merge([
            'discount' => $this->normalizePersianNumerals($request->input('discount')),
            'discount_ends_at' => $this->normalizePersianNumerals($request->input('discount_ends_at')),
        ]);

        $request->validate([
            'name' => 'required|unique:products,name,'.$product->id,
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|integer',
            'discount_ends_at' => 'nullable|date',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'feature_values' => 'required|array',
            'feature_values.*' => 'exists:feature_values,id',
            'brand_id' => 'nullable|exists:brands,id',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'نام محصول الزامی است.',
            'name.unique' => 'این محصول قبلاً ثبت شده است.',
            'price.required' => 'قیمت محصول الزامی است.',
            'price.numeric' => 'قیمت باید عدد باشد.',
            'categories.required' => 'حداقل یک دسته‌بندی برای محصول انتخاب کنید.',
            'feature_values.required' => 'حداقل یک مقدار ویژگی برای محصول انتخاب کنید.',
            'feature_values.array' => 'مقادیر ویژگی‌ها باید آرایه باشند.',
        ]);

        $discountEndsAt = $this->shamsiToGregorian($request->input('discount_ends_at'));

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->discount ?? 0,
            'discount_ends_at' => $discountEndsAt,
            'slug' => \Str::slug($request->name),
            'brand_id' => $request->brand_id,
            'description' => $request->description,
        ]);

        $product->categories()->sync($request->categories);

        $product->featureValues()->sync($request->feature_values);

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

        $products = Product::with('images', 'categories')->where('name', 'LIKE', "%{$query}%")->orWhere('price', 'LIKE', "%{$query}%")->paginate(10);

        return view('search.results', compact('query', 'products'));
    }
}
