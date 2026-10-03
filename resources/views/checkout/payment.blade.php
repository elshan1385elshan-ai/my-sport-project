@extends('layouts.app')

@section('content')
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                @if (session('info'))
                    <div class="alert alert-info border-0 rounded-4 shadow-sm">{{ session('info') }}</div>
                @endif

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-transparent border-0 pt-4 pb-3 text-center"
                        style="background: linear-gradient(135deg, #0f3460 0%, #1a1a2e 100%);">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                            style="width: 64px; height: 64px; background: linear-gradient(135deg, #e94560, #ff6b6b); box-shadow: 0 8px 20px rgba(233,69,96,0.4);">
                            <i class="bi bi-credit-card-2-front text-white" style="font-size: 1.6rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-1 text-white">انتخاب شیوه پرداخت</h3>
                        <p class="text-white-50 small mb-0">یک روش پرداخت را برای تکمیل سفارش خود انتخاب کنید</p>
                    </div>

                    <div class="card-body p-4 p-md-5">

                        {{-- خلاصه مبلغ --}}
                        <div class="d-flex justify-content-between align-items-center rounded-3 p-3 mb-4"
                            style="background: rgba(233,69,96,0.06); border: 1px dashed rgba(233,69,96,0.3);">
                            <span class="fw-bold">مبلغ قابل پرداخت</span>
                            <span class="fw-bold fs-5 text-danger">{{ number_format(max(0, $total)) }} تومان</span>
                        </div>

                        <form action="{{ route('checkout.complete') }}" method="POST" id="paymentForm">
                            @csrf

                            <div class="row g-3">
                                {{-- پرداخت آنلاین --}}
                                <div class="col-md-6">
                                    <input type="radio" name="payment_method" value="online" id="payOnline" class="d-none"
                                        required>
                                    <label for="payOnline" class="sport-payment-option d-block h-100 p-4 text-center"
                                        style="cursor: pointer;">
                                        <div class="sport-payment-icon mb-3">
                                            <i class="bi bi-globe2"></i>
                                        </div>
                                        <h5 class="fw-bold mb-1">پرداخت آنلاین</h5>
                                        <small class="text-muted">پرداخت امن از طریق درگاه بانکی</small>
                                        <div class="sport-payment-check mt-3">
                                            <i class="bi bi-check-lg"></i>
                                        </div>
                                    </label>
                                </div>

                                {{-- پرداخت حضوری --}}
                                <div class="col-md-6">
                                    <input type="radio" name="payment_method" value="in_person" id="payInPerson"
                                        class="d-none" required>
                                    <label for="payInPerson" class="sport-payment-option d-block h-100 p-4 text-center"
                                        style="cursor: pointer;">
                                        <div class="sport-payment-icon mb-3">
                                            <i class="bi bi-shop"></i>
                                        </div>
                                        <h5 class="fw-bold mb-1">پرداخت حضوری</h5>
                                        <small class="text-muted">پرداخت هنگام تحویل حضوری کالا</small>
                                        <div class="sport-payment-check mt-3">
                                            <i class="bi bi-check-lg"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            @error('payment_method')
                                <small class="text-danger d-block mt-3">{{ $message }}</small>
                            @enderror

                            {{-- گزینه‌های مقصد تحویل (فقط برای پرداخت حضوری) --}}
                            <div id="deliveryOptions" class="mt-4" style="display:none;">
                                <div class="p-3 rounded-3" style="background: rgba(15,52,96,0.04); border: 1px solid rgba(15,52,96,0.12);">
                                    <h6 class="fw-bold mb-3"><i class="bi bi-geo me-1 text-danger"></i> مقصد تحویل کالا</h6>

                                    <div class="row g-2">
                                        {{-- گزینه ۱: ارسال به آدرس ثبت‌شده --}}
                                        @if($hasCity ?? false)
                                            <div class="col-12">
                                                <input type="radio" name="delivery_choice" value="saved" id="useSaved" class="d-none">
                                                <label for="useSaved" class="sport-delivery-option d-flex align-items-center gap-3 p-3">
                                                    <div class="sport-delivery-icon flex-shrink-0"><i class="bi bi-house-door-fill"></i></div>
                                                    <div class="flex-grow-1">
                                                        <div class="fw-bold">آیا از روی آدرسی که وارد کرده‌اید کالا به آنجا ارسال شود؟</div>
                                                        <small class="text-muted d-block mt-1">
                                                            <i class="bi bi-geo-alt-fill me-1"></i>{{ $address->province }} / {{ $address->city }} — {{ $address->address }}
                                                        </small>
                                                    </div>
                                                    <div class="sport-delivery-check flex-shrink-0"><i class="bi bi-check-lg"></i></div>
                                                </label>
                                            </div>
                                        @endif

                                        {{-- گزینه ۲: مقصد جدید با نقشه --}}
                                        <div class="col-12">
                                            <input type="radio" name="delivery_choice" value="custom" id="useCustom" class="d-none">
                                            <label for="useCustom" class="sport-delivery-option d-flex align-items-center gap-3 p-3">
                                                <div class="sport-delivery-icon flex-shrink-0"><i class="bi bi-map-fill"></i></div>
                                                <div class="flex-grow-1">
                                                    <div class="fw-bold">و یا می‌خواهید کالا به جای دیگری ارسال شود؟</div>
                                                    <small class="text-muted d-block mt-1">مقصد دلخواه خود را روی نقشه انتخاب کنید</small>
                                                </div>
                                                <div class="sport-delivery-check flex-shrink-0"><i class="bi bi-check-lg"></i></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- نقشه — فقط با انتخاب گزینه دوم نمایش داده می‌شود --}}
                                <div id="mapSection" class="mt-3" style="display:none;">
                                    <div class="rounded-3 p-3 mb-3" style="background: rgba(15,52,96,0.05); border: 1px dashed rgba(15,52,96,0.25);">
                                        @if($hasCity ?? false)
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                            <span class="fw-bold">شهر شما:</span>
                                            {{ $mapProvince }} / {{ $mapCity }}
                                        @else
                                            <i class="bi bi-geo-alt-fill text-warning me-1"></i>
                                            <span class="fw-bold">شهر ثبت نشده — نقشه پیش‌فرض: تهران</span>
                                        @endif
                                        <small class="text-muted d-block mt-1">مقصد کالا روی نقشه مشخص کنید (روی نقشه کلیک کنید)</small>
                                    </div>
                                    <div id="cityMap" style="height: 340px; border-radius: 16px;"></div>
                                    <input type="hidden" name="delivery_lat" id="deliveryLat">
                                    <input type="hidden" name="delivery_lng" id="deliveryLng">
                                </div>
                            </div>

                            <button type="submit"
                                class="btn sport-btn-primary w-100 mt-4 py-3 fw-bold sport-checkout-complete-btn" disabled
                                id="completeBtn">
                                <i class="bi bi-check-circle me-2"></i> تکمیل فرآیند خرید
                            </button>
                        </form>

                        <a href="{{ route('cart.show') }}" class="btn sport-btn-outline w-100 mt-2">
                            <i class="bi bi-arrow-right"></i> بازگشت به سبد خرید
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            var completeBtn = document.getElementById('completeBtn');
            var options = document.querySelectorAll('input[name="payment_method"]');

            // انتخاب مقصد باید دوباره تایید شود (صرفاً انتخاب پرداخت کافی نیست)
            function refresh() {
                var selected = document.querySelector('input[name="payment_method"]:checked');
                document.querySelectorAll('.sport-payment-option').forEach(function(label) {
                    label.classList.remove('selected');
                });
                var deliveryOptions = document.getElementById('deliveryOptions');
                if (selected) {
                    document.querySelector('label[for="' + selected.id + '"]').classList.add('selected');
                    if (selected.value === 'in_person') {
                        deliveryOptions.style.display = 'block';
                        completeBtn.disabled = true; // تا انتخاب مقصد
                    } else {
                        deliveryOptions.style.display = 'none';
                        document.getElementById('mapSection').style.display = 'none';
                        completeBtn.disabled = false;
                    }
                } else {
                    deliveryOptions.style.display = 'none';
                    document.getElementById('mapSection').style.display = 'none';
                    completeBtn.disabled = true;
                }
            }

            options.forEach(function(input) {
                input.addEventListener('change', refresh);
            });

            // ===== گزینه‌های مقصد تحویل =====
            var deliveryChoiceInputs = document.querySelectorAll('input[name="delivery_choice"]');

            function refreshDelivery() {
                var choice = document.querySelector('input[name="delivery_choice"]:checked');
                document.querySelectorAll('.sport-delivery-option').forEach(function(label) {
                    label.classList.remove('selected');
                });
                var mapSection = document.getElementById('mapSection');
                if (choice) {
                    document.querySelector('label[for="' + choice.id + '"]').classList.add('selected');
                    mapSection.style.display = 'none';
                    if (choice.value === 'custom') {
                        mapSection.style.display = 'block';
                        if (typeof geocodeCity === 'function' && !map) geocodeCity();
                        else if (map) setTimeout(function(){ map.invalidateSize(); }, 300);
                    }
                    completeBtn.disabled = false;
                } else {
                    mapSection.style.display = 'none';
                    completeBtn.disabled = true;
                }
            }

            deliveryChoiceInputs.forEach(function(input) {
                input.addEventListener('change', refreshDelivery);
            });

            // ===== نقشه شهر (پرداخت حضوری) =====
            var map = null;
            var marker = null;
            var city = '{{ $mapCity }}';
            var province = '{{ $mapProvince }}';

            function initMap(lat, lng, zoom) {
                if (!map) {
                    map = L.map('cityMap').setView([lat, lng], zoom);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap'
                    }).addTo(map);
                    map.on('click', function (e) {
                        placeMarker(e.latlng.lat, e.latlng.lng);
                    });
                } else {
                    map.setView([lat, lng], zoom);
                }
            }

            function placeMarker(lat, lng) {
                if (marker) marker.setLatLng([lat, lng]);
                else marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                document.getElementById('deliveryLat').value = lat;
                document.getElementById('deliveryLng').value = lng;
            }

            function geocodeCity() {
                // اگر شهر ثبت نشده بود، مستقیم نقشه تهران باز می‌شود
                @if(!($hasCity ?? false))
                    initMap(35.6892, 51.3890, 11); // پیش‌فرض: تهران
                    return;
                @endif

                fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(city + ', ' + province + ', Iran'))
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        if (data && data.length) {
                            initMap(parseFloat(data[0].lat), parseFloat(data[0].lon), 12);
                        } else {
                            initMap(35.6892, 51.3890, 11); // شهر پیدا نشد: تهران
                        }
                    })
                    .catch(function () {
                        initMap(35.6892, 51.3890, 11);
                    });
            }

            // وقتی گزینه «ارسال به مقصد دیگر» انتخاب شد، نقشه بارگذاری می‌شود
            // (این کار قبلاً در refreshDelivery انجام می‌شود؛ این بلوک دیگر لازم نیست)
        });
    </script>
@endpush
