<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Feature;
use App\Models\FeatureValue;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::withCount('values')->latest()->paginate(10);

        return view('admin.features.index', compact('features'));
    }

    public function create()
    {
        $categories = Category::with('childrenRecursive')->whereNull('parent_id')->get();

        return view('admin.features.create', compact('categories'));
    }

    public function values(Feature $feature)
    {
        $feature->load('values');

        return view('admin.features.values', compact('feature'));
    }

    public function storeValue(Request $request, Feature $feature)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);

        $sortOrder = $feature->values()->max('sort_order') + 1;

        $feature->values()->create([
            'value' => trim($request->value),
            'sort_order' => $sortOrder,
        ]);

        return redirect()->route('features.values', $feature->id)
            ->with('success', 'مقدار جدید با موفقیت اضافه شد');
    }

    public function updateValue(Request $request, FeatureValue $value)
    {
        $request->validate([
            'value' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $value->update([
            'value' => trim($request->value),
            'sort_order' => $request->input('sort_order', $value->sort_order),
        ]);

        return redirect()->route('features.values', $value->feature_id)
            ->with('success', 'مقدار با موفقیت ویرایش شد');
    }

    public function destroyValue(FeatureValue $value)
    {
        $featureId = $value->feature_id;
        $value->delete();

        return redirect()->route('features.values', $featureId)
            ->with('success', 'مقدار با موفقیت حذف شد');
    }

    public function byCategory(Category $category)
    {
        $features = $category->features()
            ->with('values')
            ->orderBy('name')
            ->get();

        return response()->json($features);
    }

    public function byCategories(Request $request)
    {
        $categoryIds = $request->input('category_ids', []);

        if (empty($categoryIds)) {
            return response()->json([]);
        }

        $features = Feature::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        })
        ->with('values')
        ->orderBy('name')
        ->get();

        $merged = [];
        foreach ($features as $feature) {
            $name = $feature->name;
            if (! isset($merged[$name])) {
                $merged[$name] = [
                    'name' => $name,
                    'values' => collect(),
                ];
            }
            $merged[$name]['values'] = $merged[$name]['values']->merge($feature->values);
        }

        $result = [];
        foreach ($merged as $item) {
            $result[] = [
                'name' => $item['name'],
                'values' => $item['values']->unique('id')->values(),
            ];
        }

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:features,name',
        ]);

        $feature = Feature::create(['name' => $request->name]);

        if ($request->filled('categories')) {
            $feature->categories()->sync($request->categories);
        }

        if ($request->filled('values')) {
            foreach (array_filter($request->values) as $index => $value) {
                $feature->values()->create([
                    'value' => trim($value),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('features.index')->with('success', 'ویژگی با موفقیت ایجاد شد');
    }

    public function edit(Feature $feature)
    {
        $feature->load('values');
        $feature->load('categories');

        $categories = Category::with('childrenRecursive')->whereNull('parent_id')->get();

        return view('admin.features.edit', compact('feature', 'categories'));
    }

    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:features,name,' . $feature->id,
        ]);

        $feature->update(['name' => $request->name]);

        $feature->categories()->sync($request->categories ?? []);

        $feature->values()->delete();

        if ($request->filled('values')) {
            foreach (array_filter($request->values) as $index => $value) {
                $feature->values()->create([
                    'value' => trim($value),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('features.index')->with('success', 'ویژگی با موفقیت ویرایش شد');
    }

    public function destroy(Feature $feature)
    {
        $feature->values()->delete();
        $feature->delete();

        return redirect()->route('features.index')->with('success', 'ویژگی با موفقیت حذف شد');
    }
}
