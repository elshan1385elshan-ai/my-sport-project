@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-teal"><i class="fa fa-cogs"></i> تنظیمات اپلیکیشن</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item active">تنظیمات</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card sport-card sport-card-teal card-primary">
                        <div class="card-header">
                            <span class="card-icon icon-teal"><i class="fa fa-cogs"></i></span>
                            <h3 class="card-title">ویرایش تنظیمات عمومی</h3>
                        </div>

                        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
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

                                <div class="sport-form-section">
                                    <h5><i class="fa fa-info-circle"></i> نام و هویت</h5>
                                </div>
                                <div class="sport-form-group">
                                    <label>نام اپلیکیشن</label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-building input-icon"></i>
                                        <input type="text" class="form-control sport-form-control" name="app_name"
                                               value="{{ old('app_name', $settings['app_name']) }}">
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>پیشوند عنوان صفحات</label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-heading input-icon"></i>
                                        <input type="text" class="form-control sport-form-control" name="page_title_prefix"
                                               value="{{ old('page_title_prefix', $settings['page_title_prefix']) }}">
                                    </div>
                                </div>

                                <div class="sport-form-section">
                                    <h5><i class="fa fa-font"></i> فونت</h5>
                                </div>
                                <div class="sport-form-group">
                                    <label>فونت سایت</label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-font input-icon"></i>
                                        <select class="form-control sport-form-control" name="font_family">
                                            @foreach($fontOptions as $value => $label)
                                                <option value="{{ $value }}" {{ old('font_family', $settings['font_family'] ?? "'Vazir', sans-serif") === $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <small class="text-muted">فونت انتخابی در تمام صفحات پنل مدیریت و سایت عمومی اعمال می‌شود.</small>
                                </div>

                                <div class="sport-form-section">
                                    <h5><i class="fa fa-icons"></i> آیکون‌ها</h5>
                                </div>
                                <p class="text-muted small mb-3">می‌توانید از آیکون‌های پیش‌فرض یا تصاویر آپلود شده استفاده کنید.</p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="sport-form-group">
                                            <label>آیکون پنل مدیریت</label>
                                            <div class="mb-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="admin_icon_type"
                                                           id="admin_icon_type_font" value="font"
                                                           {{ old('admin_icon_type', $settings['admin_icon_type'] ?? 'font') === 'font' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="admin_icon_type_font">آیکون Font Awesome</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="admin_icon_type"
                                                           id="admin_icon_type_custom" value="custom"
                                                           {{ old('admin_icon_type', $settings['admin_icon_type'] ?? 'font') === 'custom' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="admin_icon_type_custom">تصویر دلخواه</label>
                                                </div>
                                            </div>

                                            <div id="admin-icon-font-section" class="{{ old('admin_icon_type', $settings['admin_icon_type'] ?? 'font') === 'custom' ? 'd-none' : '' }}">
                                                <div class="sport-input-wrap">
                                                    <i class="fa fa-icons input-icon"></i>
                                                    <select class="form-control sport-form-control" name="admin_icon" id="admin_icon">
                                                        @foreach($adminIconOptions as $value => $label)
                                                            <option value="{{ $value }}" {{ old('admin_icon', $settings['admin_icon']) === $value ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="admin-icon-custom-section" class="{{ old('admin_icon_type', $settings['admin_icon_type'] ?? 'font') === 'custom' ? '' : 'd-none' }}">
                                                <div class="mb-2">
                                                    <label class="small">آپلود تصویر جدید</label>
                                                    <div class="sport-file-upload">
                                                        <input type="file" name="admin_icon_upload" accept="image/*">
                                                        <i class="fa fa-cloud-upload upload-icon"></i>
                                                        <span class="upload-text">انتخاب تصویر</span>
                                                    </div>
                                                </div>
                                                <div class="mt-2">
                                                    <label class="small">یا انتخاب از رسانه‌ها</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control sport-form-control"
                                                               name="admin_icon_custom" id="admin_icon_custom"
                                                               value="{{ old('admin_icon_custom', $settings['admin_icon_custom'] ?? '') }}"
                                                               placeholder="مسیر فایل" readonly>
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn sport-btn-info" onclick="openMediaBrowser('admin_icon_custom', 'admin-icon-preview')">
                                                                <i class="fa fa-folder-open"></i> مرور
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="admin-icon-preview" class="text-center p-2 border rounded mt-2 {{ empty(old('admin_icon_custom', $settings['admin_icon_custom'] ?? '')) ? 'd-none' : '' }}">
                                                    @if(!empty(old('admin_icon_custom', $settings['admin_icon_custom'] ?? '')))
                                                        <img src="{{ Storage::url(old('admin_icon_custom', $settings['admin_icon_custom'])) }}" style="max-height: 60px;">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="sport-form-group">
                                            <label>آیکون سایت عمومی</label>
                                            <div class="mb-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="public_icon_type"
                                                           id="public_icon_type_font" value="font"
                                                           {{ old('public_icon_type', $settings['public_icon_type'] ?? 'font') === 'font' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="public_icon_type_font">آیکون Bootstrap Icons</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="public_icon_type"
                                                           id="public_icon_type_custom" value="custom"
                                                           {{ old('public_icon_type', $settings['public_icon_type'] ?? 'font') === 'custom' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="public_icon_type_custom">تصویر دلخواه</label>
                                                </div>
                                            </div>

                                            <div id="public-icon-font-section" class="{{ old('public_icon_type', $settings['public_icon_type'] ?? 'font') === 'custom' ? 'd-none' : '' }}">
                                                <div class="sport-input-wrap">
                                                    <i class="fa fa-icons input-icon"></i>
                                                    <select class="form-control sport-form-control" name="public_icon" id="public_icon">
                                                        @foreach($publicIconOptions as $value => $label)
                                                            <option value="{{ $value }}" {{ old('public_icon', $settings['public_icon']) === $value ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="public-icon-custom-section" class="{{ old('public_icon_type', $settings['public_icon_type'] ?? 'font') === 'custom' ? '' : 'd-none' }}">
                                                <div class="mb-2">
                                                    <label class="small">آپلود تصویر جدید</label>
                                                    <div class="sport-file-upload">
                                                        <input type="file" name="public_icon_upload" accept="image/*">
                                                        <i class="fa fa-cloud-upload upload-icon"></i>
                                                        <span class="upload-text">انتخاب تصویر</span>
                                                    </div>
                                                </div>
                                                <div class="mt-2">
                                                    <label class="small">یا انتخاب از رسانه‌ها</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control sport-form-control"
                                                               name="public_icon_custom" id="public_icon_custom"
                                                               value="{{ old('public_icon_custom', $settings['public_icon_custom'] ?? '') }}"
                                                               placeholder="مسیر فایل" readonly>
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn sport-btn-info" onclick="openMediaBrowser('public_icon_custom', 'public-icon-preview')">
                                                                <i class="fa fa-folder-open"></i> مرور
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="public-icon-preview" class="text-center p-2 border rounded mt-2 {{ empty(old('public_icon_custom', $settings['public_icon_custom'] ?? '')) ? 'd-none' : '' }}">
                                                    @if(!empty(old('public_icon_custom', $settings['public_icon_custom'] ?? '')))
                                                        <img src="{{ Storage::url(old('public_icon_custom', $settings['public_icon_custom'])) }}" style="max-height: 60px;">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sport-form-section">
                                    <h5><i class="fa fa-align-right"></i> متون</h5>
                                </div>

                                <div class="sport-form-group">
                                    <label>پیام خوش‌آمدگویی صفحه اصلی</label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-comment input-icon"></i>
                                        <input type="text" class="form-control sport-form-control" name="welcome_message"
                                               value="{{ old('welcome_message', $settings['welcome_message']) }}">
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>توضیح فوتر</label>
                                    <textarea class="form-control sport-form-control" name="footer_description" rows="2">{{ old('footer_description', $settings['footer_description']) }}</textarea>
                                </div>

                                <div class="sport-form-group">
                                    <label>متن placeholder جستجو</label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-search input-icon"></i>
                                        <input type="text" class="form-control sport-form-control" name="search_placeholder"
                                               value="{{ old('search_placeholder', $settings['search_placeholder']) }}">
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>متن کپی‌رایت</label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-copyright input-icon"></i>
                                        <input type="text" class="form-control sport-form-control" name="copyright_text"
                                               value="{{ old('copyright_text', $settings['copyright_text']) }}">
                                    </div>
                                    <small class="text-muted">می‌توانید از <code>{app_name}</code> برای درج نام اپلیکیشن استفاده کنید.</small>
                                </div>

                                <div class="sport-form-group">
                                    <label>زیرعنوان پنل مدیریت</label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-text-width input-icon"></i>
                                        <input type="text" class="form-control sport-form-control" name="admin_panel_subtitle"
                                               value="{{ old('admin_panel_subtitle', $settings['admin_panel_subtitle']) }}">
                                    </div>
                                </div>

                                <div class="sport-form-section">
                                    <h5><i class="fa fa-address-card"></i> اطلاعات تماس</h5>
                                </div>

                                <div class="sport-form-group">
                                    <label>آدرس</label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-map-marker input-icon"></i>
                                        <input type="text" class="form-control sport-form-control" name="contact_address"
                                               value="{{ old('contact_address', $settings['contact_address']) }}">
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>تلفن</label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-phone input-icon"></i>
                                        <input type="text" class="form-control sport-form-control" name="contact_phone"
                                               value="{{ old('contact_phone', $settings['contact_phone']) }}">
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>ایمیل</label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-envelope input-icon"></i>
                                        <input type="email" class="form-control sport-form-control" name="contact_email"
                                               value="{{ old('contact_email', $settings['contact_email']) }}">
                                    </div>
                                </div>

                                <div class="sport-form-group">
                                    <label>ساعات کاری</label>
                                    <div class="sport-input-wrap">
                                        <i class="fa fa-clock-o input-icon"></i>
                                        <input type="text" class="form-control sport-form-control" name="contact_hours"
                                               value="{{ old('contact_hours', $settings['contact_hours']) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn sport-btn-primary">
                                    <i class="fa fa-save"></i> ذخیره تنظیمات
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card sport-card sport-card-amber">
                        <div class="card-header">
                            <span class="card-icon icon-amber"><i class="fa fa-eye"></i></span>
                            <h3 class="card-title">پیش‌نمایش</h3>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-4 p-3 rounded" style="background: linear-gradient(180deg, #1a1a2e, #0f3460);">
                                <p class="text-white-50 small mb-2">پنل مدیریت</p>
                                <div id="preview-admin-icon-container">
                                    <i class="fa fa-{{ old('admin_icon', $settings['admin_icon']) }} fa-2x text-warning {{ old('admin_icon_type', $settings['admin_icon_type'] ?? 'font') === 'custom' ? 'd-none' : '' }}" id="preview-admin-icon"></i>
                                    <img src="{{ old('admin_icon_type', $settings['admin_icon_type'] ?? 'font') === 'custom' && !empty(old('admin_icon_custom', $settings['admin_icon_custom'] ?? '')) ? Storage::url(old('admin_icon_custom', $settings['admin_icon_custom'])) : '' }}"
                                         class="{{ old('admin_icon_type', $settings['admin_icon_type'] ?? 'font') === 'custom' ? '' : 'd-none' }}"
                                         id="preview-admin-icon-img" style="max-height: 36px;">
                                </div>
                                <p class="text-white fw-bold mt-2 mb-0" id="preview-app-name">{{ old('app_name', $settings['app_name']) }}</p>
                            </div>
                            <div class="p-3 rounded border">
                                <p class="text-muted small mb-2">سایت عمومی</p>
                                <div id="preview-public-icon-container">
                                    <i class="bi bi-{{ old('public_icon', $settings['public_icon']) }} text-warning fs-2 {{ old('public_icon_type', $settings['public_icon_type'] ?? 'font') === 'custom' ? 'd-none' : '' }}" id="preview-public-icon"></i>
                                    <img src="{{ old('public_icon_type', $settings['public_icon_type'] ?? 'font') === 'custom' && !empty(old('public_icon_custom', $settings['public_icon_custom'] ?? '')) ? Storage::url(old('public_icon_custom', $settings['public_icon_custom'])) : '' }}"
                                         class="{{ old('public_icon_type', $settings['public_icon_type'] ?? 'font') === 'custom' ? '' : 'd-none' }}"
                                         id="preview-public-icon-img" style="max-height: 36px;">
                                </div>
                                <p class="fw-bold mt-2 mb-0" id="preview-public-name">{{ old('app_name', $settings['app_name']) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card sport-card sport-card-pink">
                        <div class="card-header">
                            <span class="card-icon icon-pink"><i class="fa fa-folder-open"></i></span>
                            <h3 class="card-title">رسانه‌های آپلود شده</h3>
                        </div>
                        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                            @if($mediaFiles->isEmpty())
                                <p class="text-muted small mb-0">هنوز رسانه‌ای آپلود نشده است</p>
                            @else
                                <div class="row">
                                    @foreach($mediaFiles as $media)
                                        <div class="col-4 mb-2">
                                            <img src="{{ $media['url'] }}" class="img-fluid border rounded media-thumb"
                                                 style="cursor: pointer; max-height: 60px;"
                                                 onclick="setIconPath('{{ $media['path'] }}')"
                                                 title="{{ $media['name'] }}">
                                        </div>
                                    @endforeach
                                </div>
                                <a href="{{ route('media.index') }}" target="_blank" class="btn btn-sm btn-outline-info mt-2 w-100">
                                    <i class="fa fa-folder-open"></i> مدیریت رسانه‌ها
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script>
    (function () {
        const appNameInput = document.querySelector('[name="app_name"]');
        const adminIconSelect = document.getElementById('admin_icon');
        const publicIconSelect = document.getElementById('public_icon');
        const adminIconTypeFont = document.getElementById('admin_icon_type_font');
        const adminIconTypeCustom = document.getElementById('admin_icon_type_custom');
        const publicIconTypeFont = document.getElementById('public_icon_type_font');
        const publicIconTypeCustom = document.getElementById('public_icon_type_custom');
        const adminIconFontSection = document.getElementById('admin-icon-font-section');
        const adminIconCustomSection = document.getElementById('admin-icon-custom-section');
        const publicIconFontSection = document.getElementById('public-icon-font-section');
        const publicIconCustomSection = document.getElementById('public-icon-custom-section');

        function updatePreview() {
            const appName = appNameInput.value;
            document.getElementById('preview-app-name').textContent = appName;
            document.getElementById('preview-public-name').textContent = appName;

            const adminIcon = adminIconSelect.value;
            const publicIcon = publicIconSelect.value;

            document.getElementById('preview-admin-icon').className = 'fa fa-' + adminIcon + ' fa-2x text-warning';
            document.getElementById('preview-public-icon').className = 'bi bi-' + publicIcon + ' text-warning fs-2';
        }

        function toggleAdminIconType() {
            if (adminIconTypeCustom.checked) {
                adminIconFontSection.classList.add('d-none');
                adminIconCustomSection.classList.remove('d-none');
                document.getElementById('preview-admin-icon').classList.add('d-none');
                document.getElementById('preview-admin-icon-img').classList.remove('d-none');
            } else {
                adminIconFontSection.classList.remove('d-none');
                adminIconCustomSection.classList.add('d-none');
                document.getElementById('preview-admin-icon').classList.remove('d-none');
                document.getElementById('preview-admin-icon-img').classList.add('d-none');
            }
        }

        function togglePublicIconType() {
            if (publicIconTypeCustom.checked) {
                publicIconFontSection.classList.add('d-none');
                publicIconCustomSection.classList.remove('d-none');
                document.getElementById('preview-public-icon').classList.add('d-none');
                document.getElementById('preview-public-icon-img').classList.remove('d-none');
            } else {
                publicIconFontSection.classList.remove('d-none');
                publicIconCustomSection.classList.add('d-none');
                document.getElementById('preview-public-icon').classList.remove('d-none');
                document.getElementById('preview-public-icon-img').classList.add('d-none');
            }
        }

        adminIconTypeFont.addEventListener('change', toggleAdminIconType);
        adminIconTypeCustom.addEventListener('change', toggleAdminIconType);
        publicIconTypeFont.addEventListener('change', togglePublicIconType);
        publicIconTypeCustom.addEventListener('change', togglePublicIconType);

        appNameInput.addEventListener('input', updatePreview);
        adminIconSelect.addEventListener('change', updatePreview);
        publicIconSelect.addEventListener('change', updatePreview);
    })();

    function openMediaBrowser(targetInputId, previewId) {
        var mediaUrl = '{{ route('media.index') }}';
        var features = 'width=900,height=600,scrollbars=yes';
        window.open(mediaUrl + '?target=' + targetInputId + '&preview=' + previewId, 'mediaBrowser', features);
    }

    function setIconPath(path) {
        var adminInput = document.getElementById('admin_icon_custom');
        var publicInput = document.getElementById('public_icon_custom');

        if (adminInput) {
            adminInput.value = path;
            updateCustomPreview('admin_icon_custom', 'admin-icon-preview');
        }
        if (publicInput) {
            publicInput.value = path;
            updateCustomPreview('public_icon_custom', 'public-icon-preview');
        }
    }

    function updateCustomPreview(inputId, previewId) {
        var input = document.getElementById(inputId);
        var preview = document.getElementById(previewId);
        var previewImg = preview ? preview.querySelector('img') : null;
        var storageBase = '{{ Storage::url('') }}';

        if (input && input.value) {
            if (preview) preview.classList.remove('d-none');
            if (previewImg) previewImg.src = storageBase + input.value;
        } else {
            if (preview) preview.classList.add('d-none');
        }
    }

    window.mediaSelected = function(url, path) {
        var urlParams = new URLSearchParams(window.location.search);
        var target = urlParams.get('target') || 'admin_icon_custom';
        var previewId = urlParams.get('preview') || 'admin-icon-preview';

        var input = document.getElementById(target);
        if (input) {
            input.value = path;
            updateCustomPreview(target, previewId);
        }
    };
</script>
@endpush
