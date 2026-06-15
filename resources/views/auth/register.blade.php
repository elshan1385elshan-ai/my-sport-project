<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت نام | خانه قهرمانان</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <style>
        body { 
            font-family: Tahoma, Arial, sans-serif; 
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), 
                        url('{{ asset('images/nou-camp.webp') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 35px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .btn-primary-custom {
            background-color: #dc3545;
            border: none;
            color: white;
        }
        .btn-primary-custom:hover {
            background-color: #a71d2a;
            color: white;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="text-center mb-4">
            <h2 class="fw-bold">ایجاد حساب کاربری</h2>
            <p class="text-muted">به خانواده قهرمانان بپیوندید!</p>
        </div>

        <!-- نمایش خطاهای اعتبارسنجی -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">نام کامل</label>
                <input type="text" 
                       class="form-control" 
                       name="name" 
                       value="{{ old('name') }}" 
                       placeholder="نام و نام خانوادگی" 
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">ایمیل</label>
                <input type="email" 
                       class="form-control" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="example@email.com" 
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">رمز عبور</label>
                <input type="password" 
                       class="form-control" 
                       name="password" 
                       placeholder="********" 
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">تکرار رمز عبور</label>
                <input type="password" 
                       class="form-control" 
                       name="password_confirmation" 
                       placeholder="********" 
                       required>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary-custom btn-lg">ثبت نام</button>
            </div>
        </form>

        <div class="text-center mt-4">
            <p class="small">قبلاً عضو شده‌اید؟ 
                <a href="{{ route('login') }}" class="text-danger text-decoration-none fw-bold">ورود به حساب</a>
            </p>
            <a href="{{ route('home') }}" class="text-muted small text-decoration-none">بازگشت به صفحه اصلی</a>
        </div>
    </div>

</body>
</html>