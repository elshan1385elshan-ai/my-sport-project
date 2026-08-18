@extends('layouts.app')

@section('content')
<main class="container my-5" id="content">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">خانه</a></li>
            @php $firstCategory = $product->categories->first(); @endphp
            @if($firstCategory)
                <li class="breadcrumb-item"><a href="{{ route('category.show', $firstCategory) }}">{{ $firstCategory->name }}</a></li>
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
                                class="img-fluid thumb-img"
                                alt="{{ $product->name }}"
                                onclick="document.getElementById('mainProductImage').src = this.src; document.querySelectorAll('.thumb-img').forEach(t => t.style.borderColor = 'rgba(233,69,96,0.2)'); this.style.borderColor = 'rgba(233,69,96,0.6)';">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <h2 class="mb-3 fw-bold" style="color:#1a1a2e;">{{ $product->name }}</h2>

            @if($product->discount_active)
                <p class="mb-2">
                    <del class="text-muted fs-5">{{ number_format($product->price) }} تومان</del>
                    <span class="text-success fw-bold fs-3 me-2">{{ number_format($product->discounted_price) }} تومان</span>
                </p>
                <span class="badge fs-6 mb-3" style="background: linear-gradient(90deg, #e94560, #ff6b6b); color:#fff;">{{ $product->discount }}% تخفیف</span>
            @else
                <p class="fs-3 fw-bold mb-3 price-tag">{{ number_format($product->price) }} تومان</p>
            @endif

            <div class="d-flex align-items-center gap-3 p-3 mb-4 rounded-3 sport-detail-stock-box">
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

            @if($product->featureValues->isNotEmpty())
                <div class="d-flex flex-column gap-3 mb-4">
                    @foreach($product->featureValues->groupBy(fn ($v) => $v->feature?->name ?? 'سایر') as $featureName => $values)
                        <div class="card border-0 shadow-sm" style="border-radius: 12px; background: #a1a1a1;">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0" style="color:#1a1a2e;">
                                    <i class="bi bi-sliders me-1"></i> {{ $featureName }}
                                </h6>
                                <span class="fw-bold" style="color:#0f3460;">{{ $values->pluck('value')->implode('، ') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn sport-detail-buy-btn btn-lg w-100">
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

    @if($relatedProducts->isNotEmpty())
        <hr class="my-5">
        <h4 class="sport-title mb-4">محصولات مشابه</h4>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
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

    <section class="mt-5" id="reviews">
        <hr class="my-5">
        <h4 class="sport-title mb-4">
            <i class="bi bi-star-fill text-warning"></i> نظرات و امتیازها
        </h4>

        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; background: #f8f9fa;">
                    <div class="card-body text-center p-4">
                        <div class="display-4 fw-bold" style="color:#1a1a2e;">{{ $avgRating > 0 ? number_format($avgRating, 1, '.', '') : '—' }}</div>
                        <div class="mb-2 sport-rating-stars" data-rating="{{ round($avgRating) }}">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= round($avgRating) ? 'bi-star-fill' : 'bi-star' }}" style="color:#ffc107; font-size: 1.2rem;"></i>
                            @endfor
                        </div>
                        <span class="text-muted">{{ $reviews->count() }} نظر ثبت شده</span>

                        @if(auth()->check())
                            <hr>
                            <form action="{{ route('product.review.store', $product) }}" method="POST">
                                @csrf
                                <div class="sport-rate-input mb-3" data-rating="{{ $userReview?->rating ?? 0 }}">
                                    <label class="d-block text-muted small mb-2">امتیاز شما</label>
                                    <div class="sport-star-picker">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" name="rating" id="star-{{ $i }}" value="{{ $i }}" class="d-none"
                                                   {{ $userReview?->rating == $i ? 'checked' : '' }} required>
                                            <label for="star-{{ $i }}" class="sport-star-label">
                                                <i class="bi {{ $userReview && $userReview->rating >= $i ? 'bi-star-fill' : 'bi-star' }}"></i>
                                            </label>
                                        @endfor
                                    </div>
                                    @error('rating')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <textarea name="comment" rows="3" class="form-control mb-2" placeholder="نظر خود را درباره این کالا بنویسید...">{{ old('comment', $userReview?->comment) }}</textarea>
                                @error('comment')
                                    <small class="text-danger d-block mb-2">{{ $message }}</small>
                                @enderror

                                <button type="submit" class="btn sport-detail-buy-btn w-100">
                                    <i class="bi bi-send"></i> {{ $userReview ? 'ویرایش نظر من' : 'ثبت نظر و امتیاز' }}
                                </button>
                            </form>
                        @else
                            <div class="alert alert-light text-muted small mt-3 mb-0">
                                برای ثبت نظر و امتیاز، ابتدا
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold">وارد شوید</a>.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                @forelse($reviews as $review)
                    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                         style="width: 38px; height: 38px; background: linear-gradient(135deg, #0f3460, #e94560);">
                                        {{ mb_substr($review->user->name ?? 'کاربر', 0, 1) }}
                                    </div>
                                    <div>
                                        <strong>{{ $review->user->name ?? 'کاربر ناشناس' }}</strong>
                                        @if($userReview && $userReview->id === $review->id)
                                            <span class="badge bg-info text-dark ms-1">نظر من</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-muted small">
                                    <span class="sport-review-date">{{ $review->created_at->format('Y/m/d') }}</span>
                                </div>
                            </div>

                            <div class="mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}" style="color:#ffc107;"></i>
                                @endfor
                            </div>

                            @if($review->comment)
                                <p class="mb-0 text-muted">{{ $review->comment }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body text-center text-muted py-5">
                            <i class="bi bi-chat-square-text fs-1 d-block mb-2"></i>
                            هنوز نظری برای این کالا ثبت نشده است. اولین نفر باشید!
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</main>

@push('scripts')
<script>
  @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: 'اضافه شد!',
      text: '{{ session("success") }}',
      confirmButtonText: 'باشه',
      confirmButtonColor: '#0f3460',
      timer: 3000,
      timerProgressBar: true
    });
  @endif

  document.querySelectorAll('.sport-star-picker').forEach(function(picker) {
    var labels = picker.querySelectorAll('.sport-star-label');
    var stars = labels.length;

    labels.forEach(function(label) {
      label.addEventListener('click', function() {
        var index = Array.prototype.indexOf.call(labels, label);
        labels.forEach(function(l, i) {
          var icon = l.querySelector('i');
          if (i >= index) {
            icon.className = icon.className.replace('bi-star', 'bi-star-fill');
          } else {
            icon.className = icon.className.replace('bi-star-fill', 'bi-star');
          }
        });
      });

      label.addEventListener('mouseenter', function() {
        var index = Array.prototype.indexOf.call(labels, label);
        labels.forEach(function(l, i) {
          var icon = l.querySelector('i');
          if (i >= index) {
            icon.className = icon.className.replace('bi-star', 'bi-star-fill');
          }
        });
      });
    });

    picker.addEventListener('mouseleave', function() {
      var checked = picker.querySelector('input:checked');
      var rating = checked ? parseInt(checked.value, 10) : 0;
      labels.forEach(function(l, i) {
        var icon = l.querySelector('i');
        if (i >= stars - rating) {
          icon.className = icon.className.replace('bi-star', 'bi-star-fill');
        } else {
          icon.className = icon.className.replace('bi-star-fill', 'bi-star');
        }
      });
    });
  });
</script>
@endpush
@endsection
