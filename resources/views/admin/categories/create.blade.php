@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-blue"><i class="fa fa-sitemap"></i> ثبت دسته‌بندی جدید</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">دسته‌بندی‌ها</a></li>
              <li class="breadcrumb-item active">ایجاد</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card sport-card sport-card-blue">
                        <div class="card-header">
                            <span class="card-icon icon-blue"><i class="fa fa-sitemap"></i></span>
                            <h3 class="card-title">فرم دسته‌بندی</h3>
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

                            <form action="{{ route('categories.store') }}" method="POST">
                                @csrf

                                <div class="sport-form-group">
                                    <label>نام دسته‌بندی <span class="text-danger">*</span></label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-folder input-icon"></i>
                                        <input type="text" name="name" class="form-control sport-form-control" value="{{ old('name') }}" required>
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>نوع دسته‌بندی <span class="text-danger">*</span></label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-tags input-icon"></i>
                                        <select id="category_type" class="form-control sport-form-control" required>
                                            <option value="">انتخاب کنید</option>
                                            <option value="parent" {{ old('parent_id') == '' && old('category_type') == 'parent' ? 'selected' : '' }}>دسته‌بندی والد</option>
                                            <option value="child" {{ old('parent_id') != '' || old('category_type') == 'child' ? 'selected' : '' }}>دسته‌بندی فرزند</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sport-form-group" id="parent_select_div" style="display:{{ old('parent_id') ? 'block' : 'none' }};">
                                    <label>دسته‌بندی والد <span class="text-danger">*</span></label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-folder-open input-icon"></i>
                                        <select name="parent_id" id="parent_id" class="form-control sport-form-control">
                                            <option value="">انتخاب دسته‌بندی والد</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" name="parent_id" id="parent_id_hidden" value="">

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn sport-btn-primary">
                                        <i class="fa fa-save"></i> ثبت
                                    </button>
                                    <a href="{{ route('categories.index') }}" class="btn sport-btn-secondary mr-2">بازگشت</a>
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
    function toggleParent() {
        var val = $('#category_type').val();
        if (val === 'child') {
            $('#parent_select_div').show();
            $('#parent_id').prop('required', true);
            $('#parent_id_hidden').prop('disabled', true);
        } else {
            $('#parent_select_div').hide();
            $('#parent_id').prop('required', false).val('');
            $('#parent_id_hidden').prop('disabled', false).val('');
        }
    }

    $('#category_type').on('change', toggleParent);
    toggleParent();
});
</script>
@endpush
