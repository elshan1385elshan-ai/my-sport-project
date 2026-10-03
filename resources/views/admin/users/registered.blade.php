@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="sport-page-header">
            <div class="container-fluid">
                <div class="row mb-0">
                    <div class="col-sm-6">
                        <h1 class="header-icon-green"><i class="fa fa-check-circle"></i> کاربران ثبت‌نام شده</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">کاربران</a></li>
                            <li class="breadcrumb-item active">ثبت‌نام شده</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card sport-card sport-card-green">
                    <div class="card-header">
                        <span class="card-icon icon-green"><i class="fa fa-check-circle"></i></span>
                        <h3 class="card-title">لیست کاربران ثبت‌نام شده</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle sport-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">#</th>
                                        <th>نام</th>
                                        <th>ایمیل</th>
                                        <th>نقش</th>
                                    <th>تعداد سفارشات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($registeredUsers as $user)
                                        <tr>
                                            <td class="fw-bold">{{ $user->id }}</td>
                                            <td class="fw-bold">{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge {{ $user->role === 'admin' ? 'badge-warning' : 'badge-info' }}">
                                                    {{ $user->role === 'admin' ? 'مدیر' : 'کاربر' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($user->role === 'user')
                                                    <span class="badge badge-secondary">{{ $user->orders_count }} سفارش</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">هیچ کاربر ثبت‌نام شده‌ای وجود ندارد.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($registeredUsers->hasPages())
                        <div class="card-footer">
                            {{ $registeredUsers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
