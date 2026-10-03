@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-8 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                <div class="card-header bg-transparent border-0 pt-5 pb-3 text-center" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 72px; height: 72px; background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 8px 24px rgba(239,68,68,0.4);">
                        <i class="bi bi-person-plus-fill text-white" style="font-size: 1.8rem;"></i>
                    </div>
                    <h3 class="fw-bold mb-1" style="color: #ac2727;">ثبت نام</h3>
                    <p class="fw-bold text-white mb-0">{{ str_replace('{app_name}', $appSettings['app_name'], 'به فروشگاه {app_name} بپیوندید ') }}</p>
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
                            @error('name')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">شماره تلفن</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-telephone-fill text-muted"></i></span>
                                <input type="tel" dir="ltr" class="form-control border-start-0 rounded-end-4" name="phone" value="{{ old('phone') }}" placeholder="۰۹۱۲۳۴۵۶۷۸۹" required style="background: #f8fafc; border-color: #e2e8f0;">
                            </div>
                            @error('phone')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">ایمیل <span class="text-muted small">(اختیاری)</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-envelope-fill text-muted"></i></span>
                                <input type="email" class="form-control border-start-0 rounded-end-4" name="email" value="{{ old('email') }}" placeholder="example@email.com" style="background: #f8fafc; border-color: #e2e8f0;">
                            </div>
                            @error('email')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">رمز عبور <span class="text-muted small">(اختیاری)</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password" class="form-control border-start-0 rounded-end-4" name="password" id="registerPassword" placeholder="********" style="background: #f8fafc; border-color: #e2e8f0;">
                                <button type="button" class="sport-password-toggle" tabindex="-1" aria-label="نمایش/مخفی کردن رمز عبور" onclick="togglePasswordVisibility('registerPassword', this)">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                            @error('password')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">تکرار رمز عبور <span class="text-muted small">(اختیاری)</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password" class="form-control border-start-0 rounded-end-4" name="password_confirmation" id="registerPasswordConfirm" placeholder="********" style="background: #f8fafc; border-color: #e2e8f0;">
                                <button type="button" class="sport-password-toggle" tabindex="-1" aria-label="نمایش/مخفی کردن رمز عبور" onclick="togglePasswordVisibility('registerPasswordConfirm', this)">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-lg w-100 rounded-3 fw-semibold mb-4" style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none; box-shadow: 0 4px 16px rgba(239,68,68,0.3);">
                            <i class="bi bi-person-plus-fill me-2"></i> ثبت نام
                        </button>
                    </form>

                    <div class="text-center">
                        <p class="text-muted small mb-0">قبلاً عضو شده‌اید؟
                            <a href="{{ route('login') }}" class="text-danger text-decoration-none fw-bold ms-1">ورود به حساب</a>
                        </p>
                        <a href="{{ route('home') }}" class="text-muted small text-decoration-none d-block mt-2"><i class="bi bi-arrow-right me-1"></i>بازگشت به صفحه اصلی</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePasswordVisibility(inputId, btn) {
    var input = document.getElementById(inputId);
    var icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
    }
}
</script>
@endpush
