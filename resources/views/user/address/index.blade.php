@extends('user.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="sport-page-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-sm-6">
            <h1 class="header-icon-amber"><i class="fa fa-map-marker"></i> آدرس‌های من</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">داشبورد</a></li>
              <li class="breadcrumb-item active">آدرس‌ها</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-end mb-3">
                @if($address)
                    <a href="{{ route('addresses.edit', $address->id) }}" class="btn sport-btn-primary">
                        <i class="fa fa-edit"></i> ویرایش آدرس
                    </a>
                @else
                    <a href="{{ route('addresses.create') }}" class="btn sport-btn-primary">
                        <i class="fa fa-plus"></i> ثبت آدرس جدید
                    </a>
                @endif
            </div>

            @if($address)
                <div class="card sport-card sport-card-amber">
                    <div class="card-header">
                        <span class="card-icon icon-amber"><i class="fa fa-map-marker"></i></span>
                        <h3 class="card-title">آدرس شما</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered sport-table">
                            <tr>
                                <th style="width:150px;">استان</th>
                                <td>{{ $address->province }}</td>
                            </tr>
                            <tr>
                                <th>شهر</th>
                                <td>{{ $address->city }}</td>
                            </tr>
                            <tr>
                                <th>آدرس کامل</th>
                                <td>{{ $address->address }}</td>
                            </tr>
                            <tr>
                                <th>کد پستی</th>
                                <td>{{ $address->postal_code }}</td>
                            </tr>
                            @if($address->phone)
                            <tr>
                                <th>شماره تماس</th>
                                <td>{{ $address->phone }}</td>
                            </tr>
                            @endif
                        </table>

                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('addresses.edit', $address->id) }}" class="btn sport-btn-primary">
                                <i class="fa fa-edit"></i> ویرایش
                            </a>
                            <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('آیا از حذف آدرس اطمینان دارید؟')">
                                    <i class="fa fa-trash"></i> حذف
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="card sport-card sport-card-amber">
                    <div class="card-body text-center py-5">
                        <i class="fa fa-map-marker fa-3x text-muted mb-3"></i>
                        <p class="text-muted">هنوز آدرسی ثبت نکرده‌اید.</p>
                        <a href="{{ route('addresses.create') }}" class="btn sport-btn-primary">
                            <i class="fa fa-plus"></i> ثبت آدرس جدید
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
