@extends('layouts.app')

@section('content')
<main class="container my-5" id="content">
    <h2 class="sport-title text-center mb-4">نتیجه جستجو برای: "{{ $query }}"</h2>

    @if($products->count() > 0)
        <p class="text-muted text-center">{{ $products->total() }} محصول یافت شد.</p>
    @endif

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
                        @if($product->discount > 0)
                            <span class="sport-card-discount">-{{ $product->discount }}%</span>
                        @endif
                        @if($product->category)
                            <span class="sport-card-category">{{ $product->category->name }}</span>
                        @endif
                    </div>

                    <div class="sport-card-body">
                        <a href="{{ route('product.show', $product) }}" class="sport-card-title">
                            {{ $product->name }}
                        </a>

                        <div class="sport-card-price-row">
                            @if($product->discount > 0)
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
                <div class="alert alert-info text-center">محصولی با این نام یافت نشد.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</main>
@endsection
