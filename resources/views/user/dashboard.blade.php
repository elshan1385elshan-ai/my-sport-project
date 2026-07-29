@extends('user.layouts.app')
@section('content')
<div class="content-wrapper">
  <div class="user-dashboard">

    <div class="dash-deco dash-deco-1"></div>
    <div class="dash-deco dash-deco-2"></div>
    <div class="dash-deco dash-deco-3"></div>
    <div class="dash-deco dash-deco-4"></div>
    <div class="dash-deco dash-deco-5"></div>

    <section class="content">
      <div class="container-fluid">

        <div class="dash-welcome">
          <i class="fa fa-user-circle welcome-icon"></i>
          <h4>{{ $user->name }} عزیز، خوش آمدید</h4>
          <p>به پنل کاربری <strong>{{ $appSettings['app_name'] ?? '' }}</strong> — از اینجا سفارشات خود را مدیریت کنید</p>
        </div>

        <div class="row stats-row">
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-sunset">
              <div class="inner">
                <h3 class="fit-h3">{{ $ordersCount ?? 0 }}</h3>
                <p>تعداد سفارشات</p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-cart"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-forest">
              <div class="inner">
                <h3 class="fit-h3 fit-name">{{ $user->name }}</h3>
                <p>نام کاربری</p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-cobalt">
              <div class="inner">
                <h3 class="fit-h3 fit-email">{{ $user->email }}</h3>
                <p>ایمیل</p>
              </div>
              <div class="icon">
                <i class="fa fa-envelope"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-gold">
              <div class="inner">
                <h3 class="fit-h3 fit-date">{{ $user->created_at ? $user->created_at->diffForHumans() : '-' }}</h3>
                <p>عضویت از</p>
              </div>
              <div class="icon">
                <i class="fa fa-clock-o"></i>
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

        <div class="row mt-0">
          <div class="col-lg-6">
            <div class="card sport-card border-0 dash-section-card" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #dbeafe 100%);">
              <div class="card-header" style="background: linear-gradient(135deg, #0ea5e9, #2563eb); color: #fff; border-radius: 16px 16px 0 0;">
                <span class="card-icon icon-cyan"><i class="fa fa-truck"></i></span>
                <h3 class="card-title" style="color:#fff;">آخرین سفارشات</h3>
              </div>
              <div class="card-body">
                @if(isset($recentOrders) && $recentOrders->count())
                  <table class="table table-bordered sport-table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>تاریخ</th>
                        <th>وضعیت</th>
                        <th>مبلغ</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($recentOrders as $order)
                        <tr>
                          <td>{{ $order->id }}</td>
                          <td>{{ $order->created_at->format('Y/m/d') }}</td>
                          <td><span class="badge badge-info">{{ $order->status ?? 'نامشخص' }}</span></td>
                          <td>{{ number_format($order->total_price ?? 0) }} تومان</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                @else
                  <p class="text-muted text-center">هنوز سفارشی ثبت نشده است.</p>
                @endif
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card sport-card border-0 dash-section-card" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #bbf7d0 100%);">
              <div class="card-header" style="background: linear-gradient(135deg, #10b981, #059669); color: #fff; border-radius: 16px 16px 0 0;">
                <span class="card-icon icon-green"><i class="fa fa-id-card"></i></span>
                <h3 class="card-title" style="color:#fff;">اطلاعات حساب</h3>
              </div>
              <div class="card-body">
                <ul class="list-group list-group-flush dash-account-list">
                  <li class="list-group-item d-flex justify-content-between">
                    <span>نام:</span>
                    <strong>{{ $user->name }}</strong>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>ایمیل:</span>
                    <strong>{{ $user->email }}</strong>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>نقش:</span>
                    <span class="badge badge-success">{{ $user->role === 'admin' ? 'مدیر' : 'کاربر' }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>تاریخ عضویت:</span>
                    <strong>{{ $user->created_at ? $user->created_at->format('Y/m/d') : '-' }}</strong>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-12">
            <div class="dash-footer-note text-center">
              <i class="fa fa-star dash-icon-sparkle"></i>
              <span>به پنل کاربری <strong>{{ $appSettings['app_name'] ?? '' }}</strong> خوش آمدید</span>
              <i class="fa fa-star dash-icon-sparkle"></i>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>
</div>
@endsection
