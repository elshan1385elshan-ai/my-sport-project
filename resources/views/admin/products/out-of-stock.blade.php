@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="sport-page-header">
            <div class="container-fluid">
                <div class="row mb-0">
                    <div class="col-sm-6">
                        <h1 class="header-icon-orange"><i class="fa fa-exclamation-triangle"></i> محصولات ناموجود</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('all.products.show') }}">کل محصولات</a></li>
                            <li class="breadcrumb-item active">ناموجود</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card sport-card sport-card-orange border-danger">
                    <div class="card-header">
                        <span class="card-icon icon-orange"><i class="fa fa-times-circle"></i></span>
                        <h3 class="card-title">کالاهای تمام‌شده ({{ $products->total() }})</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle sport-table mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>نام محصول</th>
                                        <th>قیمت</th>
                                        <th>برند</th>
                                        <th>دسته‌بندی</th>
                                        <th>موجودی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                        <tr>
                                            <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="fw-bold">
                                                {{ $product->name }}
                                            </td>
                                            <td>
                                                @if ($product->discount_active)
                                                    <del
                                                        class="text-muted ms-1">{{ number_format($product->price) }}</del><br>
                                                    <span
                                                        class="text-success fw-bold">{{ number_format($product->discounted_price) }}
                                                        تومان</span>
                                                @else
                                                    <span>{{ number_format($product->price) }} تومان</span>
                                                @endif
                                            </td>
                                            <td>{{ $product->brand?->name ?? 'بدون برند' }}</td>
                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    {{ $product->categories->first()->name ?? 'بدون دسته' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-danger p-2">
                                                    {{ $product->stock }} عدد — ناموجود
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fa fa-check-circle fa-3x text-success d-block mb-3"></i>
                                                همه کالاها موجود هستند — هیچ محصولی ناموجود نیست.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($products->hasPages())
                        <div class="card-footer">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
