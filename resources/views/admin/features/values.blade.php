@extends('admin.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-teal"><i class="fa fa-list-ul"></i> مقادیر ویژگی: {{ $feature->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item"><a href="{{ route('features.index') }}">ویژگی‌ها</a></li>
              <li class="breadcrumb-item active">مقادیر</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="row stats-row">
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-emerald">
              <div class="inner">
                <h3>{{ $feature->values->count() }}</h3>
                <p>تعداد مقادیر</p>
              </div>
              <div class="icon">
                <i class="fa fa-tags"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-sunset">
              <div class="inner">
                <h3>{{ $feature->values->max('sort_order') !== null ? $feature->values->max('sort_order') + 1 : 0 }}</h3>
                <p>آخرین ترتیب</p>
              </div>
              <div class="icon">
                <i class="fa fa-sort-numeric-asc"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-ocean">
              <div class="inner">
                <h3>{{ $feature->created_at ? $feature->created_at->format('Y/m/d') : '-' }}</h3>
                <p>تاریخ ایجاد ویژگی</p>
              </div>
              <div class="icon">
                <i class="fa fa-calendar"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="info-box sport-info-box border-0 bg-card-mint">
              <div class="inner">
                <h3 class="fit-h3">{{ $feature->name }}</h3>
                <p>نام ویژگی</p>
              </div>
              <div class="icon">
                <i class="fa fa-info-circle"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-5">
            <div class="card sport-card sport-card-teal">
              <div class="card-header">
                <span class="card-icon icon-teal"><i class="fa fa-plus"></i></span>
                <h3 class="card-title">افزودن مقدار جدید</h3>
              </div>
              <div class="card-body">
                <form action="{{ route('features.values.store', $feature->id) }}" method="POST">
                  @csrf
                  <div class="sport-form-group">
                    <label>مقدار <span class="text-danger">*</span></label>
                    <div class="sport-input-wrap">
                      <i class="fa fa-circle-o input-icon"></i>
                      <input type="text" name="value" class="form-control sport-form-control"
                             value="{{ old('value') }}" placeholder="مثال: قرمز، بزرگ، چرم" required>
                    </div>
                  </div>
                  <button type="submit" class="btn sport-btn-primary">
                    <i class="fa fa-save"></i> افزودن
                  </button>
                </form>
              </div>
            </div>
          </div>

          <div class="col-md-7">
            <div class="card sport-card sport-card-teal">
              <div class="card-header">
                <span class="card-icon icon-teal"><i class="fa fa-list-ul"></i></span>
                <h3 class="card-title">مقادیر «{{ $feature->name }}»</h3>
              </div>
              <div class="card-body p-0">
                <div class="p-3 pb-0">
                  <input type="text" id="searchValue" class="form-control sport-form-control"
                         placeholder="جستجوی مقدار...">
                </div>
                <div class="table-responsive">
                  <table class="table table-hover align-middle sport-table mb-0" id="valuesTable">
                    <thead>
                      <tr>
                        <th style="width: 60px;">#</th>
                        <th>مقدار</th>
                        <th style="width: 100px;">ترتیب</th>
                        <th style="width: 180px;">عملیات</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($feature->values as $index => $value)
                        <tr data-search="{{ mb_strtolower($value->value) }}">
                          <td class="fw-bold">{{ $index + 1 }}</td>
                          <td class="fw-bold">
                            <span class="sport-value-badge">{{ $value->value }}</span>
                          </td>
                          <td><span class="badge bg-secondary">{{ $value->sort_order }}</span></td>
                          <td>
                            <div class="d-flex gap-1">
                              <button type="button" class="sport-action-btn btn-edit btn-edit-value"
                                      data-id="{{ $value->id }}" data-value="{{ $value->value }}"
                                      data-sort="{{ $value->sort_order }}" title="ویرایش">
                                <i class="fa fa-edit"></i>
                              </button>
                              <button type="button" class="sport-action-btn btn-delete btn-delete-value"
                                      data-id="{{ $value->id }}" data-value="{{ $value->value }}" title="حذف">
                                <i class="fa fa-trash"></i>
                              </button>
                            </div>
                            <form id="delete-value-form-{{ $value->id }}"
                                  action="{{ route('features.values.destroy', $value->id) }}"
                                  method="POST" class="d-none">
                              @csrf
                              @method('DELETE')
                            </form>
                          </td>
                        </tr>
                      @empty
                        <tr id="emptyRow">
                          <td colspan="4" class="text-center py-4">
                            <i class="fa fa-inbox fa-2x text-muted d-block mb-2"></i>
                            برای این ویژگی مقداری ثبت نشده است.
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer d-flex justify-content-between align-items-center">
                <a href="{{ route('features.index') }}" class="btn sport-btn-secondary">
                  <i class="fa fa-arrow-right"></i> بازگشت به ویژگی‌ها
                </a>
                <a href="{{ route('features.edit', $feature->id) }}" class="btn sport-btn-info">
                  <i class="fa fa-cog"></i> مدیریت ویژگی
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div class="modal fade" id="editValueModal" tabindex="-1" role="dialog" aria-labelledby="editValueModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editValueModalLabel">ویرایش مقدار</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editValueForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="sport-form-group">
              <label>مقدار <span class="text-danger">*</span></label>
              <div class="sport-input-wrap">
                <i class="fa fa-circle-o input-icon"></i>
                <input type="text" name="value" id="editValueInput" class="form-control sport-form-control" required>
              </div>
            </div>
            <div class="sport-form-group">
              <label>ترتیب</label>
              <div class="sport-input-wrap">
                <i class="fa fa-sort-numeric-asc input-icon"></i>
                <input type="number" name="sort_order" id="editSortInput" class="form-control sport-form-control" min="0">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn sport-btn-secondary" data-dismiss="modal">انصراف</button>
            <button type="submit" class="btn sport-btn-primary">
              <i class="fa fa-save"></i> ذخیره
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
  $('#searchValue').on('keyup', function() {
    var q = $(this).val().toLowerCase();
    $('#valuesTable tbody tr').each(function() {
      if ($(this).attr('id') === 'emptyRow') return;
      var text = $(this).data('search') || '';
      if (text.indexOf(q) === -1) {
        $(this).hide();
      } else {
        $(this).show();
      }
    });
  });

  $('.btn-edit-value').on('click', function() {
    var id = $(this).data('id');
    var value = $(this).data('value');
    var sort = $(this).data('sort');
    $('#editValueInput').val(value);
    $('#editSortInput').val(sort);
    $('#editValueForm').attr('action', "{{ url('/admin/features/values') }}/" + id);
    $('#editValueModal').modal('show');
  });

  $('.btn-delete-value').on('click', function() {
    var id = $(this).data('id');
    var value = $(this).data('value');
    Swal.fire({
      title: 'حذف مقدار',
      text: 'آیا از حذف مقدار «' + value + '» مطمئن هستید؟',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'بله، حذف کن',
      cancelButtonText: 'لغو'
    }).then((result) => {
      if (result.isConfirmed) {
        $('#delete-value-form-' + id).submit();
      }
    });
  });
});
</script>
@endpush
