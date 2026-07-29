<footer style="background: linear-gradient(135deg, #0f3460, #1a1a2e, #16213e);" class="text-white pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-{{ $appSettings['public_icon'] ?? 'trophy-fill' }} text-warning"></i> {{ $appSettings['app_name'] }}
                </h5>
                <p class="text-white-50 small">فروشگاه تخصصی کالاهای ورزشی با بهترین کیفیت و قیمت. همراه شما در مسیر قهرمانی.</p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="social-icon instagram" title="اینستاگرام">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="social-icon telegram" title="تلگرام">
                        <i class="bi bi-telegram"></i>
                    </a>
                    <a href="#" class="social-icon whatsapp" title="واتساپ">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <a href="#" class="social-icon youtube" title="یوتیوب">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-2">
                <h6 class="fw-bold mb-3">دسترسی سریع</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">صفحه اصلی</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">کالاهای ورزشی</a></li>
                    <li class="mb-2"><a href="{{ route('cart.show') }}" class="text-white-50 text-decoration-none">سبد خرید</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">تماس با ما</a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h6 class="fw-bold mb-3">دسته‌بندی‌ها</h6>
                <ul class="list-unstyled small">
                    @if(isset($navCategories))
                        @foreach($navCategories->take(6) as $cat)
                            <li class="mb-2">
                                <a href="{{ route('category.show', $cat) }}" class="text-white-50 text-decoration-none">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            <div class="col-md-3">
                <h6 class="fw-bold mb-3">اطلاعات تماس</h6>
                <ul class="list-unstyled small text-white-50">
                    <li class="mb-2"><i class="bi bi-geo-alt"></i> {{ $appSettings['contact_address'] }}</li>
                    <li class="mb-2"><i class="bi bi-telephone"></i> {{ $appSettings['contact_phone'] }}</li>
                    <li class="mb-2"><i class="bi bi-envelope"></i> {{ $appSettings['contact_email'] }}</li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-white border-opacity-10">

        <div class="row align-items-center">
            <div class="col text-center">
                <p class="mb-0 text-white-50 small">
                    {{ $appSettings['copyright_display'] ?? $appSettings['app_name'] }}
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    footer a:hover { color: #ffc107 !important; }
    footer .rounded-circle:hover { background: rgba(255,255,255,0.1); }

    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.6);
        color: rgba(255,255,255,0.8);
        font-size: 1.15rem;
        text-decoration: none;
        transition: all .25s ease;
    }
    .social-icon:hover { transform: translateY(-3px); border-color: transparent; }
    .social-icon.instagram:hover { background: radial-gradient(circle at 30% 30%, #fdf497, #fd5949, #d6249f, #285AEB); color: #fff; }
    .social-icon.telegram:hover { background: #0088cc; color: #fff; }
    .social-icon.whatsapp:hover { background: #25D366; color: #fff; }
    .social-icon.youtube:hover { background: #FF0000; color: #fff; }
</style>
