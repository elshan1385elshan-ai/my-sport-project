@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">لیست محصولات ورزشی</h2>
        <a href="{{ route('sports.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> افزودن محصول جدید
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">تصویر</th>
                            <th>نام محصول</th>
                            <th>دسته‌بندی</th>
                            <th>قیمت</th>
                            <th>تخفیف</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="ps-4">
                                    @if($product->images->count() > 0)
                                        {{-- نمایش اولین عکس محصول --}}
                                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                             class="img-thumbnail" 
                                             style="width: 50px; height: 50px; object-fit: cover;" 
                                             alt="{{ $product->name }}">
                                    @else
                                        <span class="badge bg-secondary">بدون تصویر</span>
                                    @endif
                                </td>
                                <td class="fw-bold">{{ $product->name }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $product->category->name ?? 'بدون دسته' }}
                                    </span>
                                </td>
                                <td>{{ number_format($product->price) }} ریال</td>
                                <td>
                                    @if($product->discount > 0)
                                        <span class="text-danger">-{{ $product->discount }}%</span>
                                    @else
                                        <span class="text-muted">۰%</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('sports.edit', $product->id) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i> ویرایش
                                        </a>
                                        <form action="{{ route('sports.destroy', $product->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این محصول اطمینان دارید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    هیچ محصولی یافت نشد.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection