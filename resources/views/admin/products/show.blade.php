@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="sport-page-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1 class="header-icon-orange"><i class="fa fa-cubes"></i> نمایش کل محصولات</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                        <li class="breadcrumb-item active">کل محصولات</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card sport-card sport-card-orange">
                <div class="card-header">
                    <span class="card-icon icon-orange"><i class="fa fa-cubes"></i></span>
                    <h3 class="card-title">کل محصولات ({{ $products->total() }})</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle sport-table mb-0 text-center">
                            <thead>
                                <tr>
                                    <th>تصویر</th>
                                    <th>نام محصول</th>
                                    <th>دسته‌بندی</th>
                                    <th>برند</th>
                                    <th>قیمت</th>
                                    <th>تخفیف</th>
                                    <th>موجودی</th>
                                    <th>وضعیت</th>
                                    <th>زمان ثبت</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr style="cursor: pointer;" onclick="window.location'{{ route('products.index') }}'", title="رفتن به لیست محصولات">
                                        <td>
                                            @if($product->images->count() > 0)
                                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="sport-thumb" alt="{{ $product->name }}">
                                            @else
                                                <span class="badge bg-secondary">بدون تصویر</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold">
                                            <a href="{{ route('products.index') }}" class="text-decoration-none">{{ $product->name }}</a>
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-dark">
                                                {{ $product->categories->first()->name ?? 'بدون دسته' }}
                                            </span>
                                        </td>
                                        <td>{{ $product->brand?->name ?? 'بدون برند' }}</td>
                                        <td>
                                            @if($product->discount_active)
                                                <del class="text-muted ms-1">{{ number_format($product->price) }}</del><br>
                                                <span class="text-success fw-bold">{{ number_format($product->discounted_price) }} تومان</span>
                                            @else
                                                <span>{{ number_format($product->price) }} تومان</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->discount_active)
                                                <span class="text-danger fw-bold">-{{ $product->discount }}%</span>
                                            @else
                                                <span class="text-muted">۰%</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $product->stock > 0 ? $product->stock.' عدد' : 'ناموجود' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $product->is_active ? 'فعال' : 'غیرفعال' }}
                                            </span>
                                        </td>
                                        <td><small>{{ \Carbon\Carbon::parse($product->created_at)->diffForHumans() }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">هیچ محصولی یافت نشد.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($products->hasPages())
                    <div class="card-footer">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection