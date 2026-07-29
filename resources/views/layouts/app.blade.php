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
        <header class="hero-section position-relative">
            <div class="hero-background"></div>
            <style>
                /* بنر صفحه home */
                .hero-section {
                    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('images/nou camp.webp') }}');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    height: 500px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    text-align: center;
                }
                .hero-section h1 { font-size: 3.5rem; font-weight: bold; }
            </style>

            <div class="container position-relative z-3 h-100 d-flex align-items-center">
                <div class="row justify-content-center text-center w-100">
                    <div class="col-lg-15">
                        <h1 class="display-3 fw-bold text-white mb-4">
                            {{ str_replace('{app_name}', $appSettings['app_name'], $appSettings['welcome_message'] ?? 'به فروشگاه {app_name} خوش آمدید') }}
                        </h1>
                        <a href="#content" class="btn btn-danger btn-lg px-5 py-3">مشاهده همه کالاها</a>
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
