@extends('admin.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-blue"><i class="fa fa-sitemap"></i> لیست دسته‌بندی‌ها</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item active">دسته‌بندی‌ها</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('categories.create') }}" class="btn sport-btn-primary">
                    <i class="fa fa-plus"></i> دسته‌بندی جدید
                </a>
            </div>

            <div class="card sport-card sport-card-blue">
                <div class="card-header">
                    <span class="card-icon icon-blue"><i class="fa fa-sitemap"></i></span>
                    <h3 class="card-title">همه دسته‌بندی‌ها</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle sport-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>نام</th>
                                    <th style="width: 200px;">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $index => $category)
                                    <tr>
                                        <td class="fw-bold">{{ $index + 1 }}</td>
                                        <td class="fw-bold">{{ $category->name }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('categories.edit', $category->id) }}" class="sport-action-btn btn-edit" title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="sport-action-btn btn-delete btn-delete" data-id="{{ $category->id }}" title="حذف">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">دسته‌بندی‌ای وجود ندارد.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($categories->hasPages())
                <div class="card-footer">
                    {{ $categories->links() }}
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
        title: 'آیا از حذف این دسته‌بندی اطمینان دارید؟',
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
