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

                <div class="card-body p-4 p-md-5">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 mb-4" style="background: linear-gradient(135deg, #fef2f2, #fee2e2);">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">نام کامل</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-person-fill text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 rounded-end-4" name="name" value="{{ old('name') }}" placeholder="نام و نام خانوادگی" required style="background: #f8fafc; border-color: #e2e8f0;">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">ایمیل</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-envelope-fill text-muted"></i></span>
                                <input type="email" class="form-control border-start-0 rounded-end-4" name="email" value="{{ old('email') }}" placeholder="example@email.com" required style="background: #f8fafc; border-color: #e2e8f0;">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">رمز عبور</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password" class="form-control border-start-0 rounded-end-4" name="password" placeholder="********" required style="background: #f8fafc; border-color: #e2e8f0;">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">تکرار رمز عبور</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password" class="form-control border-start-0 rounded-end-4" name="password_confirmation" placeholder="********" required style="background: #f8fafc; border-color: #e2e8f0;">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-lg w-100 rounded-3 fw-semibold mb-4" style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none; box-shadow: 0 4px 16px rgba(239,68,68,0.3);">
                            <i class="bi bi-person-plus-fill me-2"></i> ثبت نام
                        </button>
                    </form>

                    <div class="text-center">
                        <p class="text-muted small mb-0">قبلاً عضو شده‌ید؟
                            <a href="{{ route('login') }}" class="text-danger text-decoration-none fw-bold ms-1">ورود به حساب</a>
                        </p>
                        <a href="{{ route('home') }}" class="text-muted small text-decoration-none d-block mt-2"><i class="bi bi-arrow-right me-1"></i>بازگشت به صفحه اصلی</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
