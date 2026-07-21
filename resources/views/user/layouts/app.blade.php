<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد پنل کاربری</title>

    <link rel="stylesheet" href="{{ asset('UserPanel/asset/style.css') }}">
</head>
<body>

    <!-- Navbar -->
    @include('user.layouts.partials.nav')

    <!-- Main Content -->
    @yield('content')

    <script src="{{ asset('UserPanel/asset/javascript.js') }}"></script>

</body>
</html>