@extends('layouts.app')

@section('content')
<main class="container my-5" id="content">
    <div class="text-center mb-5">
        <h2 class="sport-title">جدیدترین کالاهای ورزشی</h2>
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
                <div class="alert alert-info text-center">هنوز محصولی ثبت نشده است.</div>
            </div>
        @endforelse
    </div>

    @if(isset($childCategories) && $childCategories->count())
    <div class="text-center mt-5 mb-4">
        <h2 class="sport-title">تمامی برند‌ها و دسته‌بندی‌ها</h2>
    </div>
    <div class="row g-4 justify-content-center">
        @foreach($childCategories as $cat)
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('category.show', $cat) }}" class="sport-category-item text-decoration-none text-center">
                    <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}">
                    <p>{{ $cat->name }}</p>
                </a>
            </div>
        @endforeach
    </div>
    @endif

    @if(isset($brands) && $brands->count())
    <div class="text-center mt-5 mb-4">
        <h2 class="sport-title">برند‌های معروف</h2>
    </div>
    <div class="row g-4 justify-content-center">
        @foreach($brands as $brand)
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('brand.show', $brand) }}" class="sport-brand-item text-decoration-none text-center">
                    <img src="{{ asset('storage/'.$brand->image) }}" alt="{{ $brand->name }}">
                    <p>{{ $brand->name }}</p>
                </a>
            </div>
        @endforeach
    </div>
    @endif
</main>
@endsection
