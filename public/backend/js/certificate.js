let makeUrl = $('#makeURL').val();
let uploadUrl = $('#uploadURL').val();
let bgImageInput = $('#bgImageInput');
let sigImageInput = $('#sigImageInput');
let progress = null;
$(document).ready(function () {


    $('.change-input').on('keyup keypress blur change', delay(function (e) {
        getNew();
    }, 500));


    //
    // $('.change-input').change(delay(function (e) {
    //     console.log('changed');
    //     getNew();
    // }, 500));

});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function getNew() {
    console.log('requesting..')
    let title = $('#title').val();
    let org_module = $('#org_module').val();
    let certificate_id = $('#certificate_id').val();
    let bgImage = $('#bgImageInput').val();
    let sigImageInput = $('#sigImageInput').val();
    let position_x_title = $('#position_x_title').val();
    let position_y_title = $('#position_y_title').val();
    let signature_text_font_color = $('#signature_text_font_color').val();
    let signature_text_font_size = $('#signature_text_font_size').val();
    let signature_text_font_family = $('#signature_text_font_family').find(":selected").val();
    let signature_text_position_y = $('#signature_text_position_y').val();
    let signature_text_position_x = $('#signature_text_position_x').val();
    let signature_text = $('#signature_text').val();
    let signature_weight = $('#signature_weight').val();
    let signature_height = $('#signature_height').val();
    let signature_position_y = $('#signature_position_y').val();

    let signature_position_x = $('#signature_position_x').val();
    let body_font_family = $('#body_font_family').find(":selected").val();
    let title_font_family = $('#title_font_family').find(":selected").val();

    let certificate_no = $("input[name='certificate_no']:checked").val();
    let certificate_no_font_color = $('#certificate_no_font_color').val();
    let certificate_no_font_size = $('#certificate_no_font_size').val();
    let certificate_no_font_family = $('#certificate_no_font_family').find(":selected").val();
    let certificate_no_position_y = $('#certificate_no_position_y').val();
    let certificate_no_position_x = $('#certificate_no_position_x').val();

    let date = $("input[name='date']:checked").val();
    let date_font_color = $('#date_font_color').val();
    let date_font_size = $('#date_font_size').val();
    let date_font_family = $('#date_font_family').find(":selected").val();
    let date_position_y = $('#date_position_y').val();
    let date_position_x = $('#date_position_x').val();
    let date_format = $('#date_format').find(":selected").val();

    let profile_weight = $('#profile_weight').val();
    let profile_height = $('#profile_height').val();
    let profile_y = $('#profile_y').val();
    let profile_x = $('#profile_x').val();
    let body_font_color = $('#body_font_color').val();
    let body_font_size = $('#body_font_size').val();
    let body_max_len = $('#body_max_len').val();
    let body_position_y = $('#body_position_y').val();
    let body_position_x = $('#body_position_x').val();
    let body = $('#body').val();
    let title_font_color = $('#title_font_color').val();
    let title_font_size = $('#title_font_size').val();
    let title_position_y = $('#title_position_y').val();
    let title_position_x = $('#title_position_x').val();
    let height = $('#height');
    let width = $('#width');

    let name_font_color = $('#name_font_color').val();
    let name_font_size = $('#name_font_size').val();
    let name_position_y = $('#name_position_y').val();
    let name_position_x = $('#name_position_x').val();
    let name_font_family = $('#name_font_family').find(":selected").val();
    let name = $("input[name='name']:checked").val();

    let profile = $("input[name='profile']:checked").val();


    let qr = $("input[name='qr']:checked").val();
    let qr_weight = $('#qr_weight').val();
    let qr_height = $('#qr_height').val();
    let qr_y = $('#qr_y').val();
    let qr_x = $('#qr_x').val();

    let show_title = $("input[name='show_title']:checked").val();
    let certificate_number_prefix = $('#certificate_number_prefix').val();
    let show_org_chart = '';
    let org_chart_x = '';
    let org_chart_y = '';
    let org_chart_font_family = '';
    let org_chart_font_size = '';
    let org_chart_font_color = '';
    if (org_module == 1) {
        show_org_chart = $("input[name='show_org_chart']:checked").val();
        org_chart_x = $('#org_chart_x').val();
        org_chart_y = $('#org_chart_y').val();
        org_chart_font_family = $('#org_chart_font_family').val();
        org_chart_font_size = $('#org_chart_font_size').val();
        org_chart_font_color = $('#org_chart_font_color').val();
    }

    let result = $("#certificateResult");
    if (progress) {
        progress.abort();
        progress = null;
    }

    progress = $.ajax({
        type: "GET",
        url: makeUrl,
        dataType: 'json',
        data: {
            title: title,
            id: certificate_id,
            bgImage: bgImage,
            sigImageInput: sigImageInput,
            position_x_title: parseInt(position_x_title),
            position_y_title: parseInt(position_y_title),
            signature_text_font_color: signature_text_font_color,
            signature_text_font_size: signature_text_font_size,
            signature_text_font_family: signature_text_font_family,
            signature_text_position_y: parseInt(signature_text_position_y),
            signature_text_position_x: parseInt(signature_text_position_x),
            signature_text: signature_text,
            signature_weight: signature_weight,
            signature_height: signature_height,
            signature_position_y: parseInt(signature_position_y),
            signature_position_x: parseInt(signature_position_x),

            certificate_no_font_color: certificate_no_font_color,
            certificate_no_font_size: certificate_no_font_size,
            certificate_no_font_family: certificate_no_font_family,
            certificate_no_position_y: parseInt(certificate_no_position_y),
            certificate_no_position_x: parseInt(certificate_no_position_x),
            certificate_no: certificate_no,

            date_format: date_format,
            date_font_color: date_font_color,
            date_font_size: date_font_size,
            date_font_family: date_font_family,
            date_position_y: parseInt(date_position_y),
            date_position_x: parseInt(date_position_x),
            date: date,

            profile: profile,
            profile_weight: profile_weight,
            profile_height: profile_height,
            profile_y: profile_y,
            profile_x: profile_x,

            qr: qr,
            qr_weight: qr_weight,
            qr_height: qr_height,
            qr_y: qr_y,
            qr_x: qr_x,


            body_font_color: body_font_color,
            body_font_size: body_font_size,
            body_max_len: body_max_len,
            body_font_family: body_font_family,
            body_position_y: parseInt(body_position_y),
            body_position_x: parseInt(body_position_x),
            body: body,
            title_font_color: title_font_color,
            title_font_size: title_font_size,
            title_font_family: title_font_family,
            title_position_y: parseInt(title_position_y),
            title_position_x: parseInt(title_position_x),
            name_font_color: name_font_color,
            name_font_size: name_font_size,
            name_position_y: parseInt(name_position_y),
            name_position_x: parseInt(name_position_x),
            name_font_family: name_font_family,
            name: name,
            show_org_chart: show_org_chart,
            org_chart_x: org_chart_x,
            org_chart_y: org_chart_y,
            org_chart_font_family: org_chart_font_family,
            org_chart_font_size: org_chart_font_size,
            org_chart_font_color: org_chart_font_color,
            certificate_number_prefix: certificate_number_prefix,
            show_title: show_title,

        },
        success: function (data) {
            result.attr("src", '');
            console.log(data.image.encoded);

            result.attr("src", data.image);
            width.html(data.width);
            height.html(data.height);
            toastr.success('Updated');
            progress = null;
        }
    });


}

function setBgImage() {
    let bgImage = document.getElementById("bgImage");
    var name = bgImage.files[0].name;
    var form_data = new FormData();
    var ext = name.split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) === -1) {
        toastr.error('Invalid File Format', "Error");
        return false;
    }
    var oFReader = new FileReader();
    oFReader.readAsDataURL(bgImage.files[0]);
    var f = bgImage.files[0];
    var fsize = f.size || f.fileSize;
    if (fsize > 1000000) {
        toastr.error('Image File Size is very big', 'Error');
    } else {
        if (bgImage.files.length !== 0) {
            form_data.append("file", bgImage.files[0]);
            $.ajax({
                url: uploadUrl,
                method: "POST",
                data: form_data,
                contentType: false,
                dataType: 'json',
                cache: false,
                processData: false,
                beforeSend: function () {
                    console.log('Image Uploading...');
                },
                success: function (data) {
                    console.log(data.location);
                    if (data.type === "Success") {
                        bgImageInput.val(data.location);

                    } else {
                        bgImageInput.val('');
                    }
                    toastr.success('Image Loading...');
                    getNew();
                }
            });
        }
    }

}


function setSigImage() {
    let sigImage = document.getElementById("signatureImage");
    var name = sigImage.files[0].name;
    var form_data = new FormData();
    var ext = name.split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) === -1) {
        toastr.error('Invalid File Format', "Error");
        return false;
    }
    var oFReader = new FileReader();
    oFReader.readAsDataURL(sigImage.files[0]);
    var f = sigImage.files[0];
    var fsize = f.size || f.fileSize;
    if (fsize > 500000) {
        toastr.error('Signature Image File Size is very big', 'Error');
    } else {
        if (sigImage.files.length !== 0) {
            form_data.append("file", sigImage.files[0]);
            $.ajax({
                url: uploadUrl,
                method: "POST",
                data: form_data,
                contentType: false,
                dataType: 'json',
                cache: false,
                processData: false,
                beforeSend: function () {
                    console.log('Image Uploading...');
                },
                success: function (data) {
                    console.log(data.location);
                    if (data.type === "Success") {
                        sigImageInput.val(data.location);

                    } else {
                        sigImageInput.val('');
                    }
                    toastr.success('Updated');
                    getNew();
                }
            });
        }
    }

}

function delay(callback, ms) {
    var timer = 0;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}

$(document).on('click', '.certificateType', function () {
    let type = $(this).val();
    hideShow(type);
})

function hideShow(type) {
    if (type == 'course') {
        $('#forCpd').addClass('d-none');
        $('#forMembership').addClass('d-none');
        $('#forCourse').removeClass('d-none');
    } else if (type == 'cpd') {
        $('#forCpd').removeClass('d-none');
        $('#forMembership').addClass('d-none');
        $('#forCourse').addClass('d-none');
    } else if (type == 'membership') {
        $('#forCpd').addClass('d-none');
        $('#forMembership').removeClass('d-none');
        $('#forCourse').addClass('d-none');
    } else {
        $('#forCpd').addClass('d-none');
        $('#forMembership').addClass('d-none');
        $('#forCourse').removeClass('d-none');
    }
}


