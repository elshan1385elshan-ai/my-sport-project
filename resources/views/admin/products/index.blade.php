@extends('admin.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">لیست محصولات ورزشی</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
          <i class="fa fa-plus"></i> افزودن محصول جدید
        </a>
      </div>

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
                  <th>توضیحات</th>
                  <th class="text-center">عملیات</th>
                </tr>
              </thead>
              <tbody>
                @forelse($products as $product)
                  <tr>
                    <td class="ps-4">
                      @if($product->images->count() > 0)
                        {{-- نمایش اولین عکس محصول --}}
                        <img
                          src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                          class="img-thumbnail"
                          style="width: 50px; height: 50px; object-fit: cover;"
                          alt="{{ $product->name }}"
                        >
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
                    <td>
                      @if($product->discount > 0)
                        <del class="text-muted ms-1">{{ number_format($product->price) }} تومان</del>
                        <span class="text-success fw-bold">{{ number_format($product->discounted_price) }} تومان</span>
                      @else
                        <span>{{ number_format($product->price) }} تومان</span>
                      @endif
                    </td>
                    <td>
                      @if($product->discount > 0)
                        <span class="text-danger">-{{ $product->discount }}%</span>
                      @else
                        <span class="text-muted">۰%</span>
                      @endif
                    </td>
                    <td class="fw-bold">{{ $product->description }}</td>
                    <td class="text-center">
                      <div class="btn-group btn-group-sm">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                          <i class="fa fa-edit"></i> ویرایش
                        </a>
                        <button type="button" class="btn btn-danger btn-delete" data-id="{{ $product->id }}">
                          <i class="fa fa-trash"></i> حذف
                        </button>
                        <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-none">
                          @csrf
                          @method('DELETE')
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center py-4 text-muted">هیچ محصولی یافت نشد.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
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

