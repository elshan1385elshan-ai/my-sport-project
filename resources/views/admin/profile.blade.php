@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-purple"><i class="fa fa-user-circle"></i> پروفایل کاربری</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item active">پروفایل</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          {{-- Profile Info Card --}}
          <div class="col-lg-4">
            <div class="card sport-card sport-card-purple">
              <div class="sport-profile-cover"></div>
              <div class="card-body" style="padding-top: 0;">
                <div class="sport-profile-avatar">
                  <div class="sport-avatar sport-avatar-xl sport-avatar-gradient-4">
                    @if(auth()->user()->avatar)
                      <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                    @else
                      {{ mb_substr(auth()->user()->name, 0, 1) }}
                    @endif
                  </div>
                  <label class="avatar-upload-btn" title="تغییر تصویر">
                    <i class="fa fa-camera"></i>
                    <input type="file" form="profile-form" name="avatar" accept="image/*">
                  </label>
                </div>
                <div class="sport-profile-info">
                  <h4>{{ auth()->user()->name }}</h4>
                  <p>{{ auth()->user()->email }}</p>
                  <span class="status-badge {{ auth()->user()->role === 'admin' ? 'status-badge-warning' : 'status-badge-success' }}">
                    <i class="fa {{ auth()->user()->role === 'admin' ? 'fa-shield' : 'fa-user' }}"></i>
                    {{ auth()->user()->role === 'admin' ? 'مدیر سیستم' : 'کاربر عادی' }}
                  </span>
                </div>
                <hr style="border-color: rgba(0,0,0,0.05);">
                <div class="d-flex justify-content-around">
                  <div class="sport-profile-stat">
                    <h4 class="text-purple">{{ auth()->user()->orders_count ?? 0 }}</h4>
                    <p>سفارش</p>
                  </div>
                  <div class="sport-profile-stat">
                    <h4 class="text-orange">{{ auth()->user()->created_at->diffForHumans() }}</h4>
                    <p>عضویت</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Edit Form --}}
          <div class="col-lg-8">
            <div class="card sport-card sport-card-purple">
              <div class="card-header">
                <span class="card-icon icon-purple"><i class="fa fa-user-edit"></i></span>
                <h3 class="card-title">ویرایش اطلاعات</h3>
              </div>

              <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
                @csrf
                @method('PATCH')

                <div class="card-body">
                  @if ($errors->any())
                    <div class="alert alert-danger">
                      <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif

                  <div class="sport-form-section">
                    <h5><i class="fa fa-user"></i> اطلاعات شخصی</h5>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="sport-form-group">
                        <label>نام <span class="text-danger">*</span></label>
                        <div class="sport-input-wrap">
                          <i class="fa fa-user input-icon"></i>
                          <input type="text" class="form-control sport-form-control" name="name"
                                 value="{{ old('name', auth()->user()->name) }}" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="sport-form-group">
                        <label>نام خانوادگی</label>
                        <div class="sport-input-wrap">
                          <i class="fa fa-user input-icon"></i>
                          <input type="text" class="form-control sport-form-control" name="last_name"
                                 value="{{ old('last_name', auth()->user()->last_name ?? '') }}">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="sport-form-group">
                        <label>شماره تماس</label>
                        <div class="sport-input-wrap">
                          <i class="fa fa-phone input-icon"></i>
                          <input type="text" class="form-control sport-form-control" name="phone"
                                 value="{{ old('phone', auth()->user()->phone ?? '') }}">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="sport-form-section">
                    <h5><i class="fa fa-image"></i> تصویر پروفایل</h5>
                  </div>

                  <div class="sport-form-group">
                    <div class="d-flex align-items-center gap-3">
                      <div class="sport-avatar sport-avatar-lg sport-avatar-gradient-4 flex-shrink-0">
                        @if(auth()->user()->avatar)
                          <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="avatar" id="avatar-preview">
                        @else
                          <span id="avatar-preview-text">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                        @endif
                      </div>
                      <div class="flex-grow-1">
                        <div class="sport-file-upload">
                          <input type="file" name="avatar" accept="image/*" id="avatar-input">
                          <i class="fa fa-cloud-upload upload-icon"></i>
                          <span class="upload-text">فایل را اینجا بکشید یا کلیک کنید</span>
                          <div class="upload-hint">JPG, PNG, WebP — حداکثر ۲ مگابایت</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn sport-btn-primary">
                    <i class="fa fa-save"></i> ذخیره تغییرات
                  </button>
                  <a href="{{ route('admin.dashboard') }}" class="btn sport-btn-secondary mr-2">بازگشت</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
  $('#avatar-input').on('change', function(e) {
    var file = e.target.files[0];
    if (file) {
      var reader = new FileReader();
      reader.onload = function(ev) {
        var $preview = $('#avatar-preview');
        var $text = $('#avatar-preview-text');
        if ($preview.length) {
          $preview.attr('src', ev.target.result);
        } else {
          $text.parent().html('<img src="' + ev.target.result + '" alt="avatar" id="avatar-preview" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">');
        }
      };
      reader.readAsDataURL(file);
    }
  });
});
</script>
@endpush
