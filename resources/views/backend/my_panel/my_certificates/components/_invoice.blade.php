@if(isModuleActive('Invoice'))

    @if(!$certificate->orderCertificate)
        <a href="{{ route('prc.order.now', [$certificate->certificate_id]) }}"
           class="primary-btn fix-gr-bg"
           target="__blank">{{ __('invoice.Order Now') }}</a>
    @else
        @if($certificate->nonPaid())
            <a href="{{ route('prc.order.now', [$certificate->certificate_id]) }}"
               class="primary-btn fix-gr-bg"
               target="__blank">{{ __('invoice.Pay Now') }}</a>
        @else
            <strong>{{strtoupper($certificate->orderCertificate ? $certificate->orderCertificate->status : '')}}</strong>
        @endif
    @endif

@endif
