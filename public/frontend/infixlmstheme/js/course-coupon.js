$(document).ready(function () {
    var base_url = $('.base_url').val();
    $("#applyCourseCoupon").on('click', function (event) {
        event.preventDefault();
        let code = $('#couponText').val();
        let id = $(this).data('id');
        let alreadyApplied = $(this).data('already_applied');

        let priceTagEle = $('#price_show_tag');
        let couponAppliedEle = $('#couponApplied');
        let couponNotApplyEle = $('#couponNotApply');

        let couponCodeEle = $('.coupon_code');
        let couponOffEle = $('.coupon_off');

        if (code == "") {
            toastr.error('Ops, Coupon Code Is Empty');
        } else {

            $.ajax({
                type: "GET",
                data: {id: id, code: code, already_applied: alreadyApplied},
                dataType: "json",
                url: base_url + '/apply-course-coupon',
                success: function (data) {
                    if (data.status) {
                        priceTagEle.html(data.price);
                        couponAppliedEle.removeClass('d-none');
                        couponNotApplyEle.addClass('d-none');
                        toastr.success(data.message);
                        couponCodeEle.html(data.code);
                        couponOffEle.html(data.off);
                    } else {
                        toastr.error(data.message);
                        couponAppliedEle.addClass('d-none');
                        couponNotApplyEle.removeClass('d-none');
                        couponCodeEle.html('');
                        couponOffEle.html('');
                    }

                },
                error: function (data) {
                    toastr.error("Something went wrong");
                },
            });

            // toastr.success('Success', 'Status has been changed');
        }


    });

    $("#cancelCourseCoupon").on('click', function (event) {

        event.preventDefault();

        let total = $('#total').val();
        let balance = $('.user_balance').val();
        let balanceInput = $('#balanceInput');
        let sign = $('.currency_symbol').val();


        $.ajax({
            type: "GET",
            data: {code: 'N/A', total: total},
            dataType: "json",
            url: base_url + '/cancel-course-coupon',
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

});
