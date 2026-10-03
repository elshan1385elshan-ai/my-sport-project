@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-green"><i class="fa fa-users"></i> ایجاد کاربر جدید</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">کاربران</a></li>
              <li class="breadcrumb-item active">ایجاد</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card sport-card sport-card-green">
                        <div class="card-header">
                            <span class="card-icon icon-green"><i class="fa fa-users"></i></span>
                            <h3 class="card-title">فرم ایجاد کاربر</h3>
                        </div>

                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf

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
                                    <h5><i class="fa fa-user"></i> اطلاعات هویتی</h5>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="sport-form-group">
                                            <label>نام <span class="text-danger">*</span></label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-user input-icon"></i>
                                                <input type="text" class="form-control sport-form-control" name="name" value="{{ old('name') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="sport-form-group">
                                            <label>ایمیل <span class="text-danger">*</span></label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-envelope input-icon"></i>
                                                <input type="email" class="form-control sport-form-control" name="email" value="{{ old('email') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="sport-form-group">
                                            <label>نقش <span class="text-danger">*</span></label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-shield input-icon"></i>
                                                <select class="form-control sport-form-control" name="role" required>
                                                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>کاربر</option>
                                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>مدیر</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sport-form-section">
                                    <h5><i class="fa fa-lock"></i> رمز عبور</h5>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="sport-form-group">
                                            <label>رمز عبور <span class="text-danger">*</span></label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-lock input-icon"></i>
                                                <input type="password" class="form-control sport-form-control" name="password" id="userPassword" required>
                                                <button type="button" class="sport-password-toggle" tabindex="-1" aria-label="نمایش/مخفی کردن رمز عبور" onclick="togglePasswordVisibility('userPassword', this)">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="sport-form-group">
                                            <label>تکرار رمز عبور <span class="text-danger">*</span></label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-lock input-icon"></i>
                                                <input type="password" class="form-control sport-form-control" name="password_confirmation" id="userPasswordConfirm" required>
                                                <button type="button" class="sport-password-toggle" tabindex="-1" aria-label="نمایش/مخفی کردن رمز عبور" onclick="togglePasswordVisibility('userPasswordConfirm', this)">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn sport-btn-primary">
                                    <i class="fa fa-save"></i> ایجاد کاربر
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn sport-btn-secondary mr-2">بازگشت</a>
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
function togglePasswordVisibility(inputId, btn) {
    var input = document.getElementById(inputId);
    var icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endpush
