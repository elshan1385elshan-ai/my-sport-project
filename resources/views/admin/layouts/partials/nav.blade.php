  <nav class="main-header navbar navbar-expand sport-navbar border-bottom-0">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home') }}" class="nav-link">مشاهده سایت</a>
      </li>
    </ul>

    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" style="color:#fff;">
          <i class="fa fa-user-circle"></i> {{ Auth::guard('admin')->user()?->name ?? Auth::user()?->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-left">
          <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
            <i class="fa fa-dashboard mr-2"></i> داشبورد
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"
             onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();">
            <i class="fa fa-sign-out mr-2"></i> خروج
          </a>
          <form id="logout-form-nav" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
      </li>
    </ul>
  </nav>
