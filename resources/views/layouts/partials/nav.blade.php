<nav class="navbar navbar-expand-lg navbar-dark shadow-lg" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">
            <i class="bi bi-trophy-fill text-warning"></i> خانه قهرمانان
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">
                        <i class="bi bi-house-fill"></i> صفحه اصلی
                    </a>
                </li>

                @if(isset($navCategories) && $navCategories->isNotEmpty())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-grid-fill"></i> دسته‌بندی‌ها
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark shadow border-0" style="background: #1a1a2e;">
                        @foreach($navCategories as $cat)
                            @if($cat->children->isNotEmpty())
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="{{ route('category.show', $cat) }}">
                                    {{ $cat->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark shadow border-0" style="background: #16213e;">
                                    @foreach($cat->children as $child)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('category.show', $child) }}">
                                                {{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            @else
                            <li>
                                <a class="dropdown-item" href="{{ route('category.show', $cat) }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                @endif
            </ul>

            <form class="d-flex mx-lg-3 my-2 my-lg-0" action="{{ route('search.live') }}" method="GET">
                <div class="input-group" style="width: 300px;">
                    <input type="text"
                           class="form-control border-0 bg-white bg-opacity-10 text-white placeholder-white"
                           name="q"
                           placeholder="جستجو کنید..."
                           aria-label="جستجو"
                           style="backdrop-filter: blur(4px);">
                    <button class="btn btn-danger" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <div class="d-flex align-items-center gap-2">
                @auth
                    <a href="{{ route('cart.show') }}" class="btn btn-outline-light position-relative">
                        <i class="bi bi-cart3"></i>
                        @php $cartCount = array_sum(session()->get('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark shadow border-0" style="background: #1a1a2e;">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> خروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('cart.show') }}" class="btn btn-outline-light position-relative">
                        <i class="bi bi-cart3"></i>
                        @php $cartCount = array_sum(session()->get('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-in-right"></i> ورود
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-danger">
                        <i class="bi bi-person-plus"></i> ثبت نام
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    .navbar .form-control::placeholder { color: rgba(255,255,255,0.6) !important; }
    .navbar .form-control:focus { background: rgba(255,255,255,0.15) !important; color: #fff !important; box-shadow: none; }
    .dropdown-submenu { position: relative; }
    .dropdown-submenu > .dropdown-menu {
        top: 0; right: 100%; margin-top: 0; border-radius: 0.5rem;
    }
    .dropdown-submenu:hover > .dropdown-menu { display: block; }
    .dropdown-item { transition: background 0.2s; border-radius: 0.25rem; }
    .dropdown-item:hover { background: rgba(255,255,255,0.1) !important; }
    .navbar .nav-link { transition: color 0.2s; }
    .navbar .nav-link:hover { color: #ffc107 !important; }
</style>
