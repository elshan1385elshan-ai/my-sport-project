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
                src="{{ $firstImage ? asset('storage/'.$firstImage->image_path) : 'https://picsum.photos/600/400' }}"
                class="img-fluid rounded shadow"
                alt="{{ $product->name }}">

            @if($product->images->count() > 1)
                <div class="row g-2 mt-3">
                    @foreach($product->images as $image)
                        <div class="col-3">
                            <img
                                src="{{ asset('storage/'.$image->image_path) }}"
                                class="img-fluid rounded border cursor-pointer"
                                alt="{{ $product->name }}">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <h2 class="mb-3">{{ $product->name }}</h2>

            @if($product->discount > 0)
                <p class="mb-2">
                    <del class="text-muted fs-5">{{ number_format($product->price) }} تومان</del>
                    <span class="text-success fw-bold fs-3 me-2">{{ number_format($product->discounted_price) }} تومان</span>
                </p>
                <span class="badge bg-danger fs-6 mb-3">{{ $product->discount }}% تخفیف</span>
            @else
                <p class="fs-3 fw-bold text-dark mb-3">{{ number_format($product->price) }} تومان</p>
            @endif

            <hr>

            @if($product->description)
                <div class="mb-4">
                    <h5>توضیحات</h5>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>
            @endif

            <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-danger btn-lg px-5 w-100">
                    <i class="bi bi-cart-plus"></i> خرید کالا
                </button>
            </form>
        </div>
    </div>

    @if($product->user)
        <div class="card shadow-sm border-0 bg-light mt-4">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: bold;">
                        {{ mb_substr($product->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h5 class="mb-1">{{ $product->user->name }}</h5>
                        <p class="text-muted mb-0 small">
                            <i class="bi bi-shop"></i> فروشنده این کالا
                            @if($product->user->shop_name)
                                | {{ $product->user->shop_name }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($product->category && $product->category->products()->where('id', '!=', $product->id)->count() > 0)
        <hr class="my-5">
        <h4 class="mb-4">محصولات مشابه در {{ $product->category->name }}</h4>
        <div class="row g-4">
            @foreach($product->category->products()->where('id', '!=', $product->id)->latest()->limit(3)->get() as $related)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        @php $relImg = $related->images->first(); @endphp
                        <img
                            src="{{ $relImg ? asset('storage/'.$relImg->image_path) : 'https://picsum.photos/400/200' }}"
                            class="card-img-top"
                            alt="{{ $related->name }}">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('product.show', $related) }}" class="text-decoration-none text-dark">
                                    {{ $related->name }}
                                </a>
                            </h5>
                            @if($related->discount > 0)
                                <p class="card-text">
                                    <del class="text-muted">{{ number_format($related->price) }} تومان</del>
                                    <span class="text-success fw-bold">{{ number_format($related->discounted_price) }} تومان</span>
                                </p>
                            @else
                                <p class="card-text">{{ number_format($related->price) }} تومان</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</main>
@endsection
