@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-pink"><i class="fa fa-folder-open"></i> مدیریت رسانه‌ها</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item active">رسانه‌ها</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card sport-card sport-card-pink card-primary">
                <div class="card-header">
                    <span class="card-icon icon-pink"><i class="fa fa-upload"></i></span>
                    <h3 class="card-title">آپلود فایل جدید</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('media.upload') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                        @csrf
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="file" id="file-input" accept="image/*">
                                <label class="custom-file-label" for="file-input">انتخاب فایل</label>
                            </div>
                            <div class="input-group-append">
                                <button type="submit" class="btn sport-btn-primary">
                                    <i class="fa fa-upload"></i> آپلود
                                </button>
                            </div>
                        </div>
                        <small class="text-muted mt-2 d-block">فرمت‌های مجاز: JPG, PNG, GIF, SVG, WebP, ICO - حداکثر ۲ مگابایت</small>
                    </form>
                </div>
            </div>

            <div class="card sport-card sport-card-pink">
                <div class="card-header">
                    <span class="card-icon icon-pink"><i class="fa fa-images"></i></span>
                    <h3 class="card-title">فایل‌های آپلود شده</h3>
                </div>
                <div class="card-body">
                    @if($files->isEmpty())
                        <p class="text-muted text-center mb-0">هنوز فایلی آپلود نشده است</p>
                    @else
                        <div class="row" id="media-gallery">
                            @foreach($files as $file)
                                <div class="col-md-3 col-sm-4 col-6 mb-3 media-item" data-path="{{ $file['path'] }}" data-url="{{ $file['url'] }}">
                                    <div class="card sport-card h-100">
                                        <div class="card-body text-center p-2 d-flex flex-column align-items-center">
                                            <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}"
                                                 class="img-fluid mb-2" style="max-height: 120px; object-fit: contain;">
                                            <small class="text-muted text-truncate d-block w-100" title="{{ $file['name'] }}">
                                                {{ $file['name'] }}
                                            </small>
                                            <small class="text-muted">
                                                {{ round($file['size'] / 1024, 1) }} KB
                                            </small>
                                            <div class="btn-group btn-group-sm mt-2" role="group">
                                                <button type="button" class="btn btn-outline-info select-media"
                                                        data-path="{{ $file['path'] }}" data-url="{{ $file['url'] }}">
                                                    <i class="fa fa-check"></i> انتخاب
                                                </button>
                                                <form action="{{ route('media.destroy', basename($file['path'])) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger"
                                                            onclick="return confirm('آیا از حذف این فایل اطمینان دارید؟')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.custom-file-input').on('change', function () {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        $('.select-media').on('click', function () {
            var url = $(this).data('url');
            var path = $(this).data('path');

            if (window.opener) {
                window.opener.mediaSelected(url, path);
                window.close();
            } else {
                alert('این صفحه باید در حالت انتخاب رسانه باز شود');
            }
        });
    });
</script>
@endpush
