function copyCurrentUrl() {
    var copyText = document.getElementById('referral_link').value;
    console.log(copyText);
    var dummy = $('<input>').val(copyText).appendTo('body').select()
    document.execCommand('copy');
    toastr.success(window.jsLang('data_operation_success'));
}
