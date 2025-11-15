$(document).ready(function () {
    $(document).on('change', '.user_type', function () {
        let userType = $(this).val();
        let url = $('.get_user').val();
        $.post(url, {user_type: userType}, function (res) {
            $.each(res, function (index, item) {
                $('#selectSectionss').append(new Option(item.name, item.id))
            });
        })
    })

    $(document).on('click', '.recurring-type', function () {
        if ($("input[name='is_recurring']:checked").val() == 0) {
            $(".zoom-recurrence-section-hide").hide();
        } else {
            $(".zoom-recurrence-section-hide").show();
        }
    })

    $(document).on('click', '.chnage-default-settings', function () {
        if ($(this).val() == 0) {
            $(".default-settings").hide();
        } else {
            $(".default-settings").show();
        }
    })
    let is_default_settings = $('.is_default_settings').val();
    if(is_default_settings && is_default_settings == 1)
        $(".default-settings").show();
    else
        $(".default-settings").hide();

    let is_recurring = $('.recurrence_section').val();
    if ( is_recurring == 1)
        $(".zoom-recurrence-section-hide").show()
    else
        $(".zoom-recurrence-section-hide").hide();
})
