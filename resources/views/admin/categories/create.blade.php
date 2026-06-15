@extends('admin.layouts.app')

@section('content') 
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>فرم‌های عمومی</h1>
                    </div >
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="#">خانه</a></li>
                            <li class="breadcrumb-item active">فرم‌های عمومی</li>
                        </ol>
                    </div >
                </div >
            </div >
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">افزودن لوازم ورزشی جدید</h3>
                            </div >

                            <!-- شروع فرم با ویژگی‌های ضروری -->
                            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf <!-- بسیار مهم برای جلوگیری از خطای 419 -->

                                <div class="card-body">
                                    <!-- نمایش پیام‌های خطا (مثل نام تکراری) -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div >
                                    @endif

                                    <div class="form-group">
                                        <label>نام محصول را وارد نمایید</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    </div >
                                    
                                    <div class="form-group">
                                        <label>قیمت را وارد نمایید</label>
                                        <input type="number" class="form-control" name="price" value="{{ old('price') }}">
                                    </div >
                                    
                                    <div class="form-group">
                                        <label>تخفیف را وارد نمایید</label>
                                        <input type="number" class="form-control" name="discount" value="{{ old('discount') }}">
                                    </div >
                                    {{-- <div class="form-group">
                                        <label for="category_id">انتخاب دسته‌بندی</label>
                                        <select name="category_id" class="form-control" required>
                                            <option value="">-- انتخاب کنید --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="form-group">
                                        <label>ارسال فایل</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">انتخاب فایل</label>
                                            </div >
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div >
                                        </div >
                                    </div >
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">ارسال</button>
                                </div >
                            </form>
                            <!-- پایان فرم -->

                        </div >
                    </div >
                </div >
            </div >
        </section>
    </div >
@endsection