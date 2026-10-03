@extends('layouts.app')

@section('content')
    <main class="container my-5" id="content">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 18px; overflow: hidden;">
                    @if ($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" class="w-100"
                            style="max-height: 420px; object-fit: cover;" alt="{{ $article->title }}">
                    @endif
                    <div class="card-body p-4">
                        @if ($article->category)
                            <span class="badge bg-primary mb-2">{{ $article->category->name }}</span>
                        @endif
                        <h2 class="fw-bold mb-3">{{ $article->title }}</h2>
                        <div class="text-muted small mb-4">
                            <i class="bi bi-calendar3"></i> {{ $article->published_at?->format('Y/m/d') }}
                        </div>
                        @if ($article->excerpt)
                            <p class="lead text-muted">{{ $article->excerpt }}</p>
                            <hr>
                        @endif
                        <div class="article-body" style="line-height: 2;">
                            {!! nl2br(e($article->body)) !!}
                        </div>
                    </div>
                </div>

                @if ($related->count())
                    <div class="text-center mt-5 mb-4">
                        <h2 class="sport-title">مقالات مرتبط</h2>
                    </div>
                    <div class="row g-4">
                        @foreach ($related as $item)
                            <div class="col-md-3">
                                <a href="{{ route('article.show', $item) }}" class="text-decoration-none">
                                    <div class="card border-0 shadow-sm h-100"
                                        style="border-radius: 16px; overflow: hidden;">
                                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://picsum.photos/400/220' }}"
                                            class="w-100" style="height: 120px; object-fit: cover;"
                                            alt="{{ $item->title }}">
                                        <div class="card-body p-2">
                                            <p class="small fw-bold text-dark mb-0">{{ \Str::limit($item->title, 50) }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
