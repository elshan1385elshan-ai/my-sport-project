@extends('admin.layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-orange"><i class="fa fa-ticket"></i> ویرایش کوپن تخفیف</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">کوپن‌ها</a></li>
              <li class="breadcrumb-item active">ویرایش کوپن</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card sport-card sport-card-orange">
                        <div class="card-header">
                            <span class="card-icon icon-orange"><i class="fa fa-ticket"></i></span>
                            <h3 class="card-title">ویرایش کوپن «{{ $coupon->code }}»</h3>
                        </div>

                        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" id="coupon-form">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="sport-form-group">
                                            <label>کد کوپن <span class="text-danger">*</span></label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-ticket input-icon"></i>
                                                <input type="text" class="form-control sport-form-control" name="code" value="{{ old('code', $coupon->code) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="sport-form-group">
                                            <label>نوع تخفیف <span class="text-danger">*</span></label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-percent input-icon"></i>
                                                <select name="type" id="couponType" class="form-control sport-form-control" required>
                                                    <option value="percent" {{ old('type', $coupon->type) === 'percent' ? 'selected' : '' }}>درصدی</option>
                                                    <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>مبلغ ثابت</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="sport-form-group">
                                            <label id="valueLabel">مقدار تخفیف <span class="text-danger">*</span></label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-money input-icon"></i>
                                                <input type="number" step="0.01" class="form-control sport-form-control" name="value" value="{{ old('value', $coupon->value) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="sport-form-group">
                                            <label>حداقل مبلغ سفارش</label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-shopping-basket input-icon"></i>
                                                <input type="number" step="0.01" class="form-control sport-form-control" name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount) }}" placeholder="اختیاری">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4" id="maxDiscountWrap">
                                        <div class="sport-form-group">
                                            <label>حداکثر مبلغ تخفیف</label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-credit-card input-icon"></i>
                                                <input type="number" step="0.01" class="form-control sport-form-control" name="max_discount" value="{{ old('max_discount', $coupon->max_discount) }}" placeholder="فقط برای نوع درصدی">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="sport-form-group">
                                            <label>محدودیت تعداد استفاده</label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-hashtag input-icon"></i>
                                                <input type="number" class="form-control sport-form-control" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" placeholder="خالی = نامحدود">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="sport-form-group">
                                            <label>تاریخ شروع</label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-calendar input-icon"></i>
                                                <input type="text" class="form-control sport-form-control persian-datepicker" name="starts_at" id="starts_at"
                                                       data-gregorian-date="{{ $coupon->starts_at ? $coupon->starts_at->format('Y-m-d\TH:i') : '' }}">
                                            </div>
                                            <small class="text-muted">شمسی — خالی = بلافاصله فعال</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="sport-form-group">
                                            <label>تاریخ پایان</label>
                                            <div class="sport-input-wrap">
                                                <i class="fa fa-calendar-times input-icon"></i>
                                                <input type="text" class="form-control sport-form-control persian-datepicker" name="ends_at" id="ends_at"
                                                       data-gregorian-date="{{ $coupon->ends_at ? $coupon->ends_at->format('Y-m-d\TH:i') : '' }}">
                                            </div>
                                            <small class="text-muted">شمسی — خالی = بدون محدودیت زمان</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="sport-form-group">
                                            <label>وضعیت</label>
                                            <div class="sport-discount-toggle d-flex align-items-center p-2 rounded-lg" style="background: rgba(40,167,69,0.06); border: 1px solid rgba(40,167,69,0.15);">
                                                <div class="form-check form-switch m-0 d-flex align-items-center flex-shrink-0">
                                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $coupon->is_active ? 'checked' : '' }} style="cursor: pointer; margin-top: 0; margin-bottom: 0;">
                                                </div>
                                                <small class="text-muted mr-2 flex-grow-1">کوپن فعال باشد</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn sport-btn-primary">
                                    <i class="fa fa-save"></i> ویرایش کوپن
                                </button>
                                <a href="{{ route('admin.coupons.index') }}" class="btn sport-btn-secondary mr-2">انصراف</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    function updateValueLabel() {
      var type = $('#couponType').val();
      if (type === 'fixed') {
        $('#valueLabel').text('مقدار تخفیف (تومان) *');
        $('#maxDiscountWrap').hide();
      } else {
        $('#valueLabel').text('مقدار تخفیف (درصد) *');
        $('#maxDiscountWrap').show();
      }
    }

    $('#couponType').on('change', updateValueLabel);
    updateValueLabel();

    // Convert stored Gregorian dates to Shamsi for display in the datepickers
    $('.persian-datepicker').each(function() {
      var $input = $(this);
      var gregorian = $input.data('gregorian-date');
      if (gregorian && typeof persianDate === 'function') {
        try {
          var jalali = new persianDate(new Date(gregorian));
          $input.val(jalali.format('YYYY/MM/DD HH:mm'));
        } catch (e) {
          console.error('Date conversion error:', e);
          $input.val(gregorian);
        }
      }
    });
  });
</script>
@endpush
