@extends('layouts.app')

@section('content')
<main class="container my-5" id="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="sport-title mb-0">سبد خرید</h2>
        @if(count($cart) > 0)
            <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(90deg, #e94560, #ff6b6b); color:#fff;">{{ array_sum($cart) }} کالا</span>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger text-center">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="d-flex flex-column gap-3">
                @foreach($cart as $id => $quantity)
                    @php $product = $products->get($id); @endphp
                    @if(!$product) @continue @endif
                    @php
                        $firstImage = $product->images->first();
                        $unitPrice = $product->discount_active ? $product->discounted_price : $product->price;
                        $lineTotal = $unitPrice * $quantity;
                    @endphp
                    <div class="card sport-cart-card sport-cart-row">
                        <div class="row g-0 align-items-center">
                            <div class="col-4 col-sm-3 position-relative">
                                <a href="{{ route('product.show', $product->id) }}">
                                    <img
                                        src="{{ $firstImage ? asset('storage/'.$firstImage->image_path) : 'https://picsum.photos/400/250' }}"
                                        class="sport-cart-row-img"
                                        alt="{{ $product->name }}">
                                </a>
                                @if($product->discount_active)
                                    <span class="badge sport-cart-discount-badge">-{{ $product->discount }}%</span>
                                @endif
                            </div>

                            <div class="col-8 col-sm-9">
                                <div class="card-body py-3 pe-3">
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div class="flex-grow-1 min-width-0">
                                            <a href="{{ route('product.show', $product->id) }}" class="sport-cart-title text-decoration-none">
                                                <h5 class="card-title mb-1 text-truncate">{{ $product->name }}</h5>
                                            </a>
                                            <span class="badge text-dark border" style="background: rgba(15,52,96,0.08);">
                                                <i class="bi bi-tag"></i> {{ $product->categories->first()->name ?? 'بدون دسته' }}
                                            </span>
                                        </div>
                                        <button type="button" class="sport-cart-remove-btn"
                                                onclick="confirmRemove({{ $product->id }}, '{{ $product->name }}')"
                                                title="حذف از سبد" aria-label="حذف از سبد">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <div class="d-flex justify-content-end align-items-center mt-2">
                                        <div class="text-end">
                                            @if($product->discount_active)
                                                <del class="text-muted small d-block">{{ number_format($product->price) }}</del>
                                            @endif
                                            <div class="fw-bold sport-cart-unit-price">{{ number_format($unitPrice) }} <small class="fw-normal">تومان</small></div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top sport-cart-row-footer">
                                        <div class="d-inline-flex align-items-center gap-1 sport-cart-qty-group">
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="btn btn-sm sport-cart-qty-btn sport-btn-primary"
                                                        title="افزایش تعداد" @disabled($quantity >= $product->stock)>
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                            </form>
                                            <span class="sport-cart-qty-value">{{ $quantity }}</span>
                                            @if($quantity > 1)
                                                <form action="{{ route('cart.decrease') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button type="submit" class="btn btn-sm sport-cart-qty-btn sport-btn-outline" title="کاهش تعداد">
                                                        <i class="bi bi-dash-lg"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" class="btn btn-sm sport-cart-qty-btn sport-btn-outline"
                                                        onclick="confirmRemove({{ $product->id }}, '{{ $product->name }}')" title="حذف از سبد">
                                                    <i class="bi bi-dash-lg"></i>
                                                </button>
                                            @endif
                                        </div>

                                        <div class="text-start">
                                            <small class="text-muted d-block mb-1">
                                                @if($quantity >= $product->stock && $product->stock > 0)
                                                    <i class="bi bi-exclamation-circle text-warning"></i> حداکثر موجودی ({{ number_format($product->stock) }})
                                                @else
                                                    موجودی: {{ number_format($product->stock) }} عدد
                                                @endif
                                            </small>
                                            <div class="sport-cart-line-total">جمع: <strong>{{ number_format($lineTotal) }} تومان</strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card sport-order-summary shadow-sm">
                    <div class="card-header" style="background: linear-gradient(90deg, #0f3460, #1a1a2e); color:#fff;">
                        <i class="bi bi-receipt me-1"></i> خلاصه سفارش
                    </div>
                    <div class="card-body">
                        @if($coupon)
                            <div class="alert alert-success d-flex justify-content-between align-items-center py-2 mb-3">
                                <span class="fw-bold">
                                    <i class="bi bi-ticket-perforated me-1"></i>{{ $coupon->code }}
                                </span>
                                <form action="{{ route('cart.coupon.remove') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="حذف کوپن">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('cart.coupon.apply') }}" method="POST" class="mb-3">
                                @csrf
                                <label class="form-label fw-bold mb-1"><i class="bi bi-ticket-perforated me-1"></i> کد تخفیف (کوپن)</label>
                                <div class="input-group">
                                    <input type="text" name="code" class="form-control" placeholder="کد کوپن را وارد کنید" value="{{ old('code') }}">
                                    <button type="submit" class="btn sport-btn-primary">اعمال</button>
                                </div>
                                <small class="text-muted">در صورت داشتن کد تخفیف، آن را وارد کنید.</small>
                            </form>
                        @endif

                        <hr class="my-3">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">جمع سبد خرید</span>
                            <span>{{ number_format($subtotal) }} تومان</span>
                        </div>

                        @if($couponDiscount > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>تخفیف کوپن</span>
                                <span>-{{ number_format($couponDiscount) }} تومان</span>
                            </div>
                        @endif

                        <hr>

                        <div class="d-flex justify-content-between mb-2 fw-bold fs-5">
                            <span>مبلغ قابل پرداخت</span>
                            <span class="text-danger">{{ number_format(max(0, $total)) }} تومان</span>
                        </div>

                        <a href="{{ auth()->check() ? route('addresses.create') : route('register') }}" class="btn sport-btn-primary w-100 mt-3 sport-cart-checkout-btn">
                            <i class="bi bi-check-circle"></i> تکمیل فرآیند خرید
                        </a>
                        <a href="{{ route('home') }}" class="btn sport-btn-outline w-100 mt-2 sport-cart-action-btn">
                            <i class="bi bi-arrow-right"></i> بازگشت به فروشگاه
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x sport-empty-icon"></i>
            <h4 class="mt-3 text-muted">سبد خرید شما خالی است</h4>
            <a href="{{ route('home') }}" class="btn sport-btn-primary mt-3">مشاهده کالاها</a>
        </div>
    @endif
</main>
@endsection

<form id="removeForm" action="{{ route('cart.remove') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="product_id" id="removeProductId">
</form>

@push('scripts')
<script>
  @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: 'موفق!',
      text: '{{ session("success") }}',
      confirmButtonText: 'باشه',
      confirmButtonColor: '#0f3460',
      timer: 3000,
      timerProgressBar: true
    });
  @endif

function confirmRemove(productId, productName) {
    Swal.fire({
        title: 'حذف از سبد خرید',
        text: 'آیا از حذف "' + productName + '" از سبد خرید خود مطمئن هستید؟',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'بله، حذف کن',
        cancelButtonText: 'انصراف'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('removeProductId').value = productId;
            document.getElementById('removeForm').submit();
        }
    });
}
</script>
@endpush
