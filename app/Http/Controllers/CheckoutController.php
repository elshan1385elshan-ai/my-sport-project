<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use App\Models\Order;

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
        $address = '';
        if ($request->delivery_choice=="saved"){
            $useraddress = auth()->user()->address;
            $address = $useraddress->province.' '.$useraddress->city.' '.$useraddress->address.' ';   
        }
        else{
            $address = $request->delivery_lat.','.$request->delivery_lng;
        }
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'shipping_address' => $address
        ]);
        $total = 0;
        foreach ($cart as $id => $q) {
            $product = Product::findOrFail($id);
            $price = round($product->price*$q*(100-$product->discount)/100);
            $total += $price;
            $order->items()->create([
                'product_id'=>$id,
                'quantity'=>$q,
                'price'=>$price
            ]) ; 
        }
        $order->total=$total;
        $order->save();
        session()->forget('cart');
        // Create new invoice.
        $invoice = (new Invoice)->amount($total);
        if($request->payment_method=='online'){ 
            return Payment::purchase($invoice,function($driver, $transactionId) use($order) {
                $order->transaction_id=$transactionId;
                $order->save();
            })->pay()->render();
        }
        // Purchase the given invoice.
        // فعلاً فرآیند خرید در همین‌جا خاتمه می‌یابد؛ منطق ثبت سفارش بعداً اضافه می‌شود
        return redirect()->route('home')->with('success', 'شیوه پرداخت شما ثبت شد.');
    }

    /**
     * بازگشت از درگاه پرداخت (callback) و تأیید تراکنش
     */
    public function callback(Request $request)
    {
        try {
            if($request->Status=='OK'){
                $transaction_id = $request->Authority;
                // در حالت آنلاین باید وضعیت تراکنش چک شود. 
                $order = Order::where('transaction_id',$transaction_id)->first();
                $order->payment_status = 'paid';
                $order->save();
                return redirect()->route('home')->with('success',
                    'پرداخت با موفقیت انجام شد. '
                );
            }
            else{
                return redirect()->route('cart.show')->with('error','پرداخت ناموفق بود. ');    
            }
            //$receipt = Payment::amount(1000)->verify();

        } catch (InvalidPaymentException $e) {
            return redirect()->route('cart.show')->with('error','پرداخت ناموفق بود. ');  
        }
    }
}
