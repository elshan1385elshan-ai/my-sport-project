@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="sport-page-header">
            <div class="container-fluid">
                <div class="row mb-0">
                    <div class="col-sm-6">
                        <h1 class="header-icon-purple"><i class="fa fa-tags"></i> دسته بندی مقالات</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">مقالات</a></li>
                            <li class="breadcrumb-item active">دسته‌بندی‌ها</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card sport-card sport-card-purple">
                            <div class="card-header">
                                <span class="card-icon icon-purple"><i class="fa fa-plus"></i></span>
                                <h3 class="card-title">افزودن دسته‌بندی جدید</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.articles.categories.store') }}" method="POST">
                                    @csrf
                                    <div class="sport-form-group">
                                        <label>نام دسته‌بندی <span class="text-danger">*</span></label>
                                        <div class="sport-input-wrap">
                                            <i class="fa fa-tag input-icon"></i>
                                            <input type="text" name="name" class="form-control sport-form-control"
                                                value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn sport-btn-primary">
                                        <i class="fa fa-save"></i> ثبت
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card sport-card sport-card-purple">
                            <div class="card-header">
                                <span class="card-icon icon-purple"><i class="fa fa-tags"></i></span>
                                <h3 class="card-title">لیست دسته‌بندی‌ها</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle sport-table mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 60px;">#</th>
                                                <th>نام</th>
                                                <th>تعداد مقاله</th>
                                                <th style="width: 160px;">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($categories as $category)
                                                <tr>
                                                    <td class="fw-bold">{{ $categories->firstItem() + $loop->index }}</td>
                                                    <td class="fw-bold">{{ $category->name }}</td>
                                                    <td>{{ $category->articles_count }}</td>
                                                    <td>
                                                        <div class="d-flex gap-1 align-items-center">
                                                            <button type="button" class="sport-action-btn btn-edit"
                                                                data-toggle="modal"
                                                                data-target="#edit-category-modal-{{ $category->id }}"
                                                                title="ویرایش">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="sport-action-btn btn-delete"
                                                                data-id="{{ $category->id }}" title="حذف">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                        <form id="delete-category-form-{{ $category->id }}"
                                                            action="{{ route('admin.articles.categories.destroy', $category->id) }}"
                                                            method="POST" class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <!-- مودال ویرایش -->
                                                        <div class="modal fade"
                                                            id="edit-category-modal-{{ $category->id }}" tabindex="-1"
                                                            role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">ویرایش دسته‌بندی</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal"><span>&times;</span></button>
                                                                    </div>
                                                                    <form
                                                                        action="{{ route('admin.articles.categories.update', $category->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-body">
                                                                            <div class="sport-form-group">
                                                                                <label>نام دسته‌بندی</label>
                                                                                <input type="text" name="name"
                                                                                    class="form-control sport-form-control"
                                                                                    value="{{ $category->name }}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn sport-btn-secondary"
                                                                                data-dismiss="modal">لغو</button>
                                                                            <button type="submit"
                                                                                class="btn sport-btn-primary">ذخیره</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-4">دسته‌بندی‌ای وجود ندارد.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if ($categories->hasPages())
                                <div class="card-footer">
                                    {{ $categories->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
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
                    title: 'آیا از حذف این دسته‌بندی اطمینان دارید؟',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'بله، حذف کن',
                    cancelButtonText: 'لغو'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-category-form-' + id).submit();
                    }
                });
            });
        });
    </script>
@endpush
