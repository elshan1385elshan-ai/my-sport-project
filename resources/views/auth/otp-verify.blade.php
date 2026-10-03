@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5 mb-5">
            <div class="col-md-8 col-lg-5">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden"
                    style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                    <div class="card-header bg-transparent border-0 pt-5 pb-3 text-center"
                        style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                            style="width: 72px; height: 72px; background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 8px 24px rgba(239,68,68,0.4);">
                            <i class="bi bi-shield-lock-fill text-white" style="font-size: 1.8rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: #ac2727;">تأیید شماره تلفن</h3>
                        <p class="fw-bold text-white mb-0">کد پیامکی را وارد کنید</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        @if (session('status'))
                            <div class="alert alert-success border-0 rounded-3 mb-4">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 rounded-3 mb-4"
                                style="background: linear-gradient(135deg, #fef2f2, #fee2e2);">
                                <ul class="mb-0 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <p class="text-center text-muted mb-4">
                            کد تأیید به شماره
                            <span class="fw-bold text-dark" dir="ltr">{{ $phone }}</span>
                            ارسال شد.
                        </p>

                        <form action="{{ route('otp.verify.store') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-medium text-dark">کد تأیید</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0"><i
                                            class="bi bi-123 text-muted"></i></span>
                                    <input type="text" dir="ltr" inputmode="numeric" maxlength="6"
                                        pattern="[0-9]{6}"
                                        class="form-control border-start-0 rounded-end-4 text-center fs-4 fw-bold"
                                        name="code" value="{{ old('code') }}" placeholder="- - - - - -" required
                                        style="background: #f8fafc; border-color: #e2e8f0; letter-spacing: 0.5em;">
                                </div>
                                @error('code')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-lg w-100 rounded-3 fw-semibold mb-4"
                                style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none; box-shadow: 0 4px 16px rgba(239,68,68,0.3);">
                                <i class="bi bi-check-circle me-2"></i> تأیید و ورود
                            </button>
                        </form>

                        <div class="text-center">
                            <form action="{{ route('otp.resend') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="btn btn-link text-danger text-decoration-none fw-medium small p-0">
                                    <i class="bi bi-arrow-clockwise me-1"></i> ارسال مجدد کد
                                </button>
                            </form>
                            <a href="{{ route('home') }}" class="text-muted small text-decoration-none d-block mt-2"><i
                                    class="bi bi-arrow-right me-1"></i>بازگشت به صفحه اصلی</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
