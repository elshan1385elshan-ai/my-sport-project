
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <!-- برند -->
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">خانه قهرمانان</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">صفحه اصلی</a></li>
                <li class="nav-item"><a class="nav-link" href="#">کالاهای ورزشی</a></li>
                <li class="nav-item"><a class="nav-link" href="#">تماس با ما</a></li>
            </ul>

            <!-- بخش جستجو -->
            <form class="d-flex mx-lg-4 my-2 my-lg-0" action="{{ route('search.live') }}" method="GET">
                <div class="input-group" style="width: 320px;">
                    <input type="text" 
                           class="form-control" 
                           name="q" 
                           placeholder="جستجوی محصول، برند یا قهرمان..." 
                           aria-label="جستجو">
                    <button class="btn btn-danger" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- دکمه‌های ورود و ثبت‌نام -->
            <div class="d-flex">
                <a href="{{ route('login') }}" class="btn btn-outline-light ms-2">ورود</a>
                <a href="{{ route('register') }}" class="btn btn-danger ms-2">ثبت نام</a>
            </div>
        </div>
    </div>
</nav>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<!-- Hero Section -->
<header class="hero-section position-relative">
    <div class="hero-background"></div>
    
    <div class="container position-relative z-3 h-100 d-flex align-items-center">
        <div class="row justify-content-center text-center w-100">
            <div class="col-lg-10">
                <h1 class="display-3 fw-bold text-white mb-4">
                    به فروشگاه خانه قهرمانان خوش آمدید
                </h1>
                <a href="#content" class="btn btn-danger btn-lg px-5 py-3">
                    مشاهده همه کالاها
                </a>
            </div>
        </div>
    </div>
</header>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const resultsContainer = document.getElementById('search-results');

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();

        if (query.length < 2) {
            resultsContainer.style.display = 'none';
            return;
        }

        fetch(`/search/live?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                resultsContainer.innerHTML = '';

                if (data.length === 0) {
                    resultsContainer.innerHTML = `<div class="p-3 text-muted">هیچ محصولی یافت نشد</div>`;
                } else {
                    data.forEach(product => {
                        const item = document.createElement('a');
                        item.href = `/products/${product.id}`;
                        item.className = 'list-group-item list-group-item-action d-flex align-items-center';
                        item.innerHTML = `
                            <img src="${product.image ? '/storage/' + product.image : '/images/default.jpg'}" 
                                 alt="${product.name}" 
                                 style="width: 50px; height: 50px; object-fit: cover;" class="me-3 rounded">
                            <div>
                                <strong>${product.name}</strong><br>
                                <small class="text-muted">${product.brand || ''} - ${product.price.toLocaleString('fa-IR')} تومان</small>
                            </div>
                        `;
                        resultsContainer.appendChild(item);
                    });
                }
                resultsContainer.style.display = 'block';
            })
            .catch(error => console.error('Error:', error));
    });

    // بستن نتایج وقتی خارج از باکس کلیک شد
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target)) {
            resultsContainer.style.display = 'none';
        }
    });
});
</script>