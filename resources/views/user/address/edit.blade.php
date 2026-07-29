@extends('user.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-amber"><i class="fa fa-map-marker"></i> ویرایش آدرس</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item"><a href="{{ route('addresses.index') }}">آدرس‌ها</a></li>
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
                    <div class="card sport-card sport-card-amber card-primary">
                        <div class="card-header">
                            <span class="card-icon icon-amber"><i class="fa fa-map-marker"></i></span>
                            <h3 class="card-title">فرم ویرایش آدرس</h3>
                        </div>

                        <form action="{{ route('addresses.update', $address->id) }}" method="POST">
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

                                <div class="sport-form-group">
                                    <label>استان <span class="text-danger">*</span></label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-globe input-icon"></i>
                                        <input type="text" class="form-control sport-form-control" name="province"
                                               value="{{ old('province', $address->province) }}" placeholder="مثال: تهران" required>
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>شهر <span class="text-danger">*</span></label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-building input-icon"></i>
                                        <input type="text" class="form-control sport-form-control" name="city"
                                               value="{{ old('city', $address->city) }}" placeholder="مثال: تهران" required>
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>آدرس کامل <span class="text-danger">*</span></label>
                                    <textarea class="form-control sport-form-control" name="address" rows="3"
                                              placeholder="خیابان، کوچه، پلاک" required>{{ old('address', $address->address) }}</textarea>
                                </div>

                                <div class="sport-form-group">
                                    <label>کد پستی <span class="text-danger">*</span></label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-envelope input-icon"></i>
                                        <input type="text" class="form-control sport-form-control" name="postal_code"
                                               value="{{ old('postal_code', $address->postal_code) }}" placeholder="کد پستی ۱۰ رقمی" required>
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>شماره تماس (اختیاری)</label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-phone input-icon"></i>
                                        <input type="text" class="form-control sport-form-control" name="phone"
                                               value="{{ old('phone', $address->phone) }}" placeholder="مثال: ۰۲۱۱۲۳۴۵۶۷۸">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn sport-btn-primary">
                                    <i class="fa fa-save"></i> ذخیره تغییرات
                                </button>
                                <a href="{{ route('addresses.index') }}" class="btn sport-btn-secondary mr-2">بازگشت</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
