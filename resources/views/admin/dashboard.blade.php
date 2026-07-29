@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
  <div class="admin-dashboard">

    <div class="dash-deco dash-deco-1"></div>
    <div class="dash-deco dash-deco-2"></div>
    <div class="dash-deco dash-deco-3"></div>
    <div class="dash-deco dash-deco-4"></div>
    <div class="dash-deco dash-deco-5"></div>

    <section class="content">
      <div class="container-fluid">

        <div class="dash-welcome">
          <i class="fa fa-dashboard welcome-icon"></i>
          <h4>به پنل مدیریت <strong>{{ $appSettings['app_name'] ?? '' }}</strong> خوش آمدید</h4>
          <p>آمار و گزارش‌های امروز فروشگاه خود را مرور کنید</p>
        </div>

        <div class="row stats-row">
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-sunset">
              <div class="inner">
                <h3>{{ $ordersToday }}</h3>
                <p>سفارش‌های امروز</p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-cart"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-ocean">
              <div class="inner">
                <h3>{{ $ordersThisMonth }}</h3>
                <p>سفارش‌های این ماه</p>
              </div>
              <div class="icon">
                <i class="fa fa-calendar"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-forest">
              <div class="inner">
                <h3>{{ number_format($totalRevenue) }}<sup class="text-sm"> تومان</sup></h3>
                <p>مجموع فروش (پرداخت‌شده)</p>
              </div>
              <div class="icon">
                <i class="fa fa-money"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-lavender">
              <div class="inner">
                <h3>{{ $newUsersToday }}</h3>
                <p>کاربران جدید امروز <span class="text-xs d-block mt-1">(کل: {{ $totalUsers }})</span></p>
              </div>
              <div class="icon">
                <i class="fa fa-user-plus"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="dash-sparkle-divider">
          <span></span>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <span></span>
        </div>

        <div class="row stats-row mt-0">
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-mint">
              <div class="inner">
                <h3>{{ $activeProducts }}</h3>
                <p>محصولات موجود (فعال)</p>
              </div>
              <div class="icon">
                <i class="fa fa-check-circle"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-flame">
              <div class="inner">
                <h3>{{ $inactiveProducts }}</h3>
                <p>محصولات ناموجود (غیرفعال)</p>
              </div>
              <div class="icon">
                <i class="fa fa-times-circle"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-stone">
              <div class="inner">
                <h3>{{ $activeProducts + $inactiveProducts }}</h3>
                <p>کل محصولات</p>
              </div>
              <div class="icon">
                <i class="fa fa-archive"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-wine">
              <div class="inner">
                <h3>{{ $pendingOrders }}</h3>
                <p>سفارش‌های در انتظار</p>
              </div>
              <div class="icon">
                <i class="fa fa-hourglass"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-12">
            <div class="dash-footer-note text-center">
              <i class="fa fa-bolt dash-icon-sparkle"></i>
              <span>به پنل مدیریت <strong>{{ $appSettings['app_name'] ?? '' }}</strong> خوش آمدید</span>
              <i class="fa fa-bolt dash-icon-sparkle"></i>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>
</div>
@endsection
