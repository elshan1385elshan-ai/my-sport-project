<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class CategoryShowController extends Controller
{
    public function show(Category $category)
    {
       $products = Product::with(['images', 'category'])
            ->where('category_id', $category->id)
            ->latest()
            ->get();

        return view('category.show', compact('category', 'products'));
    }
}

