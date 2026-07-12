@extends('layouts.app')

@section('content')
<main class="container my-5" id="content">
    <h2 class="text-center mb-4">دسته‌بندی: {{ $category->name }}</h2>

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    @php $firstImage = $product->images->first(); @endphp
                    <a href="{{ route('product.show', $product) }}">
                        <img
                            src="{{ $firstImage ? asset('storage/'.$firstImage->image_path) : 'https://picsum.photos/400/200' }}"
                            class="card-img-top"
                            alt="{{ $product->name }}">
                    </a>

                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('product.show', $product) }}" class="text-decoration-none text-dark">
                                {{ $product->name }}
                            </a>
                        </h5>

                        @if($product->discount > 0)
                            <p class="card-text mb-1">
                                <del class="text-muted">{{ number_format($product->price) }} تومان</del>
                                <span class="text-success fw-bold fs-5">{{ number_format($product->discounted_price) }} تومان</span>
                            </p>
                            <p class="card-text text-danger mb-3">تخفیف: {{ $product->discount }}%</p>
                        @else
                            <p class="card-text mb-3">{{ number_format($product->price) }} تومان</p>
                        @endif

                        <a href="{{ route('product.show', $product) }}" class="btn btn-outline-primary btn-sm">
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

