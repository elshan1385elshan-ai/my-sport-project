@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="sport-page-header">
            <div class="container-fluid">
                <div class="row mb-0">
                    <div class="col-sm-6">
                        <h1 class="header-icon-purple"><i class="fa fa-file-text-o"></i> پیش نویس‌ها</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">مقالات</a></li>
                            <li class="breadcrumb-item active">پیش نویس‌ها</li>
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
                        <span class="card-icon icon-purple"><i class="fa fa-file-text-o"></i></span>
                        <h3 class="card-title">لیست پیش نویس‌ها</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle sport-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>عنوان</th>
                                        <th>دسته‌بندی</th>
                                        <th>تاریخ ایجاد</th>
                                        <th style="width: 160px;">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($articles as $index => $article)
                                        <tr>
                                            <td class="fw-bold">{{ $articles->firstItem() + $index }}</td>
                                            <td class="fw-bold">{{ $article->title }}</td>
                                            <td>{{ $article->category?->name ?? '—' }}</td>
                                            <td>{{ $article->created_at->format('Y/m/d') }}</td>
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
                                            <td colspan="5" class="text-center py-4">پیش نویسی وجود ندارد.</td>
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
                    title: 'آیا از حذف این پیش نویس اطمینان دارید؟',
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
