@extends('layouts.app')

@section('content')
<main class="container my-5" id="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">سبد خرید</h2>
        @if($products->count() > 0)
            <span class="badge bg-primary fs-6">{{ $products->count() }} کالا</span>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if($products->count() > 0)
        <div class="row g-4">
            @foreach($products as $product)
                @php $firstImage = $product->images->first(); @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 hover-shadow">
                            <div class="position-relative">
                                <img
                                    src="{{ $firstImage ? asset('storage/'.$firstImage->image_path) : 'https://picsum.photos/400/250' }}"
                                    class="card-img-top"
                                    style="height: 200px; object-fit: cover;"
                                    alt="{{ $product->name }}">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle p-2"
                                        onclick="confirmRemove({{ $product->id }}, '{{ $product->name }}')"
                                        title="حذف از سبد">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate">{{ $product->name }}</h5>

                                <p class="text-muted small mb-2">
                                    <span class="badge bg-light text-dark border">{{ $product->category->name ?? 'بدون دسته' }}</span>
                                </p>

                                @if($product->description)
                                    <p class="card-text text-secondary small flex-grow-1">{{ $product->description }}</p>
                                @endif

                                <div class="mt-auto pt-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        @if($product->discount > 0)
                                            <del class="text-muted small">{{ number_format($product->price) }} تومان</del>
                                            <span class="text-danger fw-bold fs-5">{{ number_format($product->discounted_price) }} تومان</span>
                                            <span class="badge bg-danger ms-2">-{{ $product->discount }}%</span>
                                        @else
                                            <span class="text-success fw-bold fs-5">{{ number_format($product->price) }} تومان</span>
                                        @endif
                                    </div>

                                    <button type="button" class="btn btn-outline-danger w-100" onclick="confirmRemove({{ $product->id }}, '{{ $product->name }}')">
                                        <i class="bi bi-trash me-1"></i> حذف از سبد
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-right"></i> بازگشت به فروشگاه
            </a>
            <button class="btn btn-success btn-lg px-5">
                <i class="bi bi-check-circle"></i> تکمیل فرآیند خرید
            </button>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x" style="font-size: 4rem; color: #ccc;"></i>
            <h4 class="mt-3 text-muted">سبد خرید شما خالی است</h4>
            <a href="{{ route('home') }}" class="btn btn-danger mt-3">مشاهده کالاها</a>
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

<style>
    .hover-shadow {
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
        transform: translateY(-2px);
    }
    .card-img-top {
        border-radius: 0.375rem 0.375rem 0 0;
    }
</style>
