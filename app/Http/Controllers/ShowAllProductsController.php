<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShowAllProductsController extends Controller
{
    public function show(){
        $products = Product::with('user','images','categories','brand')
            ->latest()
            ->paginate(15);
        return view('admin.products.show',compact('products'));
    }

    public function outOfStock(){
        $products = Product::with('images','categories','brand')
            ->where('stock', '<=', 0)
            ->latest()
            ->paginate(15);
        return view('admin.products.out-of-stock',compact('products'));
    }
}
