@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-purple"><i class="fa fa-star"></i> ویرایش برند: {{ $brand->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">برند‌ها</a></li>
              <li class="breadcrumb-item active">ویرایش</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card sport-card sport-card-purple">
                        <div class="card-header">
                            <span class="card-icon icon-purple"><i class="fa fa-star"></i></span>
                            <h3 class="card-title">فرم برند</h3>
                        </div>

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

                            <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="sport-form-group">
                                    <label>نام برند <span class="text-danger">*</span></label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-tag input-icon"></i>
                                        <input type="text" name="name" class="form-control sport-form-control" value="{{ old('name', $brand->name) }}" required>
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>تصویر فعلی</label>
                                    @if($brand->image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/'.$brand->image) }}" alt="{{ $brand->name }}" class="sport-thumb" style="width:80px;height:80px;">
                                        </div>
                                    @else
                                        <p class="text-muted">تصویری آپلود نشده است.</p>
                                    @endif
                                </div>

                                <div class="sport-form-group">
                                    <label>تصویر جدید (اختیاری)</label>
                                    <input type="file" name="image" class="form-control sport-form-control" accept="image/*">
                                    <small class="text-muted">فرمت‌های مجاز: jpg, jpeg, png, webp - حداکثر ۲ مگابایت</small>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn sport-btn-primary">
                                        <i class="fa fa-save"></i> بروزرسانی
                                    </button>
                                    <a href="{{ route('brands.index') }}" class="btn sport-btn-secondary mr-2">بازگشت</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
