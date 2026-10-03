@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="sport-page-header">
            <div class="container-fluid">
                <div class="row mb-0">
                    <div class="col-sm-6">
                        <h1 class="header-icon-purple"><i class="fa fa-newspaper-o"></i> همه مقالات</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                            <li class="breadcrumb-item active">مقالات</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('admin.articles.create') }}" class="btn sport-btn-primary">
                        <i class="fa fa-plus"></i> مقاله جدید
                    </a>
                </div>

                <div class="card sport-card sport-card-purple">
                    <div class="card-header">
                        <span class="card-icon icon-purple"><i class="fa fa-newspaper-o"></i></span>
                        <h3 class="card-title">لیست مقالات</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle sport-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>تصویر</th>
                                        <th>عنوان</th>
                                        <th>دسته‌بندی</th>
                                        <th>وضعیت</th>
                                        <th>تاریخ انتشار</th>
                                        <th style="width: 160px;">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($articles as $index => $article)
                                        <tr>
                                            <td class="fw-bold">{{ $articles->firstItem() + $index }}</td>
                                            <td>
                                                @if ($article->image)
                                                    <img src="{{ asset('storage/' . $article->image) }}"
                                                        alt="{{ $article->title }}" class="sport-thumb">
                                                @else
                                                    <span class="badge bg-secondary">بدون تصویر</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $article->title }}</td>
                                            <td>{{ $article->category?->name ?? '—' }}</td>
                                            <td>
                                                @if ($article->is_published)
                                                    <span class="badge bg-success">منتشر شده</span>
                                                @else
                                                    <span class="badge bg-warning">پیش نویس</span>
                                                @endif
                                            </td>
                                            <td>{{ $article->published_at ? $article->published_at->format('Y/m/d') : '—' }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('admin.articles.edit', $article->id) }}"
                                                        class="sport-action-btn btn-edit" title="ویرایش">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="sport-action-btn btn-delete"
                                                        data-id="{{ $article->id }}" title="حذف">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                                <form id="delete-form-{{ $article->id }}"
                                                    action="{{ route('admin.articles.destroy', $article->id) }}"
                                                    method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">مقاله‌ای وجود ندارد.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($articles->hasPages())
                        <div class="card-footer">
                            {{ $articles->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-delete').on('click', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'آیا از حذف این مقاله اطمینان دارید؟',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'بله، حذف کن',
                    cancelButtonText: 'لغو'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form-' + id).submit();
                    }
                });
            });
        });
    </script>
@endpush
