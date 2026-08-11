<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryShowController extends Controller
{
    public function show(Category $category)
    {
        $products = $category->products()->with(['images', 'categories'])->latest()->get();

        return view('category.show', compact('category', 'products'));
    }
}
