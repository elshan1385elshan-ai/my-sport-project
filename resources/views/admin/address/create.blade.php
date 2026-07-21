@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="m-0">وارد کردن آدرس فروشگاه</h1>
                <a href="{{ route('address.show') }}" class="btn sport-btn-primary">
                    <i class="fa fa-eye"></i> مشاهده آدرس فروشگاه
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
                            <h3 class="card-title">فرم ثبت آدرس</h3>
                        </div>

                        <form action="{{ route('address.store') }}" method="POST">
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
                                    <label>استان</label>
                                    <input type="text" class="form-control sport-form-control" name="province" value="{{ old('province') }}" placeholder="مثال: تهران">
                                </div>

                                <div class="form-group">
                                    <label>شهر</label>
                                    <input type="text" class="form-control sport-form-control" name="city" value="{{ old('city') }}" placeholder="مثال: تهران">
                                </div>

                                <div class="form-group">
                                    <label>آدرس کامل</label>
                                    <textarea class="form-control sport-form-control" name="address" rows="3" placeholder="خیابان، کوچه، پلاک">{{ old('address') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>کد پستی</label>
                                    <input type="text" class="form-control sport-form-control" name="postal_code" value="{{ old('postal_code') }}" placeholder="کد پستی ۱۰ رقمی">
                                </div>

                                <div class="form-group">
                                    <label>شماره تماس (اختیاری)</label>
                                    <input type="text" class="form-control sport-form-control" name="phone" value="{{ old('phone') }}" placeholder="مثال: ۰۲۱۱۲۳۴۵۶۷۸">
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn sport-btn-primary">
                                    <i class="fa fa-save"></i> ثبت آدرس
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
