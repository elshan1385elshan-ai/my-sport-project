  <nav class="main-header navbar navbar-expand sport-navbar border-bottom-0">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link sport-nav-btn"><i class="fa fa-external-link ml-1"></i> بازگشت به سایت</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('user.dashboard') }}" class="nav-link sport-nav-btn"><i class="fa fa-dashboard ml-1"></i> خانه</a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link sport-nav-btn"><i class="fa fa-bell ml-1"></i> اعلان‌ها</a>
      </li>
    </ul>

    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle px-3" data-toggle="dropdown" href="#">
          <span class="sport-nav-user-avatar"><i class="fa fa-user-circle"></i></span>
          <span class="sport-nav-user-name">{{ Auth::user()?->name ?? 'کاربر' }}</span>
        </a>
        <div class="dropdown-menu sport-nav-dropdown-menu dropdown-menu-left">
          <div class="dropdown-header sport-dropdown-header">
            <strong>{{ Auth::user()?->name ?? 'کاربر' }}</strong>
            <small class="d-block text-muted">{{ Auth::user()?->email ?? '' }}</small>
          </div>
          <div class="dropdown-divider"></div>
          <a href="{{ route('user.dashboard') }}" class="dropdown-item sport-nav-dropdown-item">
            <i class="fa fa-dashboard ml-1"></i> داشبورد
          </a>
          <a href="{{ route('profile.edit') }}" class="dropdown-item sport-nav-dropdown-item">
            <i class="fa fa-user ml-1"></i> پروفایل
          </a>
          <a href="{{ route('addresses.index') }}" class="dropdown-item sport-nav-dropdown-item">
            <i class="fa fa-map-marker ml-1"></i> آدرس‌ها
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item sport-nav-dropdown-item text-danger"
             onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();">
            <i class="fa fa-sign-out ml-1"></i> خروج
          </a>
          <form id="logout-form-nav" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
      </li>
    </ul>
  </nav>
