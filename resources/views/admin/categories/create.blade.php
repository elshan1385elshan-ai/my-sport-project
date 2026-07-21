@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="m-0">ثبت دسته‌بندی جدید</h1>
                <a href="{{ route('categories.index') }}" class="btn sport-btn-primary">
                    <i class="fa fa-list"></i> لیست دسته‌بندی‌ها
                </a>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card sport-card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">فرم دسته‌بندی</h3>
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

                            <form action="{{ route('categories.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label>نام دسته‌بندی <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control sport-form-control" value="{{ old('name') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>دسته‌بندی والد</label>
                                    <select name="parent_id" class="form-control sport-form-control">
                                        <option value="">انتخاب دسته‌بندی والد (اختیاری)</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn sport-btn-primary">
                                    <i class="fa fa-save"></i> ثبت
                                </button>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">بازگشت</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
