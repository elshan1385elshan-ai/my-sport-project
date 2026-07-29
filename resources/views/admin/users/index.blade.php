@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-green"><i class="fa fa-users"></i> مدیریت کاربران</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item active">کاربران</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.users.create') }}" class="btn sport-btn-primary">
                    <i class="fa fa-plus"></i> ایجاد کاربر جدید
                </a>
            </div>

            <div class="card sport-card sport-card-green">
                <div class="card-header">
                    <span class="card-icon icon-green"><i class="fa fa-users"></i></span>
                    <h3 class="card-title">همه کاربران</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle sport-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th>نام</th>
                                    <th>ایمیل</th>
                                    <th>نقش</th>
                                    <th>تاریخ عضویت</th>
                                    <th style="width:140px;">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="fw-bold">{{ $user->id }}</td>
                                        <td class="fw-bold">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge {{ $user->role === 'admin' ? 'badge-warning' : 'badge-info' }}">
                                                {{ $user->role === 'admin' ? 'مدیر' : 'کاربر' }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at ? $user->created_at->format('Y/m/d') : '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.users.show', $user) }}" class="sport-action-btn btn-view" title="مشاهده">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user) }}" class="sport-action-btn btn-edit" title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="sport-action-btn btn-delete" title="حذف"
                                                            onclick="return confirm('آیا از حذف این کاربر اطمینان دارید؟')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($users->hasPages())
                <div class="card-footer">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
