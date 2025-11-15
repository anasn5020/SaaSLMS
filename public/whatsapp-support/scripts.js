function setTimeToAll() {
    let start = $('#agent_start0').val();
    let end = $('#agent_end0').val();
    if (start === '' || end === '') {
        toastr.error('Please set start and end time for the sunday.','Error')
        return;
    }

    for(let i = 1; i < 7; i++){
        $('#agent_start'+i).val(start);
        $('#agent_end'+i).val(end);
    }
}

$( document ).ready(function() {
    $('.whatsApp_icon').on('click', function(){
        $('.whatsApp_popup_position').toggleClass('active');
    });
    $('.whats_app_popup_close').on('click', function(){
        $(this).parent('.whatsApp_popup_position').removeClass('active');
    });

    $('.single_group_member_inner').click(function(e){
        e.preventDefault();
        $('.single_group_member').each(function(i,e){
            $(e).removeClass('active').children('.whats_app_popup_input').slideUp();
        });
        $(this).closest('.single_group_member').addClass('active').children('.whats_app_popup_input').slideDown();
    });
});

