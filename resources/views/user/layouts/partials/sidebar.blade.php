  <aside class="main-sidebar sidebar-dark-primary elevation-4 sport-sidebar">
    <a href="{{ route('user.dashboard') }}" class="brand-link sport-brand">
      @if(($appSettings['admin_icon_type'] ?? 'font') === 'custom' && !empty($appSettings['admin_icon_custom'] ?? ''))
        <img src="{{ Storage::url($appSettings['admin_icon_custom']) }}" alt="icon" class="brand-image elevation-3 sport-custom-icon">
      @else
        <i class="fa fa-{{ $appSettings['admin_icon'] ?? 'user' }} brand-image elevation-3"></i>
      @endif
      <span class="brand-text font-weight-bold">{{ $appSettings['app_name'] ?? 'پنل کاربری' }}</span>
      <span class="sport-brand-sub">
        <span class="status-dot"></span>
        پنل کاربری
      </span>
    </a>

    <div class="sidebar" style="direction: ltr">
      <div style="direction: rtl">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column sport-nav" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-header">منوی اصلی</li>

            <li class="nav-item">
              <a href="{{ route('user.dashboard') }}" class="nav-link {{ Route::currentRouteName() === 'user.dashboard' ? 'active' : '' }}">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>داشبورد</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('profile.edit') }}" class="nav-link {{ Route::currentRouteName() === 'profile.edit' ? 'active' : '' }}">
                <i class="nav-icon fa fa-user"></i>
                <p>پروفایل</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-shopping-cart"></i>
                <p>سفارشات</p>
              </a>
            </li>

            <li class="nav-header">حساب کاربری</li>

            <li class="nav-item has-treeview {{ request()->routeIs('addresses.*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-map-marker"></i>
                <p>
                  آدرس‌ها
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('addresses.index') }}" class="nav-link {{ request()->routeIs('addresses.index') ? 'active' : '' }}">
                    <i class="fa fa-list nav-icon lists-color"></i>
                    <p>آدرس‌های من</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('addresses.create') }}" class="nav-link {{ request()->routeIs('addresses.create') ? 'active' : '' }}">
                    <i class="fa fa-plus nav-icon plus"></i>
                    <p>ثبت آدرس جدید</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-bell"></i>
                <p>اعلان‌ها</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-envelope"></i>
                <p>پیام‌ها</p>
              </a>
            </li>

            <li class="nav-item sport-logout">
              <a href="#" class="nav-link custom-btn-hover"
                 onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                <i class="nav-icon fa fa-sign-out"></i>
                <p>خروج</p>
              </a>
              <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>

          </ul>
        </nav>
      </div>
    </div>
  </aside>
