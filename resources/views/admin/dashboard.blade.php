@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">داشبورد مدیریت</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">خانه</a></li>
                    <li class="breadcrumb-item active">داشبورد</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="sport-stat-card c-blue">
                    <div class="stat-icon"><i class="ion ion-bag"></i></div>
                    <div class="stat-body">
                        <h3>{{ $ordersToday }}</h3>
                        <p>سفارش‌های امروز</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="sport-stat-card c-indigo">
                    <div class="stat-icon"><i class="ion ion-calendar"></i></div>
                    <div class="stat-body">
                        <h3>{{ $ordersThisMonth }}</h3>
                        <p>سفارش‌های این ماه</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="sport-stat-card c-green">
                    <div class="stat-icon"><i class="ion ion-cash"></i></div>
                    <div class="stat-body">
                        <h3>{{ number_format($totalRevenue) }}<sup style="font-size: 14px;"> تومان</sup></h3>
                        <p>مجموع فروش (پرداخت‌شده)</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="sport-stat-card c-amber">
                    <div class="stat-icon"><i class="ion ion-person-add"></i></div>
                    <div class="stat-body">
                        <h3>{{ $newUsersToday }}</h3>
                        <p>کاربران جدید امروز (کل: {{ $totalUsers }})</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-3 col-6">
                <div class="sport-stat-card c-olive">
                    <div class="stat-icon"><i class="ion ion-ios-checkmark"></i></div>
                    <div class="stat-body">
                        <h3>{{ $activeProducts }}</h3>
                        <p>محصولات موجود (فعال)</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="sport-stat-card c-red">
                    <div class="stat-icon"><i class="ion ion-ios-close"></i></div>
                    <div class="stat-body">
                        <h3>{{ $inactiveProducts }}</h3>
                        <p>محصولات ناموجود (غیرفعال)</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="sport-stat-card c-gray">
                    <div class="stat-icon"><i class="ion ion-ios-box"></i></div>
                    <div class="stat-body">
                        <h3>{{ $activeProducts + $inactiveProducts }}</h3>
                        <p>کل محصولات</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="sport-stat-card c-maroon">
                    <div class="stat-icon"><i class="ion ion-android-time"></i></div>
                    <div class="stat-body">
                        <h3>{{ $pendingOrders }}</h3>
                        <p>سفارش‌های در انتظار پرداخت/ارسال</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection