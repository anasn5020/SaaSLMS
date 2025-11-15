@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('invoice.Invoice')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/infixlmstheme/css/my_invoice.css')}}{{assetVersion()}}" rel="stylesheet"
          media="screen,print"/>
@endsection
@section('mainContent')
    <x-my-order-details-page-section :id="$id"/>

@endsection
@section('js')
    <script src="{{ asset('public/frontend/infixlmstheme') }}/js/html2pdf.bundle.js"></script>
    <script src="{{ asset('public/frontend/infixlmstheme/js/my_invoice.js') }}"></script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.order_cancel_by_id', function (e) {
                e.preventDefault();
                $('#orderCancelReasonModal').modal('show');
                $('.order_id').val($(this).attr('data-id'));
            });
            $(document).on('click', '#is_received', function () {
                var order_id = $(this).data('id');
                var package_id = $(this).data('package_id');
                // console.log(order_id);
                $("#pre-loader").show();
                $.post('{{ route('users.change_receive_status_by_customer') }}', {
                    _token: '{{ csrf_token() }}',
                    order_id: order_id,
                    package_id: package_id
                }, function (data) {
                    if (data == 1) {
                        toastr.success("{{__('product.order_has_been_recieved')}}", "{{__('common.Success')}}");
                    } else {
                        toastr.error("{{__('product.order_not_recieved')}} {{__('common.error_message')}}", "{{__('common.Error')}}");
                    }
                    $("#pre-loader").hide();
                    window.location.reload();
                });
            });
        });
    </script>

@endsection
