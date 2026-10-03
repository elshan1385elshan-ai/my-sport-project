@extends('layouts.app')

@section('content')
    <main class="container my-5" id="content">
        <div class="text-center mb-5">
            <h2 class="sport-title">مجلات و مقالات</h2>
            <p class="text-muted">جدیدترین مقالات ورزشی ما را مطالعه کنید</p>
        </div>

        <div class="row g-4">
            @forelse($articles as $article)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 18px; overflow: hidden;">
                        <a href="{{ route('article.show', $article) }}">
                            <img src="{{ $article->image ? asset('storage/' . $article->image) : 'https://picsum.photos/600/340' }}"
                                class="w-100" style="height: 200px; object-fit: cover;" alt="{{ $article->title }}">
                        </a>
                        <div class="card-body d-flex flex-column">
                            @if ($article->category)
                                <span class="badge bg-primary align-self-start mb-2">{{ $article->category->name }}</span>
                            @endif
                            <a href="{{ route('article.show', $article) }}"
                                class="fw-bold text-decoration-none text-dark mb-2">
                                {{ $article->title }}
                            </a>
                            <p class="text-muted small mb-3">
                                {{ \Str::limit($article->excerpt ?: strip_tags($article->body), 110) }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="bi bi-calendar3"></i>
                                    {{ $article->published_at?->format('Y/m/d') }}</small>
                                <a href="{{ route('article.show', $article) }}" class="btn btn-sm sport-btn-primary">ادامه
                                    مطلب</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">هنوز مقاله‌ای منتشر نشده است.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    </main>
@endsection
