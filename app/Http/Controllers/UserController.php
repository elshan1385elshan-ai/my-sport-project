<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $ordersCount = Order::where('user_id', $user->id)->count();
        $recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();

        return view('user.dashboard', compact('user', 'ordersCount', 'recentOrders'));
    }
}
