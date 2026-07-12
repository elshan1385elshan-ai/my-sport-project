<footer style="background: linear-gradient(135deg, #0f3460, #1a1a2e, #16213e);" class="text-white pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-trophy-fill text-warning"></i> خانه قهرمانان
                </h5>
                <p class="text-white-50 small">فروشگاه تخصصی کالاهای ورزشی با بهترین کیفیت و قیمت. همراه شما در مسیر قهرمانی.</p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 38px; height: 38px; padding: 0; line-height: 38px; text-align: center;">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 38px; height: 38px; padding: 0; line-height: 38px; text-align: center;">
                        <i class="bi bi-telegram"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 38px; height: 38px; padding: 0; line-height: 38px; text-align: center;">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 38px; height: 38px; padding: 0; line-height: 38px; text-align: center;">
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
                    <li class="mb-2"><i class="bi bi-geo-alt"></i> تهران، خیابان ورزش</li>
                    <li class="mb-2"><i class="bi bi-telephone"></i> ۰۲۱-۱۲۳۴۵۶۷۸</li>
                    <li class="mb-2"><i class="bi bi-envelope"></i> info@sportshop.ir</li>
                    <li class="mb-2"><i class="bi bi-clock"></i> ۹ صبح تا ۹ شب</li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-white border-opacity-10">

        <div class="row align-items-center">
            <div class="col text-center">
                <p class="mb-0 text-white-50 small">
                    تمامی حقوق مادی و معنوی این وب‌سایت متعلق به <span class="text-warning">خانه قهرمانان</span> می‌باشد &copy; ۲۰۲۶
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    footer a:hover { color: #ffc107 !important; }
    footer .rounded-circle:hover { background: rgba(255,255,255,0.1); }
</style>
