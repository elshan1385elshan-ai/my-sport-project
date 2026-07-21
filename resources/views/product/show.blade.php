@extends('layouts.app')

@section('content')
<main class="container my-5" id="content">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">خانه</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('category.show', $product->category) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-md-6">
            @php $firstImage = $product->images->first(); @endphp
            <img
                id="mainProductImage"
                src="{{ $firstImage ? asset('storage/'.$firstImage->image_path) : 'https://picsum.photos/600/400' }}"
                class="img-fluid sport-detail-img"
                alt="{{ $product->name }}">

            @if($product->images->count() > 1)
                <div class="row g-2 mt-3">
                    @foreach($product->images as $image)
                        <div class="col-3">
                            <img
                                src="{{ asset('storage/'.$image->image_path) }}"
                                class="img-fluid rounded border cursor-pointer thumb-img"
                                style="border: 2px solid transparent; transition: border-color 0.2s;"
                                alt="{{ $product->name }}"
                                onclick="document.getElementById('mainProductImage').src = this.src; document.querySelectorAll('.thumb-img').forEach(t => t.style.borderColor = 'transparent'); this.style.borderColor = '#0f3460';">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <h2 class="mb-3 fw-bold" style="color:#1a1a2e;">{{ $product->name }}</h2>

            @if($product->discount > 0)
                <p class="mb-2">
                    <del class="text-muted fs-5">{{ number_format($product->price) }} تومان</del>
                    <span class="text-success fw-bold fs-3 me-2">{{ number_format($product->discounted_price) }} تومان</span>
                </p>
                <span class="badge fs-6 mb-3" style="background: linear-gradient(90deg, #e94560, #ff6b6b); color:#fff;">{{ $product->discount }}% تخفیف</span>
            @else
                <p class="fs-3 fw-bold mb-3 price-tag">{{ number_format($product->price) }} تومان</p>
            @endif

            <div class="d-flex align-items-center gap-3 p-3 mb-4 rounded-3" style="background: #f8f9fa; border: 1px solid #e9ecef;">
                @if($product->stock > 0)
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-box-seam fs-4" style="color: #0f3460;"></i>
                        <div>
                            <span class="fw-bold fs-5" style="color: #0f3460;">{{ $product->stock }}</span>
                            <span class="text-muted small d-block">تعداد موجود در انبار</span>
                        </div>
                    </div>
                    <div class="vr"></div>
                    <span class="text-success">
                        <i class="bi bi-check-circle-fill"></i> موجود در انبار
                    </span>
                @else
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-box-seam fs-4 text-danger"></i>
                        <div>
                            <span class="fw-bold fs-5 text-danger">ناموجود</span>
                            <span class="text-muted small d-block">این کالا در انبار موجود نیست</span>
                        </div>
                    </div>
                @endif
            </div>

            <hr>

            @if($product->description)
                <div class="mb-4">
                    <h5 class="fw-bold">توضیحات</h5>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>
            @endif

            <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn sport-btn-primary btn-lg px-5 w-100">
                    <i class="bi bi-cart-plus"></i> خرید کالا
                </button>
            </form>
        </div>
    </div>

    @if($product->user)
        <div class="card sport-seller-card mt-4 border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="seller-avatar">
                        {{ mb_substr($product->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h5 class="mb-1">{{ $product->user->name }}</h5>
                        <p class="text-white-50 mb-0 small">
                            <i class="bi bi-shop"></i> فروشنده این کالا
                            @if($product->user->shop_name)
                                | {{ $product->user->shop_name }}
                            @endif
                        </p>
                    </div>
                </div>

                @if($product->user->shopAddress)
                    <hr class="my-3 border-white border-opacity-10">
                    <div class="text-white-50 small">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-geo-alt"></i>
                            <span>{{ $product->user->shopAddress->address }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-building"></i>
                            <span>{{ $product->user->shopAddress->city }}، {{ $product->user->shopAddress->province }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-mailbox"></i>
                            <span>کد پستی: {{ $product->user->shopAddress->postal_code }}</span>
                        </div>
                        @if($product->user->shopAddress->phone)
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <i class="bi bi-telephone"></i>
                                <span>{{ $product->user->shopAddress->phone }}</span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if($product->category && $product->category->products()->where('id', '!=', $product->id)->count() > 0)
        <hr class="my-5">
        <h4 class="sport-title mb-4">محصولات مشابه در {{ $product->category->name }}</h4>
        <div class="row g-4">
            @foreach($product->category->products()->where('id', '!=', $product->id)->latest()->limit(3)->get() as $related)
                <div class="col-md-4">
                    <div class="card h-100 sport-product-card">
                        @php $relImg = $related->images->first(); @endphp
                        @if($related->discount > 0)
                            <span class="discount-badge">{{ $related->discount }}% تخفیف</span>
                        @endif
                        <a href="{{ route('product.show', $related) }}">
                            <img
                                src="{{ $relImg ? asset('storage/'.$relImg->image_path) : 'https://picsum.photos/400/200' }}"
                                class="card-img-top"
                                alt="{{ $related->name }}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('product.show', $related) }}" class="text-decoration-none text-dark">
                                    {{ $related->name }}
                                </a>
                            </h5>
                            @if($related->discount > 0)
                                <p class="card-text">
                                    <del class="text-muted">{{ number_format($related->price) }} تومان</del>
                                    <span class="text-success fw-bold price-tag">{{ number_format($related->discounted_price) }} تومان</span>
                                </p>
                            @else
                                <p class="card-text price-tag">{{ number_format($related->price) }} تومان</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</main>
@endsection
