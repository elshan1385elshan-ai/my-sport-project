@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-blue"><i class="fa fa-sitemap"></i> ویرایش دسته‌بندی</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">دسته‌بندی‌ها</a></li>
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
                    <div class="card sport-card sport-card-blue">
                        <div class="card-header">
                            <span class="card-icon icon-blue"><i class="fa fa-sitemap"></i></span>
                            <h3 class="card-title">ویرایش دسته‌بندی «{{ $category->name }}»</h3>
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

                            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="sport-form-group">
                                    <label>نام دسته‌بندی <span class="text-danger">*</span></label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-folder input-icon"></i>
                                        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control sport-form-control" required>
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>دسته‌بندی والد</label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-folder-open input-icon"></i>
                                        <select name="parent_id" class="form-control sport-form-control">
                                            <option value="">انتخاب دسته‌بندی والد (اختیاری)</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>تصویر دسته‌بندی</label>
                                    @if($category->image)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" class="sport-thumb" style="width:80px;height:80px;">
                                        </div>
                                    @endif
                                    <div class="sport-file-upload">
                                        <input type="file" name="image" accept="image/*">
                                        <i class="fa fa-cloud-upload upload-icon"></i>
                                        <span class="upload-text">فایل را اینجا بکشید یا کلیک کنید</span>
                                        <div class="upload-hint">JPG, PNG, WebP — حداکثر ۲ مگابایت</div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn sport-btn-primary">
                                        <i class="fa fa-save"></i> ذخیره تغییرات
                                    </button>
                                    <a href="{{ route('categories.index') }}" class="btn sport-btn-secondary mr-2">بازگشت</a>
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

