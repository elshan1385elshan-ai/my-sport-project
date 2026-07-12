<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }

    public function index()
    {
        $seller = auth()->guard('seller')->user();
        $orders = Order::whereHas('items.product', fn($q) => $q->where('user_id', $seller->id))
            ->with(['items.product', 'user'])
            ->latest()
            ->paginate(15);

        return view('seller.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $seller = auth()->guard('seller')->user();
        $order->load(['items.product', 'user', 'address']);
        
        $sellerItems = $order->items->where('product.user_id', $seller->id);
        if ($sellerItems->isEmpty()) {
            abort(403);
        }

        return view('seller.orders.show', compact('order', 'sellerItems'));
    }

    public function update(Request $request, Order $order)
    {
        $seller = auth()->guard('seller')->user();
        $sellerItems = $order->items->where('product.user_id', $seller->id);
        
        if ($sellerItems->isEmpty()) {
            abort(403);
        }

        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'وضعیت سفارش به‌روزرسانی شد!');
    }
}