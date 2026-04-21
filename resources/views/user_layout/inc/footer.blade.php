@php
    $footerPhone = '0913316855';
    $footerPhoneFormatted = '0913 316 855';
    $footerFax = '0312081798';
    $footerEmail = 'ctythachkhietminh@gmail.com';
    $footerAddress = '212B/60 Nguyễn Trãi, Phường Cầu Ông Lãnh, Thành phố Hồ Chí Minh, Việt Nam';
    $footerZaloUrl = 'https://zalo.me/' . $footerPhone;
    $footerMapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($footerAddress);
@endphp
<section class="site-footer" aria-label="{{ translate('Site footer') }}">

    {{-- Mobile quick-action CTAs (shown only on < lg) --}}
    <div class="footer-quick-actions d-flex d-lg-none">
        <a href="tel:{{ $footerPhone }}" class="footer-quick-action" aria-label="{{ translate('Gọi ngay') }}">
            <i class="fa fa-phone"></i>
            <span>{{ translate('Gọi ngay') }}</span>
        </a>
        <a href="{{ $footerZaloUrl }}" target="_blank" rel="noopener" class="footer-quick-action footer-quick-action--zalo" aria-label="Zalo">
            <i class="fa fa-comments"></i>
            <span>Zalo</span>
        </a>
        <a href="{{ $footerMapsUrl }}" target="_blank" rel="noopener" class="footer-quick-action" aria-label="{{ translate('Chỉ đường') }}">
            <i class="fa fa-map-marker"></i>
            <span>{{ translate('Chỉ đường') }}</span>
        </a>
    </div>

    <div class="container footer-container">
        <div class="row">

            {{-- Company --}}
            <div class="col-lg-3 col-md-6 col-sm-12 footer-col footer-col--brand">
                <h4 class="footer-title">{{ translate('CÔNG TY TNHH THẠCH KHIẾT MINH') }}</h4>
            </div>

            {{-- Contact --}}
            <div class="col-lg-3 col-md-6 col-sm-12 footer-col">
                <a href="#footerContact" class="footer-section-toggle collapsed"
                    data-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="footerContact">
                    <span class="footer-title">{{ translate('Thông tin liên hệ') }}</span>
                    <i class="fa fa-chevron-down footer-section-caret"></i>
                </a>
                <div class="collapse footer-section-body" id="footerContact">
                    <ul class="footer-list">
                        <li>
                            <a href="{{ $footerMapsUrl }}" target="_blank" rel="noopener" class="footer-link">
                                <i class="fa fa-map-marker footer-list-icon"></i>
                                <span>{{ $footerAddress }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="tel:{{ $footerPhone }}" class="footer-link">
                                <i class="fa fa-phone footer-list-icon"></i>
                                <span>{{ $footerPhoneFormatted }}</span>
                            </a>
                        </li>
                        <li>
                            <span class="footer-link footer-link--static">
                                <i class="fa fa-fax footer-list-icon"></i>
                                <span>{{ $footerFax }}</span>
                            </span>
                        </li>
                        <li>
                            <a href="mailto:{{ $footerEmail }}" class="footer-link">
                                <i class="fa fa-envelope footer-list-icon"></i>
                                <span>{{ $footerEmail }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Policy --}}
            <div class="col-lg-3 col-md-6 col-sm-12 footer-col">
                <a href="#footerPolicy" class="footer-section-toggle collapsed"
                    data-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="footerPolicy">
                    <span class="footer-title">{{ translate('Policy') }}</span>
                    <i class="fa fa-chevron-down footer-section-caret"></i>
                </a>
                <div class="collapse footer-section-body" id="footerPolicy">
                    <ul class="footer-list">
                        <li><a href="#" class="footer-link">{{ translate('Chính sách thanh toán') }}</a></li>
                        <li><a href="#" class="footer-link">{{ translate('Chính sách xử lý khiếu nại') }}</a></li>
                        <li><a href="#" class="footer-link">{{ translate('Chính sách vận chuyển') }}</a></li>
                        <li><a href="#" class="footer-link">{{ translate('Chính sách đổi trả hoàn tiền') }}</a></li>
                    </ul>
                </div>
            </div>

            {{-- Support --}}
            <div class="col-lg-3 col-md-6 col-sm-12 footer-col">
                <a href="#footerSupport" class="footer-section-toggle collapsed"
                    data-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="footerSupport">
                    <span class="footer-title">{{ translate('Hỗ trợ') }}</span>
                    <i class="fa fa-chevron-down footer-section-caret"></i>
                </a>
                <div class="collapse footer-section-body" id="footerSupport">
                    <ul class="footer-list">
                        <li><a href="{{ route('products.all') }}" class="footer-link">{{ translate('Tìm kiếm') }}</a></li>
                        <li><a href="#" class="footer-link">{{ translate('Về chúng tôi') }}</a></li>
                        <li><a href="#" class="footer-link">{{ translate('Liên hệ') }}</a></li>
                    </ul>
                </div>
            </div>

        </div>

        {{-- Social & Copyright --}}
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between flex-wrap" style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 24px;">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        
                    </div>
                    <p style="color:#666; font-size:12px; margin:0;">
                        © {{ date('Y') }} {{ translate('CÔNG TY TNHH THẠCH KHIẾT MINH') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
