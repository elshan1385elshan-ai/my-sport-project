<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->product_id;

        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        session()->put('cart', $cart);

        $total = array_sum($cart);

        return redirect()->back()->with('success', "کالا به سبد خرید اضافه شد (تعداد کل: $total)");
    }

    public function show()
    {
        $cart = session()->get('cart', []);

        $products = Product::with(['images', 'category'])
            ->whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        return view('cart.show', compact('products', 'cart'));
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        unset($cart[$request->product_id]);

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'کالا از سبد خرید حذف شد');
    }

    public function decrease(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->product_id;

        if (isset($cart[$id])) {
            $cart[$id]--;
            if ($cart[$id] <= 0) {
                unset($cart[$id]);
            }
        }

        session()->put('cart', $cart);

        return redirect()->back();
    }

    public function count()
    {
        return array_sum(session()->get('cart', []));
    }
}
