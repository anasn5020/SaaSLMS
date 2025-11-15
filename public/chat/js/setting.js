$( document ).ready(function() {
    let method = $('input[name="chat_method"]:checked').val();
    if (method == 'pusher') {
        $('#pusher').css('display','');
        $('#jquery').hide();
        $('#pusher').show();
    }else{
        $('#pusher').hide();
    }
    $('input[name=chat_method]').change(function () {
        let method = $('input[name="chat_method"]:checked').val();
        if (method == 'pusher') {
            $('#jquery').hide();
            $('#pusher').show();
        }else{
            $('#pusher').hide();
        }
    });
});
