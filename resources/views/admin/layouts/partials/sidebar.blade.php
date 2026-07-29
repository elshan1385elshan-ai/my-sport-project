    <aside class="main-sidebar sidebar-dark-primary elevation-4 sport-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="brand-link sport-brand">
      @if(($appSettings['admin_icon_type'] ?? 'font') === 'custom' && !empty($appSettings['admin_icon_custom'] ?? ''))
        <img src="{{ Storage::url($appSettings['admin_icon_custom']) }}" alt="icon" class="brand-image elevation-3 sport-custom-icon">
      @else
        <i class="fa fa-{{ $appSettings['admin_icon'] ?? 'trophy' }} brand-image elevation-3"></i>
      @endif
      <span class="brand-text font-weight-bold">{{ $appSettings['app_name'] ?? 'خانه قهرمانان' }}</span>
      <span class="sport-brand-sub">
        <span class="status-dot"></span>
        پنل مدیریت
      </span>
    </a>

    <div class="sidebar" style="direction: ltr">
      <div style="direction: rtl">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column sport-nav" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-header">منوی اصلی</li>

            <li class="nav-item">
              <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::currentRouteName() === 'admin.dashboard' ? 'active' : '' }}">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>داشبورد</p>
              </a>
            </li>

            <li class="nav-header">مدیریت</li>

            <li class="nav-item has-treeview {{ request()->routeIs('admin.users.*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-users"></i>
                <p>
                  کاربران
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('admin.users.create') }}" class="nav-link">
                    <i class="fa fa-plus nav-icon plus"></i>
                    <p>ایجاد کاربر</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <i class="fa fa-list lists-color nav-icon"></i>
                    <p>کاربران</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview {{ request()->is('products*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-shopping-bag"></i>
                <p>
                  کالاها
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('products.create') }}" class="nav-link">
                    <i class="fa fa-plus nav-icon plus"></i>
                    <p>ایجاد کالا</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('products.index') }}" class="nav-link">
                    <i class="fa fa-list nav-icon lists-color"></i>
                    <p>کالاها</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview {{ request()->is('categories*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-sitemap"></i>
                <p>
                  دسته‌بندی‌ها
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('categories.create') }}" class="nav-link">
                    <i class="fa fa-plus nav-icon plus"></i>
                    <p>ایجاد دسته‌بندی جدید</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('categories.index') }}" class="nav-link">
                    <i class="fa fa-list lists-color nav-icon"></i>
                    <p>دسته‌بندی‌ها</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview {{ request()->is('brands*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-star"></i>
                <p>
                  برندها
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('brands.create') }}" class="nav-link">
                    <i class="fa fa-plus nav-icon plus"></i>
                    <p>ایجاد برند</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('brands.index') }}" class="nav-link">
                    <i class="fa fa-list lists-color nav-icon"></i>
                    <p>برندها</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="{{ route('media.index') }}" class="nav-link {{ request()->routeIs('media.*') ? 'active' : '' }}">
                <i class="nav-icon fa fa-picture-o"></i>
                <p>رسانه‌ها</p>
              </a>
            </li>

            <li class="nav-header">سیستم</li>

            <li class="nav-item has-treeview {{ request()->routeIs('settings.*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-cog"></i>
                <p>
                  تنظیمات
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('settings.edit') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <i class="fa fa-wrench nav-icon"></i>
                    <p>تنظیمات اپلیکیشن</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item sport-logout">
              <a href="#" class="nav-link custom-btn-hover"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="nav-icon fa fa-sign-out"></i>
                <p>خروج</p>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>

          </ul>
        </nav>
      </div>
    </div>
  </aside>
