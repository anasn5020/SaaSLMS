function searchReceiver() {

    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("search_input");
    filter = input.value.toUpperCase();
    ul = document.getElementById("receiver_list");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function getMessage(id) {
    // event.preventDefault();

    $('#reciever_id').val(id);
    let url = $('.get_messages').val();
    var formData = {
        id: id
    };
    $.ajax({
        type: "POST",
        data: formData,
        dataType: "json",
        url: url,
        success: function (data) {
            $('#all_massages').empty();
            $('#all_massages').html(data['messages']);
            $('#receiver_name').html(data['receiver_name']);
        },
        error: function (data) {
            console.log("Error:", data);
        }
    });
}

function sendMessage() {
    // let demoMode = $('#demoMode').val();
    // if (demoMode == 1) {
    //     toastr.error("For the demo version, you cannot change this", "Error");
    //     return false;
    // }

    var url = $('.store_message').val();
    var reciever_id = $('#reciever_id').val();
    var message = $('#message').val();
    if (reciever_id == "") {
        toastr.error('Please Select Receiver first', 'Error');

        return false;
    }
    var formData = {
        reciever_id: reciever_id,
        message: message,
    };

    $.ajax({
        type: "POST",
        data: formData,
        dataType: "json",
        url: url,
        success: function (data) {
            // console.log(data);
            $('#all_massages').empty();
            $('#all_massages').html(data);
            $('#message').val('');
            $('#last_mesg').empty();
            $('#last_mesg' + reciever_id).html(message);
        },
        error: function (data) {
            console.log("Error:", data);
        }
    });
}

$(document).ready(function () {

    $("#submitForm").submit(function (e) {
       // e.preventDefault();
        // sendMessage()

    });
    $(document).on('click', '.submitMessageBtn', function (e) {
        e.preventDefault();
        sendMessage()
    });
    $(document).on('click', '.unseen', function () {
        $(this).removeClass("unseen")

    });

    $('.messages_chat ').scrollTop($('.messages_chat ')[0].scrollHeight);

// timeout js

    setTimeout(function () {
        let id = $('#receiver_list li').first().find('a').data('id');
        getMessage(id)
    }, 500);
});
