@extends('admin.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-orange"><i class="fa fa-ticket"></i> کوپن‌های تخفیف</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item active">کوپن‌ها</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.coupons.create') }}" class="btn sport-btn-primary">
                    <i class="fa fa-plus"></i> افزودن کوپن جدید
                </a>
            </div>

            <div class="card sport-card sport-card-orange">
                <div class="card-header">
                    <span class="card-icon icon-orange"><i class="fa fa-ticket"></i></span>
                    <h3 class="card-title">همه کوپن‌ها</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle sport-table mb-0">
                            <thead>
                                <tr>
                                    <th>کد</th>
                                    <th>مقدار تخفیف</th>
                                    <th>حداقل مبلغ سفارش</th>
                                    <th>محدودیت استفاده</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ شروع</th>
                                    <th>تاریخ پایان</th>
                                    <th style="width:100px;">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coupons as $coupon)
                                    <tr>
                                        <td class="fw-bold">
                                            <span class="badge" style="background: linear-gradient(90deg, #e94560, #ff6b6b); color:#fff;">{{ $coupon->code }}</span>
                                        </td>
                                        <td>
                                            @if($coupon->type === 'percent')
                                                <span class="text-success fw-bold">{{ rtrim(rtrim(number_format($coupon->value, 2), '0'), '.') }}%</span>
                                                @if($coupon->max_discount)
                                                    <small class="text-muted d-block">حداکثر {{ number_format($coupon->max_discount) }} تومان</small>
                                                @endif
                                            @else
                                                <span class="text-success fw-bold">{{ number_format($coupon->value) }} تومان</span>
                                            @endif
                                        </td>
                                        <td>{{ $coupon->min_order_amount ? number_format($coupon->min_order_amount).' تومان' : '—' }}</td>
                                        <td>
                                            @if($coupon->usage_limit)
                                                <span class="{{ $coupon->is_exhausted ? 'text-danger' : 'text-muted' }}">{{ $coupon->used_count }} / {{ $coupon->usage_limit }}</span>
                                            @else
                                                <span class="text-muted">نامحدود</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($coupon->is_active)
                                                <span class="badge bg-success">فعال</span>
                                            @else
                                                <span class="badge bg-secondary">غیرفعال</span>
                                            @endif
                                        </td>
                                        <td>{{ $coupon->starts_at ? $coupon->starts_at->format('Y/m/d') : '—' }}</td>
                                        <td>{{ $coupon->ends_at ? $coupon->ends_at->format('Y/m/d') : '—' }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="sport-action-btn btn-edit" title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="sport-action-btn btn-delete" data-id="{{ $coupon->id }}" title="حذف">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <form id="delete-form-{{ $coupon->id }}" action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">هیچ کوپنی یافت نشد.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(method_exists($coupons, 'links'))
                    <div class="card-footer">
                        {{ $coupons->links() }}
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
        title: 'آیا از حذف این کوپن اطمینان دارید؟',
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
