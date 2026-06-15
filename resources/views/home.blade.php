@extends('layouts.app')
@section('content')
<main class="container my-5" id="content">
        <h2 class="text-center mb-4">جدیدترین کالاهای ورزشی</h2>
        <div class="row g-4">
            <!-- کارت نمونه -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://picsum.photos/400/200" class="card-img-top" alt="تصویر">
                    <div class="card-body">
                        <h5 class="card-title">رکورد جدید</h5>
                        <p class="card-text">تحلیل کوتاهی از عملکرد اخیر بازیکنان برجسته در لیگ‌های معتبر.</p>
                        <a href="#" class="btn btn-outline-danger btn-sm">بیشتر بخوانید</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection