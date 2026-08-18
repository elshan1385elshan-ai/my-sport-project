@extends('layouts.app')

@section('content')
<main class="container my-5" id="content">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">خانه</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="text-center mb-5">
        <h2 class="sport-title">دسته‌بندی: {{ $category->name }}</h2>
    </div>

    <div class="row g-4">
        @forelse($products as $product)
            @php $firstImage = $product->images->first(); @endphp
            <div class="col-md-4">
                <div class="sport-card">
                    <div class="sport-card-img-wrap">
                        <a href="{{ route('product.show', $product) }}">
                            <img
                                src="{{ $firstImage ? asset('storage/'.$firstImage->image_path) : 'https://picsum.photos/400/200' }}"
                                class="sport-card-img"
                                alt="{{ $product->name }}">
                        </a>
                        @if($product->discount_active)
                            <span class="sport-card-discount">-{{ $product->discount }}%</span>
                        @endif
                        @if($product->categories->isNotEmpty())
                            <span class="sport-card-category">{{ $product->categories->first()->name }}</span>
                        @endif
                    </div>

                    <div class="sport-card-body">
                        <a href="{{ route('product.show', $product) }}" class="sport-card-title">
                            {{ $product->name }}
                        </a>

                        <div class="sport-card-price-row">
@if($product->discount_active)
                            <span class="sport-card-price-current">{{ number_format($product->discounted_price) }} تومان</span>
                            <span class="sport-card-price-old">{{ number_format($product->price) }} تومان</span>
                        @else
                            <span class="sport-card-price-current">{{ number_format($product->price) }} تومان</span>
                        @endif
                        </div>

                        <div class="sport-card-stock">
                            @if($product->stock > 0)
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span class="text-success">{{ $product->stock }} عدد در انبار</span>
                            @else
                                <i class="bi bi-x-circle-fill text-danger"></i>
                                <span class="text-danger">ناموجود</span>
                            @endif
                        </div>

                        <a href="{{ route('product.show', $product) }}" class="sport-card-btn">
                            <i class="bi bi-eye"></i> مشاهده جزئیات
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">محصولی برای این دسته‌بندی ثبت نشده است.</div>
            </div>
        @endforelse
    </div>
</main>
@endsection
