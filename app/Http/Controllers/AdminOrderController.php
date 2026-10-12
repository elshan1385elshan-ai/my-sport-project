<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public const STATUSES = [
        'pending'    => 'در انتظار پرداخت',
        'processing' => 'در حال پردازش',
        'shipped'    => 'ارسال شده',
        'delivered'  => 'تحویل شده',
        'cancelled'  => 'لغو شده',
    ];

    public function index(Request $request)
    {
        $status = $request->query('status');

        $orders = Order::with('user', 'items', 'products')
            ->when($status && array_key_exists($status, self::STATUSES), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders'   => $orders,
            'statuses' => self::STATUSES,
            'selected' => $status,
        ]);
    }
    public function show(Order $order){
        $order->load('user', 'items.product');
        return view('admin.orders.show', [
            'order'    => $order,
            'statuses' => self::STATUSES,
        ]);
    }
}
