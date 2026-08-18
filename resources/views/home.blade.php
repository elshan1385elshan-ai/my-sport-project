@extends('layouts.app')

@section('content')
<main class="container my-5" id="content">
    @if(isset($flashSaleEndsAt) && $flashSaleEndsAt)
    <div id="flashSaleCard" class="mb-5">
        <div class="card border-0 shadow-sm" style="border-radius: 18px; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #dbeafe 100%);">
            <div class="card-body p-4 text-center">
                <h4 class="fw-bold mb-3" style="color: #1e3a5f;">تخفیف ویژه - مدت محدود</h4>
                <p class="text-muted mb-3">فقط تا اتمام زمان باقی‌مانده، تخفیفات ویژه ما را از دست ندهید!</p>
                <div class="d-flex justify-content-center align-items-center gap-3 mb-3 flex-wrap">
                    <div class="text-center">
                        <div id="flash-countdown-days" class="fw-bold" style="font-size: 2rem; color: #dc3545; line-height: 1;">0</div>
                        <small class="text-muted">روز</small>
                    </div>
                    <div class="text-center">
                        <div id="flash-countdown-hours" class="fw-bold" style="font-size: 2rem; color: #dc3545; line-height: 1;">0</div>
                        <small class="text-muted">ساعت</small>
                    </div>
                    <div class="text-center">
                        <div id="flash-countdown-minutes" class="fw-bold" style="font-size: 2rem; color: #dc3545; line-height: 1;">0</div>
                        <small class="text-muted">دقیقه</small>
                    </div>
                    <div class="text-center">
                        <div id="flash-countdown-seconds" class="fw-bold" style="font-size: 2rem; color: #dc3545; line-height: 1;">0</div>
                        <small class="text-muted">ثانیه</small>
                    </div>
                </div>
                <a href="{{ route('discounts.index') }}" class="btn sport-btn-primary w-100 mt-3">مشاهده محصولات تخفیف‌دار</a>
            </div>
        </div>
    </div>
    <div class="mb-4 text-center">
        <small class="text-muted" id="flashSaleStatus"></small>
    </div>
    @endif

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

@push('scripts')
<script>
(function() {
    var endTimestamp = "{{ isset($flashSaleEndsAt) && $flashSaleEndsAt ? $flashSaleEndsAt->toIso8601String() : '' }}";
    if (!endTimestamp) return;

    var endTime = new Date(endTimestamp).getTime();

    function updateCountdown() {
        var now = new Date().getTime();
        var distance = endTime - now;

        if (distance < 0) {
            clearInterval(timerInterval);
            var card = document.getElementById("flashSaleCard");
            if (card) card.style.display = "none";
            var status = document.getElementById("flashSaleStatus");
            if (status) status.innerHTML = "تخفیف منقضی شده است";
            return;
        }

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        var el = function(id, val) {
            var e = document.getElementById(id);
            if (e) e.innerHTML = val;
        };

        el("flash-countdown-days", days);
        el("flash-countdown-hours", hours);
        el("flash-countdown-minutes", minutes);
        el("flash-countdown-seconds", seconds);
    }

    updateCountdown();
    var timerInterval = setInterval(updateCountdown, 1000);
})();
</script>
@endpush
