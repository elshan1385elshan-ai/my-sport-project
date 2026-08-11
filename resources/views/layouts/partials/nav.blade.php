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
                    <a class="nav-link dropdown-toggle sport-category-nav-btn" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-grid-fill"></i> دسته‌بندی‌ها
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark shadow border-0 sport-dropdown-menu" style="background: #1a1a2e;">
                        @foreach($navCategories as $cat)
                            @if($cat->children->isNotEmpty())
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle sport-dropdown-item" href="{{ route('category.show', $cat) }}">
                                    {{ $cat->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark shadow border-0 sport-dropdown-menu" style="background: #16213e;">
                                    @foreach($cat->children as $child)
                                        <li>
                                            <a class="dropdown-item sport-dropdown-item" href="{{ route('category.show', $child) }}">
                                                {{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            @else
                            <li>
                                <a class="dropdown-item sport-dropdown-item" href="{{ route('category.show', $cat) }}">
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
                        <button class="sport-user-btn dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-shield-lock-fill"></i> {{ Auth::guard('admin')->user()->name }}
                        </button>
                        <ul class="dropdown-menu sport-dropdown-menu shadow border-0" style="background: #1a1a2e;">
                            <li>
                                <a class="dropdown-item sport-dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> پنل مدیریت
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item sport-dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> خروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @elseauth('web')
                    <a href="{{ route('cart.show') }}" class="position-relative sport-cart-btn" style="color: #fff; text-decoration: none; display: inline-flex; align-items: center;">
                        <i class="bi bi-cart3"></i>
                        @php $cartCount = array_sum(session()->get('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <div class="dropdown">
                        <button class="sport-user-btn dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth('web')->user()->name }}
                        </button>
                        <ul class="dropdown-menu sport-dropdown-menu shadow border-0" style="background: #1a1a2e;">
                            <li>
                                <a class="dropdown-item sport-dropdown-item" href="{{ route('user.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> داشبورد
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item sport-dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> خروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('cart.show') }}" class="position-relative sport-cart-btn" style="color: #fff; text-decoration: none; display: inline-flex; align-items: center;">
                        <i class="bi bi-cart3"></i>
                        @php $cartCount = array_sum(session()->get('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('login') }}" class="sport-login-btn" style="color: #fff; text-decoration: none; display: inline-flex; align-items: center;">
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

    /* Sport search bar (matches nav buttons) */
    .sport-search-box {
        background: linear-gradient(135deg, rgba(233,69,96,0.15), rgba(255,107,107,0.15));
        border-radius: 12px;
        min-width: 300px;
        height: 48px;
        border: 2px solid rgba(233,69,96,0.3);
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        backdrop-filter: blur(10px);
        overflow: hidden;
    }
    .sport-search-box:focus-within {
        background: linear-gradient(135deg, rgba(233,69,96,0.25), rgba(255,107,107,0.25));
        border-color: rgba(233,69,96,0.6);
        box-shadow: 0 8px 25px rgba(233,69,96,0.3), 0 0 0 1px rgba(233,69,96,0.1);
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
        background: transparent !important;
        color: #fff !important;
    }
    .sport-search-input::placeholder { color: rgba(255,255,255,0.6); }
    .sport-search-input:focus { background: transparent !important; color: #fff !important; box-shadow: none !important; }
    .sport-search-btn {
        background: linear-gradient(90deg, #e94560, #ff6b6b);
        color: #fff;
        width: 56px;
        font-size: 1.15rem;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        border-radius: 0 12px 12px 0 !important;
        border: none !important;
    }
    .sport-search-btn:hover {
        filter: brightness(1.08);
        transform: scale(1.05);
    }
    .sport-search-btn i {
        transition: transform 0.3s ease;
    }
    .sport-search-btn:hover i {
        transform: rotate(360deg);
    }

    .dropdown-submenu { position: relative; }
    .dropdown-submenu > .dropdown-menu {
        top: 0; right: 100%; margin-top: 0; border-radius: 0.5rem;
    }
    .dropdown-submenu:hover > .dropdown-menu { display: block; }
    .dropdown-item { transition: background 0.2s; border-radius: 0.25rem; }
    .dropdown-item:hover { background: rgba(255,255,255,0.1) !important; }
    .navbar .nav-link { transition: color 0.2s; }
    .navbar .nav-link:hover { color: #ffc107 !important; }

    /* Enhanced category navigation button */
    .sport-category-nav-btn {
        position: relative;
        padding: 0.5rem 1.2rem !important;
        border-radius: 12px !important;
        background: linear-gradient(135deg, rgba(233,69,96,0.15), rgba(255,107,107,0.15)) !important;
        border: 2px solid rgba(233,69,96,0.3) !important;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
        backdrop-filter: blur(10px) !important;
        overflow: hidden !important;
    }

    .sport-category-nav-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .sport-category-nav-btn:hover::before {
        left: 100%;
    }

    .sport-category-nav-btn:hover {
        background: linear-gradient(135deg, rgba(233,69,96,0.25), rgba(255,107,107,0.25)) !important;
        border-color: rgba(233,69,96,0.6) !important;
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 25px rgba(233,69,96,0.3), 0 0 0 1px rgba(233,69,96,0.1) !important;
    }

    .sport-category-nav-btn i {
        position: relative;
        z-index: 2;
        transition: transform 0.3s ease;
    }

    .sport-category-nav-btn:hover i {
        transform: rotate(180deg);
    }

    .sport-category-nav-btn .dropdown-toggle::after {
        position: relative;
        z-index: 2;
    }

    /* Enhanced dropdown menus */
    .sport-dropdown-menu {
        border-radius: 16px !important;
        border: 2px solid rgba(233,69,96,0.2) !important;
        backdrop-filter: blur(15px) !important;
        animation: dropdownFadeIn 0.3s ease !important;
    }

    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Enhanced dropdown items */
    .sport-dropdown-item {
        position: relative;
        padding: 0.75rem 1.25rem !important;
        border-radius: 10px !important;
        margin: 4px 8px !important;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
        overflow: hidden !important;
        color: #fff !important;
    }

    .sport-dropdown-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(233,69,96,0.1), transparent);
        transition: left 0.4s ease;
    }

    .sport-dropdown-item:hover::before {
        left: 100%;
    }

    .sport-dropdown-item:hover {
        background: linear-gradient(135deg, rgba(233,69,96,0.2), rgba(255,107,107,0.15)) !important;
        transform: translateX(-5px);
        box-shadow: 0 4px 15px rgba(233,69,96,0.2) !important;
    }

    /* Enhanced cart button */
    .sport-cart-btn {
        position: relative;
        padding: 0.5rem 1.2rem !important;
        min-width: 48px;
        min-height: 48px;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        vertical-align: middle;
        border-radius: 12px !important;
        background: linear-gradient(135deg, rgba(233,69,96,0.15), rgba(255,107,107,0.15)) !important;
        border: 2px solid rgba(233,69,96,0.3) !important;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
        backdrop-filter: blur(10px) !important;
        overflow: visible !important;
    }

    .sport-cart-btn .badge {
        position: relative;
        z-index: 3;
    }

    .sport-cart-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .sport-cart-btn:hover::before {
        left: 100%;
    }

    .sport-cart-btn:hover {
        background: linear-gradient(135deg, rgba(233,69,96,0.25), rgba(255,107,107,0.25)) !important;
        border-color: rgba(233,69,96,0.6) !important;
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 25px rgba(233,69,96,0.3), 0 0 0 1px rgba(233,69,96,0.1) !important;
    }

    .sport-cart-btn i {
        position: relative;
        z-index: 2;
        transition: transform 0.3s ease;
    }

    .sport-cart-btn:hover i {
        transform: rotate(360deg);
    }

    /* Enhanced login button */
    .sport-login-btn {
        position: relative;
        padding: 0.5rem 1.5rem !important;
        min-width: 48px;
        min-height: 48px;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        vertical-align: middle;
        border-radius: 12px !important;
        background: linear-gradient(135deg, #e94560, #ff6b6b) !important;
        border: 2px solid rgba(233,69,96,0.5) !important;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
        backdrop-filter: blur(10px) !important;
        overflow: hidden !important;
        box-shadow: 0 4px 15px rgba(233,69,96,0.3) !important;
    }

    .sport-login-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .sport-login-btn:hover::before {
        left: 100%;
    }

    .sport-login-btn:hover {
        background: linear-gradient(135deg, #ff6b6b, #e94560) !important;
        border-color: rgba(255,107,107,0.7) !important;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 12px 35px rgba(233,69,96,0.4), 0 0 0 1px rgba(233,69,96,0.2) !important;
    }

    .sport-login-btn i {
        position: relative;
        z-index: 2;
        transition: transform 0.3s ease;
    }

    .sport-login-btn:hover i {
        transform: rotate(-15deg) scale(1.1);
    }

    /* Enhanced user button (matches cart button) */
    .sport-user-btn {
        position: relative;
        padding: 0.5rem 1.2rem !important;
        min-width: 48px;
        min-height: 48px;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        vertical-align: middle;
        border-radius: 12px !important;
        background: linear-gradient(135deg, rgba(233,69,96,0.15), rgba(255,107,107,0.15)) !important;
        border: 2px solid rgba(233,69,96,0.3) !important;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
        backdrop-filter: blur(10px) !important;
        overflow: hidden !important;
        color: #fff !important;
    }

    .sport-user-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .sport-user-btn:hover::before {
        left: 100%;
    }

    .sport-user-btn:hover {
        background: linear-gradient(135deg, rgba(233,69,96,0.25), rgba(255,107,107,0.25)) !important;
        border-color: rgba(233,69,96,0.6) !important;
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 25px rgba(233,69,96,0.3), 0 0 0 1px rgba(233,69,96,0.1) !important;
        color: #fff !important;
    }

    .sport-user-btn i {
        position: relative;
        z-index: 2;
        transition: transform 0.3s ease;
    }

    .sport-user-btn:hover i {
        transform: rotate(180deg);
    }
</style>
