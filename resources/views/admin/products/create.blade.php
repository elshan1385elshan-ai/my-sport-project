@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="sport-page-header">
          <div class="container-fluid">
            <div class="row mb-0">
              <div class="col-sm-6">
                <h1 class="header-icon-orange"><i class="fa fa-cube"></i> افزودن محصول جدید</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('products.index') }}">محصولات</a></li>
                  <li class="breadcrumb-item active">ایجاد</li>
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
                                <span class="card-icon icon-orange"><i class="fa fa-cube"></i></span>
                                <h3 class="card-title">فرم ثبت محصول</h3>
                            </div>

                            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

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
                                                <label>نام محصول <span class="text-danger">*</span></label>
                                                <div class="sport-input-wrap">
                                                    <i class="fa fa-box input-icon"></i>
                                                    <input type="text" class="form-control sport-form-control" name="name" value="{{ old('name') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="sport-form-group">
                                                <label>قیمت <span class="text-danger">*</span></label>
                                                <div class="sport-input-wrap">
                                                    <i class="fa fa-dollar input-icon"></i>
                                                    <input type="number" class="form-control sport-form-control" name="price" value="{{ old('price') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="sport-form-group">
                                                <label>تعداد موجودی</label>
                                                <div class="sport-input-wrap">
                                                    <i class="fa fa-cubes input-icon"></i>
                                                    <input type="number" class="form-control sport-form-control" name="stock" value="{{ old('stock', 0) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="sport-form-group">
                                                <label>تخفیف (درصد)</label>
                                                <div class="sport-input-wrap">
                                                    <i class="fa fa-percent input-icon"></i>
                                                    <input type="number" class="form-control sport-form-control" name="discount" value="{{ old('discount') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="sport-form-group">
                                                <label>برند</label>
                                                <div class="sport-input-wrap">
                                                    <i class="fa fa-tag input-icon"></i>
                                                    <select name="brand_id" class="form-control sport-form-control">
                                                        <option value="">-- بدون برند --</option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sport-form-group">
                                        <label>دسته‌بندی‌ها <span class="text-danger">*</span></label>
                                        <div class="border rounded p-3" style="max-height: 240px; overflow-y: auto; border: 2px solid #e9ecef !important;">
                                            @if($categories && $categories->isNotEmpty())
                                                @include('admin.features.partials.category-tree', [
                                                    'categories' => $categories,
                                                    'depth' => 0,
                                                    'selectedCategories' => old('categories', [])
                                                ])
                                            @else
                                                <p class="text-muted text-center mb-0">هیچ دسته‌بندی یافت نشد.</p>
                                            @endif
                                        </div>
                                        <small class="d-block text-muted mt-2">می‌توانید چند دسته‌بندی را برای یک محصول انتخاب کنید.</small>
                                    </div>

                                    <div class="sport-form-group" id="product-features-section" style="display:none;">
                                        <label>ویژگی‌های دسته‌بندی</label>
                                        <div id="product-features-container" class="row g-3"></div>
                                        <small class="text-muted">برای هر ویژگی، مقدار مورد نظر را انتخاب کنید.</small>
                                    </div>

                                    <div class="sport-form-group">
                                        <label>تصاویر محصول</label>
                                        <div class="sport-input-wrap">
                                            <i class="fa fa-image input-icon"></i>
                                            <input type="file" name="images[]" multiple class="form-control sport-form-control">
                                        </div>
                                    </div>

                                    <div class="sport-form-group">
                                        <label>توضیحات محصول</label>
                                        <textarea name="description" class="form-control sport-form-control" rows="4">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn sport-btn-primary">
                                        <i class="fa fa-save"></i> ذخیره
                                    </button>
                                    <a href="{{ route('products.index') }}" class="btn sport-btn-secondary mr-2">انصراف</a>
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
    var byCategoriesUrl = "{{ route('features.byCategories') }}";

    function loadFeatures() {
      var categoryIds = $('input[name="categories[]"]:checked').map(function() {
        return $(this).val();
      }).get();

      if (!categoryIds.length) {
        $('#product-features-section').hide();
        $('#product-features-container').empty();
        return;
      }

      $.ajax({
        url: byCategoriesUrl,
        type: 'POST',
        data: { _token: '{{ csrf_token() }}', category_ids: categoryIds },
        dataType: 'json',
        success: function(features) {
          $('#product-features-container').empty();

          if (!features.length) {
            $('#product-features-section').hide();
            return;
          }

          features.forEach(function(feature) {
            var col = $('<div class="col-md-6 col-lg-4">');
            var group = $('<div class="sport-form-group">');
            group.append('<label>' + feature.name + '</label>');

            var select = $('<select>')
              .attr('name', 'feature_values[]')
              .addClass('form-control sport-form-control')
              .append('<option value="">-- انتخاب مقدار --</option>');

            feature.values.forEach(function(v) {
              select.append('<option value="' + v.id + '">' + v.value + '</option>');
            });

            group.append(select);
            col.append(group);
            $('#product-features-container').append(col);
          });

          $('#product-features-section').show();
        },
        error: function() {
          $('#product-features-section').hide();
        }
      });
    }

    $(document).on('change', 'input[name="categories[]"]', function() {
      loadFeatures();
    });

    if ($('input[name="categories[]"]:checked').length) {
      loadFeatures();
    }
  });
</script>
@endpush
