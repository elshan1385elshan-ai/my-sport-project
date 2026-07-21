@extends('layouts.app')

@section('content')
<main class="container my-5" id="content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <h2 class="sport-title">آدرس شما</h2>
            </div>

            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    @if($address)
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>استان:</strong>
                                <p class="text-muted mb-0">{{ $address->province }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>شهر:</strong>
                                <p class="text-muted mb-0">{{ $address->city }}</p>
                            </div>
                            <div class="col-12 mb-3">
                                <strong>آدرس:</strong>
                                <p class="text-muted mb-0">{{ $address->address }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>کد پستی:</strong>
                                <p class="text-muted mb-0">{{ $address->postal_code }}</p>
                            </div>
                            @if($address->phone)
                                <div class="col-md-6 mb-3">
                                    <strong>شماره تماس:</strong>
                                    <p class="text-muted mb-0">{{ $address->phone }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('profile.address.edit') }}" class="btn sport-btn-primary w-100 py-2">
                                <i class="bi bi-pencil"></i> ویرایش آدرس
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-geo-alt" style="font-size: 4rem; color: #ccc;"></i>
                            <h4 class="mt-3 text-muted">هنوز آدرسی ثبت نکرده‌اید</h4>
                            <p class="text-muted">برای ثبت آدرس تحویل سفارشات خود اقدام کنید</p>
                            <a href="{{ route('profile.address.create') }}" class="btn sport-btn-primary mt-2">
                                <i class="bi bi-plus-circle"></i> وارد کردن آدرس
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
