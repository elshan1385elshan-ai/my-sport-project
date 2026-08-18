<footer class="main-footer sport-footer">
    <div class="d-flex justify-content-between align-items-center w-100 px-2">
        

        <span class="text-white-50 small footer-center-label">
            <i class="fa fa-user ml-1 text-info"></i> پنل کاربری فروشگاه ورزشی
        </span>

        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}" class="text-white-50 footer-quick-link ml-1" title="مشاهده سایت">
                <i class="fa fa-external-link"></i>
            </a>
            <a href="{{ route('profile.edit') }}" class="text-white-50 footer-quick-link ml-1" title="پروفایل">
                <i class="fa fa-user"></i>
            </a>
            <a href="#" class="text-white-50 footer-quick-link" title="خروج"
               onclick="event.preventDefault(); document.getElementById('logout-form-footer').submit();">
                <i class="fa fa-sign-out"></i>
            </a>
            <form id="logout-form-footer" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>
</footer>
