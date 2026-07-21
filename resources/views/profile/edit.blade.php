@extends('layouts.app')

@section('content')
<main class="container my-5" id="content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <h2 class="sport-title">پروفایل شما</h2>
            </div>

            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            @php $user = auth()->user(); @endphp

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('buyer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                @if($user && $user->avatar)
                                    <img src="{{ asset('storage/'.$user->avatar) }}"
                                         class="rounded-circle shadow"
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                         style="width: 120px; height: 120px; background: linear-gradient(135deg, #0f3460, #1a1a2e); color: #fff; font-size: 3rem;">
                                        {{ $user ? mb_substr($user->name, 0, 1) : '?' }}
                                    </div>
                                @endif
                                <label for="avatarInput" class="position-absolute bottom-0 end-0 btn btn-sm btn-dark rounded-circle p-2 shadow" style="cursor: pointer;">
                                    <i class="bi bi-camera-fill"></i>
                                </label>
                                <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*">
                            </div>
                            <p class="text-muted small mt-2">برای تغییر عکس کلیک کنید</p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">نام</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">نام خانوادگی</label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">ایمیل</label>
                                <input type="email" class="form-control" value="{{ $user->email ?? '' }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">شماره تماس</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="مثال: ۰۹۱۲۳۴۵۶۷۸۹">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn sport-btn-primary w-100 py-2">
                                <i class="bi bi-check-circle"></i> ذخیره تغییرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
