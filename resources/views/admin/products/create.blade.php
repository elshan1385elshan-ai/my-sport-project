@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="m-0">افزودن لوازم ورزشی جدید</h1>
                    <a href="{{ route('products.index') }}" class="btn sport-btn-primary">
                        <i class="fa fa-list"></i> لیست محصولات
                    </a>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card sport-card card-primary">
                            <div class="card-header">
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

                                    <div class="form-group">
                                        <label>نام محصول را وارد نمایید</label>
                                        <input type="text" class="form-control sport-form-control" name="name" value="{{ old('name') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>قیمت را وارد نمایید</label>
                                        <input type="number" class="form-control sport-form-control" name="price" value="{{ old('price') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>تعداد موجودی</label>
                                        <input type="number" class="form-control sport-form-control" name="stock" value="{{ old('stock', 0) }}">
                                    </div>

                                    <div class="form-group">
                                        <label>تخفیف را وارد نمایید (درصد)</label>
                                        <input type="number" class="form-control sport-form-control" name="discount" value="{{ old('discount') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="category_id">انتخاب دسته‌بندی</label>
                                        <select name="category_id" class="form-control sport-form-control" required>
                                            <option value="">-- انتخاب کنید --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="images">تصاویر محصول</label>
                                        <input type="file" id="images" name="images[]" multiple class="form-control sport-form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>توضیحات محصول:</label>
                                        <textarea name="description" class="form-control sport-form-control" rows="4">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn sport-btn-primary">
                                        <i class="fa fa-save"></i> ارسال
                                    </button>
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary">انصراف</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
