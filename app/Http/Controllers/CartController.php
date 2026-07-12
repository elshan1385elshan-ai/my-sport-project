<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $cart = session()->get('cart', []);

        $cart[] = $request->product_id;

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'کالا به سبد خرید اضافه شد');
    }

    public function show()
    {
        $cart = session()->get('cart', []);

        $products = Product::with(['images', 'category'])
            ->whereIn('id', $cart)
            ->get();

        return view('cart.show', compact('products'));
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        $key = array_search($request->product_id, $cart);
        if ($key !== false) {
            unset($cart[$key]);
            $cart = array_values($cart);
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'کالا از سبد خرید حذف شد');
    }

    public function count()
    {
        return count(session()->get('cart', []));
    }
}
