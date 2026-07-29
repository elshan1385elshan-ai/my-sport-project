<footer class="main-footer sport-footer">
    <div class="d-flex justify-content-between align-items-center w-100 px-2">
        <div class="d-flex align-items-center">
            <span class="footer-brand-icon d-none d-sm-inline-flex ml-2">
                @if(($appSettings['admin_icon_type'] ?? 'font') === 'custom' && !empty($appSettings['admin_icon_custom'] ?? ''))
                    <img src="{{ Storage::url($appSettings['admin_icon_custom']) }}" alt="icon" class="footer-brand-img">
                @else
                    <i class="fa fa-{{ $appSettings['admin_icon'] ?? 'trophy' }} text-warning"></i>
                @endif
            </span>
            <strong class="text-white-50 small">
                <i class="fa fa-copyright ml-1 text-warning"></i>
                {{ date('Y') }} — <a href="{{ route('home') }}" class="text-warning font-weight-bold">{{ $appSettings['app_name'] }}</a>
            </strong>
        </div>

        <span class="text-white-50 small footer-center-label">
            <i class="fa fa-shield ml-1 text-info"></i> پنل مدیریت فروشگاه ورزشی
        </span>

        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}" class="text-white-50 footer-quick-link ml-1" title="مشاهده سایت">
                <i class="fa fa-external-link"></i>
            </a>
            <a href="#" class="text-white-50 footer-quick-link ml-1" title="تنظیمات" onclick="event.preventDefault();">
                <i class="fa fa-cog"></i>
            </a>
            <a href="#" class="text-white-50 footer-quick-link" title="خروج"
               onclick="event.preventDefault(); document.getElementById('logout-form-footer').submit();">
                <i class="fa fa-sign-out"></i>
            </a>
            <form id="logout-form-footer" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>
</footer>
