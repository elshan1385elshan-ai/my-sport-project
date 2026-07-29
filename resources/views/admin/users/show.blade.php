@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-green"><i class="fa fa-users"></i> مشاهده کاربر</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">کاربران</a></li>
              <li class="breadcrumb-item active">مشاهده</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card sport-card sport-card-green">
                <div class="card-header">
                    <span class="card-icon icon-green"><i class="fa fa-users"></i></span>
                    <h3 class="card-title">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered sport-table mb-0">
                            <tr>
                                <th style="width:150px;">نام</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>ایمیل</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>نقش</th>
                                <td>
                                    <span class="badge {{ $user->role === 'admin' ? 'badge-warning' : 'badge-info' }}">
                                        {{ $user->role === 'admin' ? 'مدیر' : 'کاربر' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>وضعیت فروشنده</th>
                                <td>{{ $user->is_seller ? 'فروشنده' : 'عادی' }}</td>
                            </tr>
                            <tr>
                                <th>تاریخ عضویت</th>
                                <td>{{ $user->created_at ? $user->created_at->format('Y/m/d H:i') : '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn sport-btn-primary">
                            <i class="fa fa-edit"></i> ویرایش
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn sport-btn-secondary">لیست کاربران</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
