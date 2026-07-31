@extends('admin.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-teal"><i class="fa fa-tags"></i> لیست ویژگی‌ها</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item active">ویژگی‌ها</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('features.create') }}" class="btn sport-btn-primary">
                    <i class="fa fa-plus"></i> ویژگی جدید
                </a>
            </div>

            <div class="card sport-card sport-card-teal">
                <div class="card-header">
                    <span class="card-icon icon-teal"><i class="fa fa-tags"></i></span>
                    <h3 class="card-title">همه ویژگی‌ها</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle sport-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>نام ویژگی</th>
                                    <th style="width: 120px;">تعداد مقادیر</th>
                                    <th style="width: 200px;">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($features as $index => $feature)
                                    <tr>
                                        <td class="fw-bold">{{ $index + 1 }}</td>
                                        <td class="fw-bold">{{ $feature->name }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $feature->values_count }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('features.edit', $feature->id) }}" class="sport-action-btn btn-edit" title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="sport-action-btn btn-delete" data-id="{{ $feature->id }}" title="حذف">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <form id="delete-form-{{ $feature->id }}" action="{{ route('features.destroy', $feature->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">ویژگی‌ای وجود ندارد.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($features->hasPages())
                <div class="card-footer">
                    {{ $features->links() }}
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
        title: 'آیا از حذف این ویژگی اطمینان دارید؟',
        text: 'همه مقادیر مربوط به آن نیز حذف خواهند شد.',
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
