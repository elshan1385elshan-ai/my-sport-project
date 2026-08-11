@extends('admin.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-orange"><i class="fa fa-cube"></i> لیست محصولات ورزشی</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item active">محصولات</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('products.create') }}" class="btn sport-btn-primary">
                    <i class="fa fa-plus"></i> افزودن محصول جدید
                </a>
            </div>

            <div class="card sport-card sport-card-orange">
                <div class="card-header">
                    <span class="card-icon icon-orange"><i class="fa fa-cube"></i></span>
                    <h3 class="card-title">همه محصولات</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle sport-table mb-0">
                            <thead>
                                <tr>
                                    <th>تصویر</th>
                                    <th>نام محصول</th>
                                    <th>دسته‌بندی</th>
                                    <th>قیمت</th>
                                    <th>تخفیف</th>
                                    <th>موجودی</th>
                                    <th style="width:100px;">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>
                                            @if($product->images->count() > 0)
                                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="sport-thumb" alt="{{ $product->name }}">
                                            @else
                                                <span class="badge bg-secondary">بدون تصویر</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold">{{ $product->name }}</td>
                                        <td>
                                            <span class="badge bg-info text-dark">
                                                {{ $product->categories->first()->name ?? 'بدون دسته' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($product->discount > 0)
                                                <del class="text-muted ms-1">{{ number_format($product->price) }} تومان</del><br>
                                                <span class="text-success fw-bold">{{ number_format($product->discounted_price) }} تومان</span>
                                            @else
                                                <span>{{ number_format($product->price) }} تومان</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->discount > 0)
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
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('products.edit', $product->id) }}" class="sport-action-btn btn-edit" title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="sport-action-btn btn-delete btn-delete" data-id="{{ $product->id }}" title="حذف">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">هیچ محصولی یافت نشد.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(method_exists($products, 'links'))
                    <div class="card-footer">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
  </div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $('.btn-delete').on('click', function() {
      var id = $(this).data('id');
      Swal.fire({
        title: 'آیا از حذف این محصول اطمینان دارید؟',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'بله، حذف کن',
        cancelButtonText: 'لغو'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#delete-form-' + id).submit();
        }
      });
    });
  });
</script>
@endpush
