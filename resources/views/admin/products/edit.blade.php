@extends('admin.layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-orange"><i class="fa fa-cube"></i> ویرایش محصول</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item"><a href="{{ route('products.index') }}">محصولات</a></li>
              <li class="breadcrumb-item active">ویرایش</li>
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
                            <h3 class="card-title">ویرایش محصول: {{ $product->name }}</h3>
                        </div>

                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

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
                                    <div class="col-md-6">
                                        <div class="sport-form-group">
                                            <label>نام محصول <span class="text-danger">*</span></label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-box input-icon"></i>
                                                <input type="text" class="form-control sport-form-control" name="name" value="{{ old('name', $product->name) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="sport-form-group">
                                            <label>قیمت <span class="text-danger">*</span></label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-dollar input-icon"></i>
                                                <input type="number" class="form-control sport-form-control" name="price" value="{{ old('price', $product->price) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="sport-form-group">
                                            <label>تعداد موجودی</label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-cubes input-icon"></i>
                                                <input type="number" class="form-control sport-form-control" name="stock" value="{{ old('stock', $product->stock) }}">
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
                                                <input type="number" class="form-control sport-form-control" name="discount" value="{{ old('discount', $product->discount) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="sport-form-group">
                                            <label>دسته‌بندی <span class="text-danger">*</span></label>
                                            <select name="category_id" class="form-control sport-form-control" required>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ ($product->category_id == $category->id) ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="sport-form-group">
                                            <label>برند</label>
                                            <select name="brand_id" class="form-control sport-form-control">
                                                <option value="">-- بدون برند --</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{ ($product->brand_id == $brand->id) ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>تصاویر فعلی محصول</label>
                                    <div class="row">
                                        @foreach($product->images as $image)
                                            <div class="col-md-3 mb-3">
                                                <img src="{{ asset('storage/'.$image->image_path) }}" class="img-fluid sport-thumb" style="max-height: 120px; width: auto; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>افزودن تصاویر جدید</label>
                                    <input type="file" name="images[]" multiple class="form-control sport-form-control">
                                </div>

                                <div class="sport-form-group">
                                    <label>توضیحات محصول</label>
                                    <textarea name="description" class="form-control sport-form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn sport-btn-primary">
                                    <i class="fa fa-save"></i> بروزرسانی محصول
                                </button>
                                <a href="{{ route('products.index') }}" class="btn sport-btn-secondary mr-2">بازگشت</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
