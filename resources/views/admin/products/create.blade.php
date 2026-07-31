@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="sport-page-header">
          <div class="container-fluid">
            <div class="row mb-0">
              <div class="col-sm-6">
                <h1 class="header-icon-orange"><i class="fa fa-cube"></i> افزودن محصول جدید</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('products.index') }}">محصولات</a></li>
                  <li class="breadcrumb-item active">ایجاد</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card sport-card sport-card-orange">
                            <div class="card-header">
                                <span class="card-icon icon-orange"><i class="fa fa-cube"></i></span>
                                <h3 class="card-title">فرم ثبت محصول</h3>
                            </div>

                            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
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

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="sport-form-group">
                                                <label>نام محصول <span class="text-danger">*</span></label>
                                                <div class="sport-input-wrap">
                                                    <i class="fa fa-box input-icon"></i>
                                                    <input type="text" class="form-control sport-form-control" name="name" value="{{ old('name') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="sport-form-group">
                                                <label>قیمت <span class="text-danger">*</span></label>
                                                <div class="sport-input-wrap">
                                                    <i class="fa fa-dollar input-icon"></i>
                                                    <input type="number" class="form-control sport-form-control" name="price" value="{{ old('price') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="sport-form-group">
                                                <label>تعداد موجودی</label>
                                                <div class="sport-input-wrap">
                                                    <i class="fa fa-cubes input-icon"></i>
                                                    <input type="number" class="form-control sport-form-control" name="stock" value="{{ old('stock', 0) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="sport-form-group">
                                                <label>تخفیف (درصد)</label>
                                                <div class="sport-input-wrap">
                                                    <i class="fa fa-percent input-icon"></i>
                                                    <input type="number" class="form-control sport-form-control" name="discount" value="{{ old('discount') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="sport-form-group">
                                                <label>دسته‌بندی <span class="text-danger">*</span></label>
                                                <div class="sport-input-wrap">
                                                    <i class="fa fa-sitemap input-icon"></i>
                                                    <select name="category_id" class="form-control sport-form-control" required>
                                                        <option value="">-- انتخاب کنید --</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="sport-form-group">
                                                <label>برند</label>
                                                <div class="sport-input-wrap">
                                                    <i class="fa fa-tag input-icon"></i>
                                                    <select name="brand_id" class="form-control sport-form-control">
                                                        <option value="">-- بدون برند --</option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sport-form-group">
                                        <label>تصاویر محصول</label>
                                        <div class="sport-input-wrap">
                                            <i class="fa fa-image input-icon"></i>
                                            <input type="file" name="images[]" multiple class="form-control sport-form-control">
                                        </div>
                                    </div>

                                    <div class="sport-form-group">
                                        <label>توضیحات محصول</label>
                                        <textarea name="description" class="form-control sport-form-control" rows="4">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn sport-btn-primary">
                                        <i class="fa fa-save"></i> ذخیره
                                    </button>
                                    <a href="{{ route('products.index') }}" class="btn sport-btn-secondary mr-2">انصراف</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
