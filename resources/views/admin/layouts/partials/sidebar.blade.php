  <aside class="main-sidebar sidebar-dark-primary elevation-4 sport-sidebar">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link sport-brand">
      <i class="nav-icon fa fa-trophy brand-image elevation-3" style="opacity:.9;"></i>
      <span class="brand-text font-weight-bold">خانه قهرمانان</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
      <div style="direction: rtl">

        <!-- Sidebar Menu -->
        <nav class="mt-3">
          <ul class="nav nav-pills nav-sidebar flex-column sport-nav" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
              <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::currentRouteName() === 'admin.dashboard' ? 'active' : '' }}">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>داشبورد</p>
              </a>
            </li>

            <li class="nav-item has-treeview {{ request()->is('products*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-shopping-bag"></i>
                <p>
                  مدیریت کالاها
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
                <i class="nav-icon fa fa-gear"></i>
                <p>
                  مدیریت دسته‌بندی‌ها
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

            <li class="nav-item has-treeview {{ request()->routeIs('address.*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-map-marker"></i>
                <p>
                  آدرس فروشگاه
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('address.create') }}" class="nav-link {{ request()->routeIs('address.create') ? 'active' : '' }}">
                    <i class="fa fa-plus nav-icon plus"></i>
                    <p>وارد کردن آدرس</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('address.show') }}" class="nav-link {{ request()->routeIs('address.show') ? 'active' : '' }}">
                    <i class="fa fa-eye nav-icon lists-color"></i>
                    <p>آدرس فروشگاه شما</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('address.edit') }}" class="nav-link {{ request()->routeIs('address.edit') ? 'active' : '' }}">
                    <i class="fa fa-edit nav-icon"></i>
                    <p>ویرایش آدرس</p>
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
