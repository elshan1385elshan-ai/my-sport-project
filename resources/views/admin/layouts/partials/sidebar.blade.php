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
            <li class="nav-item has-treeview">  
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-shopping-bag"></i>
                <p>
                  مدیریت کالاها 
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('products.create')}}" class="nav-link">
                    <i class="fa fa-plus nav-icon plus"></i>
                    <p>ایجاد کالا </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('products.index')}}" class="nav-link">
                    <i class="fa fa-list nav-icon lists-color"></i>
                    <p> کالاها </p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview">  
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-gear"></i>
                <p>
                  مدیریت دسته بندی ها 
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('categories.create')}}" class="nav-link">
                    <i class="fa fa-plus nav-icon plus"></i>
                    <p>ایجاد دسته بندی جدید </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('categories.index')}}" class="nav-link">
                    <i class="fa fa-list lists-color nav-icon "></i>
                    <p> دسته بندی ها </p>
                  </a>
                </li>
              </ul>
            </li>
             <!-- خروج -->
            <li class="nav-item">
                <a href="#" 
                  class="nav-link custom-btn-hover"
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

        <!-- /.sidebar-menu -->
      </div>
    </div>
    <!-- /.sidebar -->
  </aside>