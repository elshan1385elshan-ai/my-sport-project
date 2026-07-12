<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function home()
    {
        $products = Product::with(['images', 'category'])
            ->latest()
            ->limit(12)
            ->get();

        $categories = Category::whereNull('parent_id')->with('children')->select(['id', 'name'])->get();

        return view('home', compact('products', 'categories'));
    }
}
