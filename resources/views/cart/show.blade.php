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

    @if(count($cart) > 0)
        <div class="row g-4">
            @foreach($cart as $id => $quantity)
                @php $product = $products->get($id); @endphp
                @if(!$product) @continue @endif
                @php $firstImage = $product->images->first(); @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 sport-cart-card">
                            <div class="position-relative">
                                <img
                                    src="{{ $firstImage ? asset('storage/'.$firstImage->image_path) : 'https://picsum.photos/400/250' }}"
                                    class="card-img-top"
                                    alt="{{ $product->name }}">
                                <button type="button" class="sport-cart-remove-btn"
                                        onclick="confirmRemove({{ $product->id }}, '{{ $product->name }}')"
                                        title="حذف از سبد">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate">{{ $product->name }}</h5>

                                <p class="text-muted small mb-2">
                                    <span class="badge text-dark border" style="background: rgba(15,52,96,0.08);">{{ $product->category->name ?? 'بدون دسته' }}</span>
                                </p>

                                @if($product->description)
                                    <p class="card-text text-secondary small flex-grow-1">{{ $product->description }}</p>
                                @endif

                                <div class="mt-auto pt-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        @if($product->discount > 0)
                                            <del class="text-muted small">{{ number_format($product->price) }} تومان</del>
                                            <span class="text-danger fw-bold fs-5">{{ number_format($product->discounted_price) }} تومان</span>
                                            <span class="badge ms-2" style="background: linear-gradient(90deg, #e94560, #ff6b6b); color:#fff;">-{{ $product->discount }}%</span>
                                        @else
                                            <span class="price-tag fw-bold fs-5">{{ number_format($product->price) }} تومان</span>
                                        @endif
                                    </div>

                                    <div class="d-flex align-items-center gap-2 mb-2 flex-nowrap">
                                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline-flex align-items-center">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="btn btn-sm sport-cart-qty-btn sport-btn-primary">
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                        </form>
                                        <span class="fw-bold fs-5 px-2" style="min-width: 2.5rem; text-align: center;">{{ $quantity }}</span>
                                        @if($quantity > 1)
                                            <form action="{{ route('cart.decrease') }}" method="POST" class="d-inline-flex align-items-center">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="btn btn-sm sport-cart-qty-btn sport-btn-outline">
                                                    <i class="bi bi-dash-lg"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('cart.remove') }}" method="POST" class="d-inline-flex align-items-center" onsubmit="return confirm('آیا از حذف این کالا مطمئن هستید؟');">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="btn btn-sm sport-cart-qty-btn sport-btn-outline">
                                                    <i class="bi bi-dash-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <button type="button" class="btn sport-btn-outline w-100" onclick="confirmRemove({{ $product->id }}, '{{ $product->name }}')">
                                        <i class="bi bi-trash me-1"></i> حذف از سبد
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
            <a href="{{ route('home') }}" class="btn sport-btn-outline">
                <i class="bi bi-arrow-right"></i> بازگشت به فروشگاه
            </a>
            <button class="sport-cart-checkout-btn">
                <i class="bi bi-check-circle"></i> تکمیل فرآیند خرید
            </button>
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
