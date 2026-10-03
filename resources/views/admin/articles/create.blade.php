@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="sport-page-header">
            <div class="container-fluid">
                <div class="row mb-0">
                    <div class="col-sm-6">
                        <h1 class="header-icon-purple"><i class="fa fa-newspaper-o"></i> ثبت مقاله جدید</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">مقالات</a></li>
                            <li class="breadcrumb-item active">ایجاد</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <div class="card sport-card sport-card-purple">
                            <div class="card-header">
                                <span class="card-icon icon-purple"><i class="fa fa-newspaper-o"></i></span>
                                <h3 class="card-title">فرم مقاله</h3>
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

                                <form action="{{ route('admin.articles.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="sport-form-group">
                                        <label>عنوان مقاله <span class="text-danger">*</span></label>
                                        <div class="sport-input-wrap">
                                            <i class="fa fa-header input-icon"></i>
                                            <input type="text" name="title" class="form-control sport-form-control"
                                                value="{{ old('title') }}" required>
                                        </div>
                                    </div>

                                    <div class="sport-form-group">
                                        <label>دسته‌بندی</label>
                                        <select name="article_category_id" class="form-control sport-form-control">
                                            <option value="">— بدون دسته‌بندی —</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('article_category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="sport-form-group">
                                        <label>خلاصه مقاله</label>
                                        <textarea name="excerpt" rows="3" class="form-control sport-form-control" placeholder="خلاصه‌ای کوتاه از مقاله">{{ old('excerpt') }}</textarea>
                                    </div>

                                    <div class="sport-form-group">
                                        <label>متن مقاله <span class="text-danger">*</span></label>
                                        <textarea name="body" rows="10" class="form-control sport-form-control" required>{{ old('body') }}</textarea>
                                    </div>

                                    <div class="sport-form-group">
                                        <label>تصویر مقاله</label>
                                        <div class="sport-file-upload">
                                            <input type="file" name="image" accept="image/*">
                                            <i class="fa fa-cloud-upload upload-icon"></i>
                                            <span class="upload-text">فایل را اینجا بکشید یا کلیک کنید</span>
                                            <div class="upload-hint">JPG, PNG, WebP — حداکثر ۲ مگابایت</div>
                                        </div>
                                    </div>

                                    <div class="sport-form-group form-check">
                                        <input type="checkbox" name="is_published" id="is_published" value="1"
                                            class="form-check-input" {{ old('is_published') ? 'checked' : '' }}>
                                        <label for="is_published" class="form-check-label">انتشار مقاله (در صورت عدم انتخاب،
                                            به‌عنوان پیش نویس ذخیره می‌شود)</label>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn sport-btn-primary">
                                            <i class="fa fa-save"></i> ثبت
                                        </button>
                                        <a href="{{ route('admin.articles.index') }}"
                                            class="btn sport-btn-secondary mr-2">بازگشت</a>
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
