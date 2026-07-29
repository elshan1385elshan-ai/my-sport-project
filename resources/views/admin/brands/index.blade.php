@extends('admin.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-purple"><i class="fa fa-star"></i> لیست برند‌ها</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item active">برند‌ها</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('brands.create') }}" class="btn sport-btn-primary">
                    <i class="fa fa-plus"></i> برند جدید
                </a>
            </div>

            <div class="card sport-card sport-card-purple">
                <div class="card-header">
                    <span class="card-icon icon-purple"><i class="fa fa-star"></i></span>
                    <h3 class="card-title">همه برند‌ها</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle sport-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>تصویر</th>
                                    <th>نام</th>
                                    <th style="width: 200px;">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($brands as $index => $brand)
                                    <tr>
                                        <td class="fw-bold">{{ $index + 1 }}</td>
                                        <td>
                                            @if($brand->image)
                                                <img src="{{ asset('storage/'.$brand->image) }}" alt="{{ $brand->name }}" class="sport-thumb">
                                            @else
                                                <span class="badge bg-secondary">بدون تصویر</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold">{{ $brand->name }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('brands.edit', $brand->id) }}" class="sport-action-btn btn-edit" title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="sport-action-btn btn-delete btn-delete" data-id="{{ $brand->id }}" title="حذف">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <form id="delete-form-{{ $brand->id }}" action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">برندی وجود ندارد.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($brands->hasPages())
                <div class="card-footer">
                    {{ $brands->links() }}
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
        title: 'آیا از حذف این برند اطمینان دارید؟',
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
