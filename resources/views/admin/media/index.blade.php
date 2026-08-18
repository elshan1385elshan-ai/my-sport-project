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
                        <div class="sport-file-upload" style="padding: 40px 20px;">
                            <input type="file" name="file" id="file-input" accept="image/*">
                            <i class="fa fa-cloud-upload upload-icon"></i>
                            <span class="upload-text">فایل را اینجا بکشید یا کلیک کنید</span>
                            <div class="upload-hint">JPG, PNG, GIF, SVG, WebP, ICO — حداکثر ۲ مگابایت</div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn sport-btn-primary">
                                <i class="fa fa-upload"></i> آپلود
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card sport-card sport-card-pink">
                <div class="card-header">
                    <span class="card-icon icon-pink"><i class="fa fa-images"></i></span>
                    <h3 class="card-title">فایل‌های آپلود شده</h3>
                    <span class="badge badge-pill badge-pink ml-auto" style="background: rgba(255,255,255,0.15); color: #fff;">{{ $files->count() }}</span>
                </div>
                <div class="card-body">
                    @if($files->isEmpty())
                        <div class="text-center py-5">
                            <i class="fa fa-folder-open" style="font-size: 3rem; color: #e83e8c; opacity: 0.3;"></i>
                            <p class="text-muted mt-3 mb-0">هنوز فایلی آپلود نشده است</p>
                        </div>
                    @else
                        <div class="row" id="media-gallery">
                            @foreach($files as $file)
                                <div class="col-md-3 col-sm-4 col-6 mb-3 media-item" data-path="{{ $file['path'] }}" data-url="{{ $file['url'] }}">
                                    <div class="card sport-card h-100" style="transition: all 0.25s ease;">
                                        <div class="card-body text-center p-3 d-flex flex-column align-items-center">
                                            <div style="width: 100%; height: 120px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 10px; background: rgba(0,0,0,0.02); margin-bottom: 10px;">
                                                <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}"
                                                     class="img-fluid" style="max-height: 110px; object-fit: contain;">
                                            </div>
                                            <small class="text-muted text-truncate d-block w-100" title="{{ $file['name'] }}" style="font-size: 0.78rem;">
                                                {{ $file['name'] }}
                                            </small>
                                            <small class="text-muted mb-2" style="font-size: 0.72rem;">
                                                {{ round($file['size'] / 1024, 1) }} KB
                                            </small>
                                            <div class="btn-group btn-group-sm w-100" role="group">
                                                <button type="button" class="btn sport-action-btn btn-view select-media"
                                                        data-path="{{ $file['path'] }}" data-url="{{ $file['url'] }}" title="انتخاب">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <form action="{{ route('media.destroy', basename($file['path'])) }}" method="POST" class="d-inline" style="flex:1;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn sport-action-btn btn-delete w-100"
                                                            onclick="return confirm('آیا از حذف این فایل اطمینان دارید؟')" title="حذف">
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
        $('#file-input').on('change', function () {
            var fileName = $(this).val().split('\\').pop();
            if (fileName) {
                $(this).closest('.sport-file-upload').find('.upload-text').text(fileName);
            }
        });

        $('.select-media').on('click', function () {
            var url = $(this).data('url');
            var path = $(this).data('path');

            if (window.opener) {
                window.opener.mediaSelected(url, path);
                window.close();
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'انتخاب رسانه',
                    text: 'این صفحه باید در حالت انتخاب رسانه باز شود',
                    confirmButtonText: 'باشه'
                });
            }
        });
    });
</script>
@endpush
