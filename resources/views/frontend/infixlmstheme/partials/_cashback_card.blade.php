@php
    $cashback_amount = checkProductCashback($product);
@endphp
@if ($cashback_amount > 0 && !$isEnrolled)
    <div class="theme_line_btn d-block text-center height_50 mb_20 minus_margin_top_10" style="padding: 35px;">
        <div class="d-flex align-items-center justify-content-center" style="margin-bottom: 5px;">
            <div class="font-14 fw-bold ">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 11V9C2 5.5 4 4 7 4H17C20 4 22 5.5 22 9V15C22 18.5 20 20 17 20H12"
                          stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <path
                        d="M12 14.5C13.3807 14.5 14.5 13.3807 14.5 12C14.5 10.6193 13.3807 9.5 12 9.5C10.6193 9.5 9.5 10.6193 9.5 12C9.5 13.3807 10.6193 14.5 12 14.5Z"
                        stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                        stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M18.5 9.5V14.5" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 15.5H7.34003C7.98003 15.5 8.5 16.02 8.5 16.66V17.94" stroke="currentColor"
                          stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path d="M3.21997 14.28L2 15.5L3.21997 16.72" stroke="currentColor" stroke-width="1.5"
                          stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8.5 20.7801H3.15997C2.51997 20.7801 2 20.2601 2 19.6201V18.3401"
                          stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M7.28125 22.0003L8.50122 20.7803L7.28125 19.5603" stroke="currentColor"
                          stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
                {{_trans('cashback.Cashback')}}
                @php
                    $purchase_message = _trans('cashback.Purchase this product and get :amount as cashback');
                    $amount = "<b>".getPriceFormat($cashback_amount)."</b>";
                    $purchase_message = str_replace(':amount', $amount, $purchase_message);
                @endphp

            </div>
        </div>
        <small>
            <span class="">{!! $purchase_message !!}</span>
        </small>
    </div>
@endif
