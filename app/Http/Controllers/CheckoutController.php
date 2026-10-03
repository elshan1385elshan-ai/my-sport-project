<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class CheckoutController extends Controller
{
    /**
     * نمایش صفحه انتخاب شیوه پرداخت
     */
    public function payment()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.show')->with('info', 'سبد خرید شما خالی است.');
        }

        $products = Product::with(['images', 'categories'])
            ->whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        $subtotal = 0;
        foreach ($cart as $id => $quantity) {
            $product = $products->get($id);
            if (! $product) {
                continue;
            }
            $subtotal += $product->discounted_price * $quantity;
        }

        $couponData = session()->get('coupon');
        $coupon = null;
        $couponDiscount = 0;

        if ($couponData && isset($couponData['id'])) {
            $coupon = Coupon::find($couponData['id']);
            if ($coupon && $coupon->is_usable && ($coupon->min_order_amount === null || $subtotal >= $coupon->min_order_amount)) {
                $couponDiscount = CouponController::calculateDiscountForSubtotal($coupon, (float) $subtotal);
            }
        }

        $total = (float) $subtotal - (float) $couponDiscount;

        // آدرس کاربر (برای نمایش نقشه شهر در پرداخت حضوری)
        $user = auth()->user();
        $address = $user ? $user->address : null;
        $hasCity = $address && !empty(trim((string) ($address->city ?? '')));

        // اگر شهر ثبت شده بود از آن استفاده می‌شود، در غیر این صورت پیش‌فرض تهران
        $mapCity = $hasCity ? $address->city : 'تهران';
        $mapProvince = $hasCity ? ($address->province ?? '') : 'تهران';

        return view('checkout.payment', compact('products', 'cart', 'subtotal', 'coupon', 'couponDiscount', 'total', 'address', 'hasCity', 'mapCity', 'mapProvince'));
    }

    /**
     * ثبت شیوه پرداخت انتخاب‌شده و تکمیل فرآیند خرید
     */
    public function complete(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:online,in_person',
        ]);
        $cart = session()->get('cart', []);
        

        // Create new invoice.
        $invoice = (new Invoice)->amount(1000);

        // Purchase the given invoice.
        return Payment::purchase($invoice,function($driver, $transactionId) {
            // We can store $transactionId in database.
        })->pay()->render();
        //foreach($cart as $id => $quantity)
        // return $cart;
        // return $request->all();
        //Order::create()
        // فعلاً فرآیند خرید در همین‌جا خاتمه می‌یابد؛ منطق ثبت سفارش بعداً اضافه می‌شود
        //return redirect()->route('home')->with('success', 'شیوه پرداخت شما ثبت شد.');
    }
}
