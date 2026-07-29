<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class HomeController extends Controller
{
    public function dashboard()
    {
        $ordersToday = Order::whereDate('created_at', today())->count();
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $newUsersToday = User::whereDate('created_at', today())->count();
        $totalUsers = User::count();
        $activeProducts = Product::where('is_active', true)->count();
        $inactiveProducts = Product::where('is_active', false)->count();
        $pendingOrders = Order::whereIn('status', ['pending', 'processing'])->count();

        return view('admin.dashboard', compact(
            'ordersToday', 'ordersThisMonth', 'totalRevenue',
            'newUsersToday', 'totalUsers',
            'activeProducts', 'inactiveProducts',
            'pendingOrders'
        ));
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

        $childCategories = Category::whereNotNull('parent_id')
            ->where('image', '!=', null)
            ->with('parent')
            ->get();

        $brands = Brand::where('image', '!=', null)->get();

        return view('home', compact('products', 'categories', 'childCategories', 'brands'));
    }
}
