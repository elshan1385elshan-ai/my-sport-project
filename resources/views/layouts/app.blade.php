<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $appSettings['page_title_prefix'] ?? 'Sport' }} | {{ $appSettings['app_name'] ?? 'خانه قهرمانان' }}</title>
    <!-- استفاده از بوت‌استرپ ۵ برای استایل‌دهی مدرن -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/sport-public.css') }}">
    <style>
        body { font-family: {{ $appSettings['font_family'] ?? "'Vazir', sans-serif" }}; }
        
        /* استایل خاص برای بنر با تصویر شما */
        .card-img-top { height: 200px; object-fit: cover; }
    </style>
</head>
<body>

    <!-- Navbar -->
    @include('layouts.partials.nav')

    @if(Route::currentRouteName() === 'home')
        <header class="hero-section position-relative" style="background: linear-gradient(135deg, rgba(26,26,46,0.85), rgba(15,52,96,0.85)), url('https://images.unsplash.com/photo-1517649763962-0c623066013b?w=1920&q=80');">
            <div class="container position-relative z-3 h-100 d-flex align-items-center">
                <div class="row justify-content-center text-center w-100">
                    <div class="col-lg-15">
                        <h1 class="display-3 fw-bold text-white mb-4">
                            {{ str_replace('{app_name}', $appSettings['app_name'], $appSettings['welcome_message'] ?? 'به فروشگاه {app_name} خوش آمدید') }}
                        </h1>
                        <a href="#content" class="sport-hero-btn">
                            <i class="bi bi-arrow-down-circle"></i> مشاهده همه کالاها
                        </a>
                    </div>
                </div>
            </div>
        </header>
    @endif


    <!-- محتوا -->
    @yield('content')

    <!-- Footer -->
    @include('layouts.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
