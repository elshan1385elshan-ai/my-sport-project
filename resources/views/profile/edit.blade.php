@extends('user.layouts.app')
@section('content')
<div class="content-wrapper">
  <div class="user-dashboard">
    <div class="dash-deco dash-deco-1"></div>
    <div class="dash-deco dash-deco-2"></div>

    <section class="content">
      <div class="container-fluid">

        <div class="dash-welcome">
          <i class="fa fa-user-circle welcome-icon"></i>
          <h4>ویرایش پروفایل</h4>
          <p>عکس و نام کامل خود را از اینجا به‌روزرسانی کنید</p>
        </div>

        @php $user = auth()->user(); @endphp

        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card sport-card border-0 shadow-sm" style="border-radius: 18px; background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
              <div class="card-header" style="background: linear-gradient(135deg, #0f3460, #1e1b4b); color: #fff; border-radius: 18px 18px 0 0;">
                <span class="card-icon icon-orange"><i class="fa fa-user"></i></span>
                <h3 class="card-title" style="color:#fff;">پروفایل شما</h3>
              </div>

              <div class="card-body p-4">
                @if ($errors->any())
                  <div class="alert alert-danger border-0 rounded-3 mb-4" style="background: linear-gradient(135deg, #fef2f2, #fee2e2);">
                    <ul class="mb-0 small">
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PATCH')

                  <div class="text-center mb-4">
                    <div class="position-relative d-inline-block">
                      @if($user && $user->avatar)
                        <img src="{{ asset('storage/'.$user->avatar) }}"
                             class="rounded-circle shadow"
                             style="width: 130px; height: 130px; object-fit: cover; border: 4px solid rgba(233,69,96,0.3);">
                      @else
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                             style="width: 130px; height: 130px; background: linear-gradient(135deg, #0f3460, #1e1b4b); color: #fff; font-size: 3.2rem; border: 4px solid rgba(233,69,96,0.3);">
                          {{ $user ? mb_substr($user->name, 0, 1) : '?' }}
                        </div>
                      @endif
                      <label for="avatarInput" class="position-absolute bottom-0 end-0 btn btn-sm btn-danger rounded-circle p-2 shadow" style="cursor: pointer;">
                        <i class="fa fa-camera"></i>
                      </label>
                      <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*">
                    </div>
                    <p class="text-muted small mt-2">برای تغییر عکس روی آیکون دوربین کلیک کنید</p>
                  </div>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label fw-bold text-dark">نام کامل <span class="text-danger">*</span></label>
                      <input type="text" class="form-control sport-form-control" name="name" value="{{ old('name', $user->name ?? '') }}" placeholder="نام و نام خانوادگی" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-bold text-dark">نام خانوادگی</label>
                      <input type="text" class="form-control sport-form-control" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}" placeholder="نام خانوادگی">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-bold text-dark">ایمیل</label>
                      <input type="email" class="form-control sport-form-control" value="{{ $user->email ?? '' }}" disabled>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-bold text-dark">شماره تماس</label>
                      <input type="text" class="form-control sport-form-control" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="مثال: ۰۹۱۲۳۴۵۶۷۸۹">
                    </div>
                  </div>

                  <div class="mt-4">
                    <button type="submit" class="btn sport-btn-primary w-100 py-2">
                      <i class="fa fa-save"></i> ذخیره تغییرات
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>
</div>
@endsection
