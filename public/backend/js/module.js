$(document).on('click', '.verifyBtn', function () {
    var module = $(this).data('id');
    $('#moduleName').val(module);
});
$(document).on('click', '.module_switch', function (e) {
    e.preventDefault();

    var url = $("#url").val();
    var module = $(this).data('id');
    console.log(module);

    $.ajax({
        type: "GET",
        dataType: "json",
        beforeSend: function () {
            $(".module_switch_label" + module).hide();
            $(".waiting_loader" + module).show();
        },
        url: url + "/modulemanager/" + "manage-adons-enable/" + module,
        success: function (data) {
            $(".waiting_loader" + module).hide();
            $(".module_switch_label" + module).show();
            if (data["success"]) {
                if (data["data"] == "enable") {
                    $(".module_switch_label" + module).text('Deactivate');
                } else {
                    $(".module_switch_label" + module).text('Activate');

                }
                toastr.success(data["success"], "Success Alert");
            } else {
                toastr.error(data["error"], "Fail Alert");
            }

        }
    })

    $(document).ajaxComplete(function () {
        console.log('reloading...')
        location.reload();
    });

})


