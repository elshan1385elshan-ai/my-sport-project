  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
      <div style="direction: rtl">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
            <!-- منوی داشبورد (سایر موارد) -->
            <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>داشبوردها <i class="right fa fa-angle-left"></i></p>
              </a>
            </li>

            <!-- دکمه اصلاح شده افزودن لوازم -->
            <li class="nav-item">
              <a href="{{route('products.create')}}" class="nav-link custom-btn-hover">
                <i class="nav-icon fa fa-plus-circle"></i> <!-- پیشنهاد: استفاده از آیکون استانداردتر -->
                <p>افزودن لوازم ورزشی</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('products.index')}}" class="nav-link custom-btn-hover">
                <i class="fa fa-list nav-icon blue"></i> <!-- پیشنهاد: استفاده از آیکون استانداردتر -->
                <p>لیست لوازم </p>
              </a>
            </li>
             <!-- خروج -->
            <li class="nav-item">
              <a href="logout.html" class="nav-link text-danger custom-btn-hover">
                <i class="nav-icon fa fa-sign-out"></i>
                <p>خروج</p>
              </a>
            </li>
          </ul>
        </nav>

        <!-- /.sidebar-menu -->
      </div>
    </div>
    <!-- /.sidebar -->
  </aside>