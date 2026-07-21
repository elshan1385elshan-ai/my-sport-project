@extends('layouts.app')

@section('content')
<main class="container my-5" id="content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <h2 class="sport-title">وارد کردن آدرس</h2>
                <p class="text-muted">آدرس خود را برای دریافت سفارشات وارد کنید</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('profile.address.store') }}" method="POST">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">استان</label>
                                <input type="text" class="form-control" name="province" value="{{ old('province') }}" placeholder="مثال: تهران">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">شهر</label>
                                <input type="text" class="form-control" name="city" value="{{ old('city') }}" placeholder="مثال: تهران">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">آدرس کامل</label>
                                <textarea class="form-control" name="address" rows="3" placeholder="خیابان، کوچه، پلاک">{{ old('address') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">کد پستی</label>
                                <input type="text" class="form-control" name="postal_code" value="{{ old('postal_code') }}" placeholder="کد پستی ۱۰ رقمی">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">شماره تماس (اختیاری)</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="مثال: ۰۲۱۱۲۳۴۵۶۷۸">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn sport-btn-primary w-100 py-2">
                                <i class="bi bi-check-circle"></i> ثبت آدرس
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
