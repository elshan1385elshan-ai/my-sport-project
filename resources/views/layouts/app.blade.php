<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport | خانه قهرمانان</title>
    <!-- استفاده از بوت‌استرپ ۵ برای استایل‌دهی مدرن -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <style>
        body { font-family: Tahoma, Arial, sans-serif; }
        
        /* استایل خاص برای بنر با تصویر شما */
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
        
        .card-img-top { height: 200px; object-fit: cover; }
    </style>
</head>
<body>

    <!-- Navbar -->
    @include('layouts.partials.nav')

    <!-- محتوا -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p class="mb-0">تمامی حقوق برای سایت SPORT محفوظ است - ۲۰۲۶</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
