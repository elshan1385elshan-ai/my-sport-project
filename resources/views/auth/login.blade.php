@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-8 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                <div class="card-header bg-transparent border-0 pt-5 pb-3 text-center" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 72px; height: 72px; background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 8px 24px rgba(239,68,68,0.4);">
                        <i class="bi bi-trophy-fill text-white" style="font-size: 1.8rem;"></i>
                    </div>
                    <h3 class="fw-bold mb-1" style="color: #ac2727;">ورود به حساب</h3>
                    <p class="fw-bold text-white mb-0">خوش آمدید</p>
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

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">ایمیل یا نام کاربری</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-person-fill text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 rounded-end-4" name="email" value="{{ old('email') }}" placeholder="وارد کنید..." required style="background: #f8fafc; border-color: #e2e8f0;">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">رمز عبور</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password" class="form-control border-start-0 rounded-end-4" name="password" placeholder="********" required style="background: #f8fafc; border-color: #e2e8f0;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" style="border-color: #e2e8f0;">
                                <label class="form-check-label text-muted small" for="remember">مرا به یاد بسپار</label>
                            </div>
                            <a href="#" class="text-danger text-decoration-none fw-medium small">فراموشی رمز؟</a>
                        </div>

                        <button type="submit" class="btn btn-lg w-100 rounded-3 fw-semibold mb-4" style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none; box-shadow: 0 4px 16px rgba(239,68,68,0.3);">
                            <i class="bi bi-box-arrow-in-right me-2"></i> ورود
                        </button>
                    </form>

                    <div class="text-center">
                        <p class="text-muted small mb-0">هنوز عضو نشده‌اید؟
                            <a href="{{ route('register') }}" class="text-danger text-decoration-none fw-bold ms-1">ثبت نام کنید</a>
                        </p>
                        <a href="{{ route('home') }}" class="text-muted small text-decoration-none d-block mt-2"><i class="bi bi-arrow-right me-1"></i>بازگشت به صفحه اصلی</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection