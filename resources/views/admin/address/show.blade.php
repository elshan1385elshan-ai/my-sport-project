@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="m-0">آدرس فروشگاه شما</h1>
                <div class="d-flex gap-2">
                    @if(!$address)
                        <a href="{{ route('address.create') }}" class="btn sport-btn-primary">
                            <i class="fa fa-plus"></i> وارد کردن آدرس
                        </a>
                    @else
                        <a href="{{ route('address.edit') }}" class="btn sport-btn-primary">
                            <i class="fa fa-edit"></i> ویرایش آدرس
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card sport-card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">جزئیات آدرس</h3>
                        </div>

                        <div class="card-body">
                            @if($address)
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <strong>استان:</strong>
                                        <p class="text-muted mb-0">{{ $address->province }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>شهر:</strong>
                                        <p class="text-muted mb-0">{{ $address->city }}</p>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <strong>آدرس:</strong>
                                        <p class="text-muted mb-0">{{ $address->address }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>کد پستی:</strong>
                                        <p class="text-muted mb-0">{{ $address->postal_code }}</p>
                                    </div>
                                    @if($address->phone)
                                        <div class="col-md-6 mb-3">
                                            <strong>شماره تماس:</strong>
                                            <p class="text-muted mb-0">{{ $address->phone }}</p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fa fa-map-marker" style="font-size: 4rem; color: #ccc;"></i>
                                    <h4 class="mt-3 text-muted">هنوز آدرسی ثبت نکرده‌اید</h4>
                                    <p class="text-muted">برای ثبت محصول باید ابتدا آدرس فروشگاه خود را وارد کنید</p>
                                    <a href="{{ route('address.create') }}" class="btn sport-btn-primary mt-2">
                                        <i class="fa fa-plus"></i> وارد کردن آدرس
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
