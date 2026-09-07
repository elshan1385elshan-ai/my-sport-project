<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private const SUCCESS_MESSAGES = [
        'applied' => 'کد تخفیف با موفقیت اعمال شد',
        'removed' => 'کد تخفیف حذف شد',
    ];

    private function normalizePersianNumerals(?string $value): ?string
    {
        if ($value === null) return null;
        return str_replace(['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'], ['0','1','2','3','4','5','6','7','8','9'], $value);
    }

    private function jalaliToGregorian($jalaliDate): ?\Carbon\Carbon
    {
        $jalaliDate = trim($jalaliDate);
        $time = '00:00:00';
        if (preg_match('/(\d{4}\/\d{1,2}\/\d{1,2})\s+(\d{1,2}):(\d{1,2})/', $jalaliDate, $m)) {
            $jalaliDate = $m[1];
            $time = sprintf('%02d:%02d:00', (int)$m[2], (int)$m[3]);
        }
        $parts = explode('/', str_replace(['\\', '-', '.'], '/', $jalaliDate));
        if (count($parts) !== 3) return null;
        $jY = (int)$parts[0];
        $jM = (int)$parts[1];
        $jD = (int)$parts[2];
        if ($jY < 1300 || $jY > 1500 || $jM < 1 || $jM > 12 || $jD < 1 || $jD > 31) return null;
        $baseJalali = \Carbon\Carbon::create(2024, 3, 20);
        $daysInJalaliMonth = [0,31,31,31,31,31,31,30,30,30,30,30,29];
        if ($jY % 4 === 3) $daysInJalaliMonth[12] = 30;
        $totalDays = 0;
        for ($y = 1403; $y < $jY; $y++) { $totalDays += ($y % 4 === 3) ? 366 : 365; }
        for ($m2 = 1; $m2 < $jM; $m2++) { $totalDays += $daysInJalaliMonth[$m2]; }
        $totalDays += $jD - 1;
        $gregorian = $baseJalali->copy()->addDays($totalDays);
        list($h, $mi, $s) = explode(':', $time);
        $gregorian->setTime((int)$h, (int)$mi, (int)$s);
        return $gregorian;
    }

    private function shamsiToGregorian(?string $date): ?\Carbon\Carbon
    {
        if (empty($date)) return null;
        $date = trim($date);
        if (preg_match('/^1[34]\d{2}\//', $date)) {
            $date = $this->normalizePersianNumerals($date);
            return $this->jalaliToGregorian($date);
        }
        try { return \Carbon\Carbon::parse($date); } catch (\Exception $e) { return null; }
    }

    /* -------------------- Admin CRUD -------------------- */

    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'value' => $this->normalizePersianNumerals($request->input('value')),
            'min_order_amount' => $this->normalizePersianNumerals($request->input('min_order_amount')),
            'max_discount' => $this->normalizePersianNumerals($request->input('max_discount')),
            'usage_limit' => $this->normalizePersianNumerals($request->input('usage_limit')),
            'starts_at' => $this->normalizePersianNumerals($request->input('starts_at')),
            'ends_at' => $this->normalizePersianNumerals($request->input('ends_at')),
        ]);

        $data = $this->validatedData($request);
        $data['is_active'] = $request->boolean('is_active');

        Coupon::create($data);

        return redirect()->route('admin.coupons.index')->with('success', 'کوپن با موفقیت ایجاد شد');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->merge([
            'value' => $this->normalizePersianNumerals($request->input('value')),
            'min_order_amount' => $this->normalizePersianNumerals($request->input('min_order_amount')),
            'max_discount' => $this->normalizePersianNumerals($request->input('max_discount')),
            'usage_limit' => $this->normalizePersianNumerals($request->input('usage_limit')),
            'starts_at' => $this->normalizePersianNumerals($request->input('starts_at')),
            'ends_at' => $this->normalizePersianNumerals($request->input('ends_at')),
        ]);

        $data = $this->validatedData($request, $coupon->id);
        $data['is_active'] = $request->boolean('is_active');

        $coupon->update($data);

        return redirect()->route('admin.coupons.index')->with('success', 'کوپن با موفقیت ویرایش شد');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'کوپن با موفقیت حذف شد');
    }

    private function validatedData(Request $request, ?int $ignoreId = null): array
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code' . ($ignoreId ? ',' . $ignoreId : ''),
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'starts_at' => 'nullable|string',
            'ends_at' => 'nullable|string',
        ], [
            'code.required' => 'وارد کردن کد کوپن الزامی است.',
            'code.unique' => 'این کد کوپن قبلاً ثبت شده است.',
            'type.required' => 'نوع تخفیف را انتخاب کنید.',
            'value.required' => 'وارد کردن مقدار تخفیف الزامی است.',
            'value.numeric' => 'مقدار تخفیف باید عدد باشد.',
            'value.min' => 'مقدار تخفیف نمی‌تواند منفی باشد.',
        ]);

        return [
            'code' => strtoupper(trim($request->code)),
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->filled('min_order_amount') ? $request->min_order_amount : null,
            'max_discount' => $request->filled('max_discount') ? $request->max_discount : null,
            'usage_limit' => $request->filled('usage_limit') ? $request->usage_limit : null,
            'starts_at' => $request->filled('starts_at') ? $this->shamsiToGregorian($request->starts_at) : null,
            'ends_at' => $request->filled('ends_at') ? $this->shamsiToGregorian($request->ends_at) : null,
        ];
    }

    /* -------------------- Cart Integration -------------------- */

    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = strtoupper(trim($request->code));

        $coupon = Coupon::where('code', $code)->first();

        $cart = session()->get('cart', []);
        $subtotal = $this->cartSubtotal($cart);
        if (! $coupon) {
            session()->forget('coupon');
            return redirect()->route('cart.show')->withErrors(['coupon' => 'کد تخفیف معتبر نیست.']);
        }
        if (! $coupon->is_usable) {
            session()->forget('coupon');
            $message = 'این کد تخفیف قابل استفاده نیست.';
            if ($coupon->is_expired) $message = 'مهلت استفاده از این کد تخفیف به پایان رسیده است.';
            elseif ($coupon->is_not_started) $message = 'این کد تخفیف هنوز فعال نشده است.';
            elseif ($coupon->is_exhausted) $message = 'ظرفیت استفاده از این کد تخفیف تکمیل شده است.';
            elseif (! $coupon->is_active) $message = 'این کد تخفیف غیرفعال شده است.';
            return redirect()->route('cart.show')->withErrors(['coupon' => $message]);
        }

        if ($coupon->min_order_amount !== null && $subtotal < $coupon->min_order_amount) {
            session()->forget('coupon');
            return redirect()->route('cart.show')->withErrors(['coupon' => 'حداقل مبلغ سفارش برای استفاده از این کد، ' . number_format($coupon->min_order_amount) . ' تومان است.']);
        }

        session()->put('coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
        ]);

        return redirect()->route('cart.show')->with('success', self::SUCCESS_MESSAGES['applied']);
    }

    public function remove()
    {
        session()->forget('coupon');

        return redirect()->route('cart.show')->with('success', self::SUCCESS_MESSAGES['removed']);
    }

    /* -------------------- Helpers (public for cart view) -------------------- */

    public static function cartSubtotal(array $cart): float
    {
        $products = Product::with('images')
            ->whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        $total = 0;
        foreach ($cart as $id => $quantity) {
            $product = $products->get($id);
            if (! $product) continue;
            $total += $product->discounted_price * $quantity;
        }

        return (float) $total;
    }

    public static function calculateDiscountForSubtotal(Coupon $coupon, float $subtotal): float
    {
        if ($coupon->type === 'fixed') {
            return min($coupon->value, $subtotal);
        }

        $discount = $subtotal * ($coupon->value / 100);
        if ($coupon->max_discount !== null) {
            $discount = min($discount, (float) $coupon->max_discount);
        }

        return (float) $discount;
    }
}
