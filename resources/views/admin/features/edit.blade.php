@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-teal"><i class="fa fa-tags"></i> ویرایش ویژگی: {{ $feature->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item"><a href="{{ route('features.index') }}">ویژگی‌ها</a></li>
              <li class="breadcrumb-item active">ویرایش</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card sport-card sport-card-teal">
                        <div class="card-header">
                            <span class="card-icon icon-teal"><i class="fa fa-tags"></i></span>
                            <h3 class="card-title">فرم ویژگی</h3>
                        </div>

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

                            <form action="{{ route('features.update', $feature->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="sport-form-group">
                                    <label>نام ویژگی <span class="text-danger">*</span></label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-tag input-icon"></i>
                                        <input type="text" name="name" class="form-control sport-form-control" value="{{ old('name', $feature->name) }}" placeholder="مثال: سایز، رنگ، جنس" required>
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>مقادیر ویژگی</label>
                                    <div id="values-container">
                                        @forelse ($feature->values as $value)
                                        <div class="input-group mb-2 value-row">
                                            <div class="sport-input-wrap flex-grow-1">
                                                <i class="fa fa-circle-o input-icon"></i>
                                                <input type="text" name="values[]" class="form-control sport-form-control" value="{{ $value->value }}" placeholder="مقدار">
                                            </div>
                                            <button type="button" class="btn btn-outline-danger btn-sm mr-2 remove-value">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        @empty
                                        <div class="input-group mb-2 value-row">
                                            <div class="sport-input-wrap flex-grow-1">
                                                <i class="fa fa-circle-o input-icon"></i>
                                                <input type="text" name="values[]" class="form-control sport-form-control" placeholder="مقدار ۱">
                                            </div>
                                            <button type="button" class="btn btn-outline-danger btn-sm mr-2 remove-value" disabled style="opacity:0.4;cursor:not-allowed;">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        @endforelse
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-info mt-1" id="add-value">
                                        <i class="fa fa-plus"></i> افزودن مقدار
                                    </button>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn sport-btn-primary">
                                        <i class="fa fa-save"></i> بروزرسانی
                                    </button>
                                    <a href="{{ route('features.index') }}" class="btn sport-btn-secondary mr-2">بازگشت</a>
                                </div>
                            </form>
                        </div>
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
    var valueIndex = {{ max($feature->values->count(), 1) }};

    $('#add-value').on('click', function() {
      var row = `
        <div class="input-group mb-2 value-row">
          <div class="sport-input-wrap flex-grow-1">
            <i class="fa fa-circle-o input-icon"></i>
            <input type="text" name="values[]" class="form-control sport-form-control" placeholder="مقدار ${++valueIndex}">
          </div>
          <button type="button" class="btn btn-outline-danger btn-sm mr-2 remove-value">
            <i class="fa fa-minus"></i>
          </button>
        </div>`;
      $('#values-container').append(row);
    });

    $(document).on('click', '.remove-value', function() {
      $(this).closest('.value-row').remove();
    });
  });
</script>
@endpush
