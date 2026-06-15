<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * جستجوی زنده (Live Search)
     */
    public function liveSearch(Request $request)
    {
        $query = $request->get('q');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('brand', 'LIKE', "%{$query}%")
                    ->select('id', 'name', 'brand', 'price', 'image')
                    ->limit(10)
                    ->get();

        return response()->json($products);
    }

    // متدهای آینده (مثلاً نمایش همه محصولات)
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }
}