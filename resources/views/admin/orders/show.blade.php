@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="d-inline">جزئیات سفارش #{{ $order->id }}</h1>
                </div>
                <div class="col-sm-6 text-left">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fa fa-arrow-right"></i> بازگشت به لیست
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                {{-- اطلاعات کلی سفارش --}}
                <div class="col-md-5">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-info-circle ml-1"></i> اطلاعات سفارش</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th class="text-muted" style="width:40%">شماره سفارش</th>
                                    <td>#{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">تاریخ ثبت</th>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('Y/m/d H:i') }}
                                        <small class="text-muted d-block">({{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }})</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">مبلغ کل</th>
                                    <td><strong>{{ number_format($order->total) }}</strong> تومان</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">وضعیت پرداخت</th>
                                    <td>
                                        <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }} p-2">
                                            {{ $order->payment_status === 'paid' ? 'پرداخت شده' : 'پرداخت نشده' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">وضعیت سفارش</th>
                                    <td>
                                        @php $statusLabel = $statuses[$order->status] ?? $order->status; @endphp
                                        <span class="badge
                                            {{ $order->status === 'pending' ? 'badge-warning' : '' }}
                                            {{ $order->status === 'processing' ? 'badge-info' : '' }}
                                            {{ $order->status === 'shipped' ? 'badge-primary' : '' }}
                                            {{ $order->status === 'delivered' ? 'badge-success' : '' }}
                                            {{ $order->status === 'cancelled' ? 'badge-danger' : '' }} p-2">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- اطلاعات مشتری --}}
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-user ml-1"></i> اطلاعات مشتری</h3>
                        </div>
                        <div class="card-body">
                            @if($order->user)
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <th class="text-muted" style="width:40%">نام</th>
                                        <td>{{ $order->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">ایمیل</th>
                                        <td>{{ $order->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">شماره تماس</th>
                                        <td>{{ $order->user->phone ?? '—' }}</td>
                                    </tr>
                                </table>
                            @else
                                <p class="text-muted mb-0"><i class="fa fa-user-slash ml-1"></i> کاربر حذف‌شده</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- اقلام سفارش --}}
                <div class="col-md-7">
                    <div class="card card-secondary card-outline">
                        <div class="card-header">
                            <div class="card-tools" style="position: absolute; right: 0.5rem; top: 0.4rem;">
                                <span class="badge badge-light p-2">{{ $order->items->sum('quantity') }} عدد</span>
                            </div>
                            <h3 class="card-title float-left" style="margin-right: 8rem;"><i class="fa fa-shopping-cart ml-1"></i> اقلام سفارش</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            @if($order->items->count())
                                <table class="table table-hover text-center align-middle">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>محصول</th>
                                            <th>قیمت واحد</th>
                                            <th>تعداد</th>
                                            <th>جمع</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if($item->product)
                                                        {{ $item->product->name }}
                                                    @else
                                                        <span class="text-muted">محصول حذف‌شده</span>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($item->price) }} تومان</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td><strong>{{ number_format($item->price * $item->quantity) }}</strong> تومان</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-light">
                                            <td colspan="4" class="text-left font-weight-bold">مبلغ کل سفارش:</td>
                                            <td class="font-weight-bold text-primary">{{ number_format($order->total) }} تومان</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @else
                                <div class="text-center p-5">
                                    <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">هیچ قلمی برای این سفارش ثبت نشده است.</p>
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