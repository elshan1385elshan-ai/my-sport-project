<?php

namespace App\Http\Controllers;

use App\Models\Feature;
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
        return view('admin.features.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:features,name',
        ]);

        $feature = Feature::create(['name' => $request->name]);

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

        return view('admin.features.edit', compact('feature'));
    }

    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:features,name,' . $feature->id,
        ]);

        $feature->update(['name' => $request->name]);

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
