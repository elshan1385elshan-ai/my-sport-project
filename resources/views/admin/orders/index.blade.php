@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="d-inline">لیست سفارشات</h1>
                </div>
                <div class="col-sm-6 text-left">
                    <span class="badge badge-primary p-2">{{ $orders->total() }} سفارش</span>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-shopping-cart ml-1"></i> سفارشات ثبت‌شده
                    </h3>

                    <div class="card-tools">
                        <form method="GET" action="{{ route('admin.orders.index') }}" class="form-inline">
                            <div class="input-group input-group-sm" style="width: 220px;">
                                <select name="status" class="custom-select custom-select-sm" onchange="this.form.submit()">
                                    <option value="">همه وضعیت‌ها</option>
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" {{ $selected === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-filter"></i> فیلتر
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    @if($orders->count())
                        <table class="table table-hover table-striped text-center align-middle">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>مشتری</th>
                                    <th>تعداد اقلام</th>
                                    <th>مبلغ کل (تومان)</th>
                                    <th>وضعیت پرداخت</th>
                                    <th>وضعیت سفارش</th>
                                    <th>تاریخ ثبت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            {{ $order->user?->name ?? 'کاربر حذف‌شده' }}
                                            <br><small class="text-muted">{{ $order->user?->email }}</small>
                                        </td>
                                        <td>{{ $order->items->sum('quantity') }} عدد</td>
                                        <td>{{ number_format($order->total) }}</td>
                                        <td>
                                            <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">
                                                {{ $order->payment_status === 'paid' ? 'پرداخت شده' : 'پرداخت نشده' }}
                                            </span>
                                        </td>
                                        <td>
                                            @php $statusLabel = $statuses[$order->status] ?? $order->status; @endphp
                                            <span class="badge
                                                {{ $order->status === 'pending' ? 'badge-warning' : '' }}
                                                {{ $order->status === 'processing' ? 'badge-info' : '' }}
                                                {{ $order->status === 'shipped' ? 'badge-primary' : '' }}
                                                {{ $order->status === 'delivered' ? 'badge-success' : '' }}
                                                {{ $order->status === 'cancelled' ? 'badge-danger' : '' }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info" title="مشاهده جزئیات">
                                                <i class="fa fa-eye"></i> جزئیات
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center p-5">
                            <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">
                                @if($selected)
                                    هیچ سفارشی با وضعیت «{{ $statuses[$selected] }}» یافت نشد.
                                @else
                                    هنوز سفارشی ثبت نشده است.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

                @if($orders->hasPages())
                    <div class="card-footer clearfix">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection