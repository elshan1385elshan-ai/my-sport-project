<nav class="navbar navbar-expand-lg navbar-dark shadow-lg" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">
            @if(($appSettings['public_icon_type'] ?? 'font') === 'custom' && !empty($appSettings['public_icon_custom'] ?? ''))
                <img src="{{ Storage::url($appSettings['public_icon_custom']) }}" alt="icon" style="height: 28px; width: auto;" class="ml-1">
            @else
                <i class="bi bi-{{ $appSettings['public_icon'] ?? 'trophy-fill' }} text-warning"></i>
            @endif
            {{ $appSettings['app_name'] ?? 'خانه قهرمانان' }}
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">

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

            <form class="d-flex mx-lg-3 my-2 my-lg-0" action="{{ route('search.live') }}" method="GET" style="max-width: 460px; flex: 1 1 340px;">
                <div class="sport-search-box d-flex align-items-stretch rounded-pill overflow-hidden shadow w-100">
                    <input type="text"
                           class="sport-search-input border-0"
                           name="q"
                           placeholder="جستجوی کالای ورزشی..."
                           aria-label="جستجو">
                    <button class="sport-search-btn border-0" type="submit" title="جستجو">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <div class="d-flex align-items-center gap-2">
                @auth('admin')
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-shield-lock-fill"></i> {{ Auth::guard('admin')->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark shadow border-0" style="background: #1a1a2e;">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> پنل مدیریت
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> خروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @elseauth('web')
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
                            <i class="bi bi-person-circle"></i> {{ auth('web')->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark shadow border-0" style="background: #1a1a2e;">
                            <li>
                                <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> داشبورد
                                </a>
                            </li>
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

                    <a href="{{ route('login') }}" class="btn btn-danger">
                        <i class="bi bi-dashboard"></i> ورود
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    .navbar .form-control::placeholder { color: rgba(255,255,255,0.6) !important; }
    .navbar .form-control:focus { background: rgba(255,255,255,0.15) !important; color: #fff !important; box-shadow: none; }

    /* Sport search bar (Taaghche-inspired) */
    .sport-search-box {
        background: #fff;
        border-radius: 50px;
        min-width: 300px;
        height: 48px;
        border: 2px solid transparent;
        transition: border-color .2s ease, box-shadow .2s ease;
    }
    .sport-search-box:focus-within {
        border-color: #ffc107;
        box-shadow: 0 0 0 4px rgba(255,193,7,0.18), 0 6px 18px rgba(0,0,0,0.18);
    }
    .sport-search-input {
        border: none !important;
        flex: 1;
        padding: 0 22px;
        font-size: 1rem;
        outline: none;
        min-width: 0;
        box-shadow: none !important;
        height: 100%;
    }
    .sport-search-input::placeholder { color: #9aa0ac; }
    .sport-search-btn {
        background: linear-gradient(90deg, #e94560, #ff6b6b);
        color: #fff;
        width: 56px;
        font-size: 1.15rem;
        transition: filter .2s ease;
        border-radius: 0 50px 50px 0 !important;
    }
    .sport-search-btn:hover { filter: brightness(1.08); }

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
