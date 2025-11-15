$(document).ready(function () {
    var base_url = $('.base_url').val();
    $('.select2').select2();
    $('.select2').css('width', '100%');
    $("#applyCoupon").on('click', function (event) {

        event.preventDefault();
        let code = $('#code').val();
        let total = $('#total').val();
        let balance = $('.user_balance').val();
        let balanceInput = $('#balanceInput');
        let sign = $('.currency_symbol').val();
        let cart_type = $('#cart_type');
        let type = '';

        if (cart_type.length) {
            type = cart_type.val();
        }
        if (code == "" || total == "") {
            toastr.error('Ops, Coupon Code Is Empty');
        } else {


            $.ajax({
                type: "GET",
                data: {code: code, total: total, type: type},
                dataType: "json",
                url: base_url + '/StudentApplyCoupon',
                success: function (data) {

                    if (data.error) {
                        // $('#totalBalance').html("23");
                        $('.totalBalance').html(sign + "" + data.total);
                        $('.totalTax').html(sign + "" + data.tax);
                        $('#successMessage').html("");
                        toastr.error(data.error);
                    } else {
                        $('#discountBox').show();
                        $('#couponBox').hide();
                        $('.totalTax').html(sign + " " + data.tax);
                        $('.totalBalance').html(sign + " " + data.total);
                        $('.discountAmount').html(sign + " " + (data.discount));
                        $('#successMessage').html(data.success);

                        toastr.success('Success', data.success);
                    }
                    if (balance >= data.total) {
                        balanceInput.show();
                    } else {
                        balanceInput.hide();

                    }

                },
                error: function (data) {
                    toastr.error("Something went wrong");
                },
            });

            // toastr.success('Success', 'Status has been changed');
        }


    });

    $("#cancelCoupon").on('click', function (event) {

        event.preventDefault();

        let total = $('#total').val();
        let balance = $('.user_balance').val();
        let balanceInput = $('#balanceInput');
        let sign = $('.currency_symbol').val();


        $.ajax({
            type: "GET",
            data: {code: 'N/A', total: total},
            dataType: "json",
            url: base_url + '/StudentApplyCoupon',
            success: function (data) {

                if (data.error) {
                    $('#discountBox').hide();
                    $('#couponBox').show();
                    $('#code').val('');
                    $('.totalBalance').html(sign + " " + data.total);
                    $('.discountAmount').html(sign + " " + (total - data.total));
                    toastr.error('Coupon Removed');
                } else {
                    $('.totalBalance').html(sign + " " + data.total);
                    $('#successMessage').html("");
                    toastr.error('Error', 'Something Went Wrong');

                }
                if (balance >= data.total) {
                    balanceInput.show();
                } else {
                    balanceInput.hide();

                }

            },
            error: function (data) {
                toastr.error('Error', "Something went wrong");
            },
        });


    });


    $(document).on('click', '.billing_address', function () {
        let bill = $(this).val();
        if (bill == 'new') {
            $('.billing_form').show();
            $('.billing_heading').show();
            $('.prev_billings').hide();
            $('.billing_info').hide();
            $('.billing_heading_edit').hide();
            $('#previous_address_edit').val('0');
        } else {
            $('.billing_form').hide();
            $('.billing_heading').hide();
            $('.prev_billings').show();
            $('.billing_heading_edit').hide();
            $('.old_billing').trigger('change');
            $('#previous_address_edit').val('0');
        }
    });

    $(document).on('click', '#editPrevious', function () {
        $('.billing_form').show();
        $('.billing_heading').show();
        $('.prev_billings').hide();
        $('.billing_info').hide();
        $('.billing_heading_edit').show();

        let billing = $('.old_billing').find(':selected').data('id');
        console.log(billing.country.id)
        $('#first_name').val(billing.first_name);
        $('#last_name').val(billing.last_name);
        $('#company_name').val(billing.company_name);
        $('#country').val(billing.country.id);
        $('#address1').val(billing.address1);
        $('#address2').val(billing.address2);
        $('#city').val(billing.city);
        $('#zip_code').val(billing.zip_code);
        $('#phone').val(billing.phone);
        $('#email').val(billing.email);
        $('#details').val(billing.details);
        $('#country').trigger('change');

        $('#previous_address_edit').val('1');
    });


    $(document).on('change', '.old_billing', function () {
        let billing = $(this).find(':selected').data('id');

        $('.billing_name').text(billing.first_name + ' ' + billing.last_name);
        $('.billing_email').text(billing.email);
        $('.billing_phone').text(billing.phone);
        $('.billing_company').text(billing.company_name);
        $('.billing_address').text(billing.address1 + ' ' + billing.address2);
        $('.billing_zip').text(billing.zip_code);
        $('.billing_city').text(billing.city);
        $('.billing_country').text(billing.country.name);
        $('.billing_details').text(billing.details);
        // $('.billing_payment').text(billing.payment_method);
        $('.billing_info').show();
    })

});
