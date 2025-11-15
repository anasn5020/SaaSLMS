@php
    $merchantID =getPaymentEnv('PAYTM_MERCHANT_ID');
@endphp
@if(env('PAYTM_ENVIRONMENT')=='production')
    <script type="application/javascript" crossorigin="anonymous"
            src="https:\\securegw.paytm.in\merchantpgpui\checkoutjs\merchants\<?php echo $merchantID?>.js"></script>
@else
    <script type="application/javascript" crossorigin="anonymous"
            src="https:\\securegw-stage.paytm.in\merchantpgpui\checkoutjs\merchants\<?php echo $merchantID?>.js"></script>
@endif


<form action="#"
      method="post">
    @csrf
    <input type="hidden" name="method"
           value="{{$gateway->method}}">
    <input type="hidden" name="test_amount"
           value="{{$amount}}">
    <button type="button" class="{{$type!='deposit' && $type!='booking'?'Payment_btn':''}}" onclick="openJsCheckout()">
        <img class="w-100"
             src="{{asset($gateway->logo)}}"
             alt="">
    </button>

</form>

<script type="text/javascript">
    function openJsCheckout() {

        $('.preloader').fadeIn('slow');
        $.ajax({
            type: 'POST',
            url: '{{route('paytm.make.payment')}}',
            data: {
                '_token': '{{ csrf_token() }}',
                'type': '{{$type??'test'}}',
                'amount': '{{$amount??1}}',
            },
            success: function (data) {
                $('.preloader').fadeOut('slow');
                $('.paytm-pg-loader').show();
                $('.paytm-overlay').show();
                if (data.txnToken == "") {
                    alert(data.message);
                    $('.paytm-pg-loader').hide();
                    $('.paytm-overlay').hide();
                    return false;
                }
                invokeBlinkCheckoutPopup(data.orderId, data.txnToken, data.amount)
            }, error: function (xhr, status, error) {
                $('.preloader').fadeOut('slow');
                toastr.error("{{trans('payment.Phone number is required. Please update your profile')}}");
            }
        });

    }

    function invokeBlinkCheckoutPopup(orderId, txnToken, amount) {
        window.Paytm.CheckoutJS.init({
            "root": "",
            "flow": "DEFAULT",
            "data": {
                "orderId": orderId,
                "token": txnToken,
                "tokenType": "TXN_TOKEN",
                "amount": amount,
            },
            handler: {
                transactionStatus: function (data) {
                },
                notifyMerchant: function notifyMerchant(eventName, data) {
                    if (eventName == "APP_CLOSED") {
                        $('.paytm-pg-loader').hide();
                        $('.paytm-overlay').hide();
                        //location.reload();
                    }
                    console.log("notify merchant about the payment state");
                }
            }
        }).then(function () {
            window.Paytm.CheckoutJS.invoke();
        });
    }

</script>
