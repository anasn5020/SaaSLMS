var back = false;
var totalExit = $('.losing_count').val();
var question_time_type = $('.losing_question_time_type').val();
var userAttend = 0;

let runner;
let totalQus = $('.quiz_assign').val();
let presentTime = document.getElementById('timer').innerHTML;


window.jsLang = function (key, replace) {
    let translation = true

    let json_file = window._translations;
    translation = json_file[key] ? json_file[key] : key


    $.each(replace, (value, key) => {
        translation = translation.replace(':' + key, value)
    })

    return translation
}

$(window).focus(function (e) {
    if (totalExit > 0 && back) {
        userAttend++;
        $('.focus_lost').val(userAttend);
        if (totalExit <= userAttend) {
            back = false;
            toastr.warning(userAttend + ' ' + $('.losing_message').val());
            $("#quizForm").submit();
        } else {
            toastr.warning(userAttend + ' ' + $('.losing_count_message').val());
        }
    }

});


let timeArray = presentTime.split(/[:]+/);

if (timeArray[0] == 0 && timeArray[1] == 0) {
    toastr.error(jsLang('data_time_not_defined'), jsLang('data_error'));
} else {
    var StartConfirmModal = new bootstrap.Modal($('#StartConfirmModal'));
    StartConfirmModal.show();

}
window.onbeforeunload = function (e) {
    if (back === true) return jsLang('data_are_you_sure_to_exit');
}
//---------------


$("#QuizStartBtn").click(function (e) {
    e.preventDefault();
    $('.modal-backdrop').fadeOut();
    $('#StartConfirmModal').modal().hide();
    $('.quiz_test_body').removeClass('d-none');
    $('body').removeAttr('style class');
    startQuiz();
});

function startQuiz() {
    back = true;
    let url = $('input[name="quiz_start_url"]').val();
    let courseId = $('input[name="courseId"]').val();
    let quizId = $('input[name="quizId"]').val();
    let quizType = $('input[name="quizType"]').val();
    let quiz_test_id = $('input[name="quiz_test_id"]').val();

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url,
        data: {
            'courseId': courseId,
            'quizId': quizId,
            'quizType': quizType,
            'quiz_test_id': quiz_test_id,
            'focus_lost': userAttend,
            "_token": $('meta[name="csrf-token"]').attr('content')

        },
        success: function (data) {
            if (data.result) {
                $('input[name="quiz_test_id"]').val(data.data.id);
            }
            startTimer();
        },
        error: function (request, status, error) {
            toastr.error(jsLang('data_multiple_attempt_not_allowed'), jsLang('data_error'));
            $('.quiz_test_body').addClass('d-none');
            $('.quiz_header_right').addClass('d-none');
        }
    });


}

function minuteToSecond(hms) {
    if (!hms) {
        var hms = $('#totalQuizTime').val();
    }
    var a = hms.split(':');
    return seconds = ((+a[0]) * 60) + (+a[1]);
}

//start timer
function startTimer() {
    var presentTime = document.getElementById('timer').innerHTML;


    var timeArray = presentTime.split(/[:]+/);

    var m = timeArray[0];
    var s = checkSecond((timeArray[1] - 1));
    if (s == 59) {
        m = m - 1
    }
    if ((m + '').length == 1) {
        m = '0' + m;
    }
    if (m < 0) {
        back = false;
        $("#quizForm").submit();
        // submitQuiz();
        // m = '59';
    } else {
        document.getElementById('timer').innerHTML = m + ":" + s;
        runner = setTimeout(startTimer, 1000);
    }

}

//check secound
function checkSecond(sec) {
    if (sec < 10 && sec >= 0) {
        sec = "0" + sec;
    }
    // add zero in front of numbers < 10
    if (sec < 0) {
        sec = "59";
    }

    return sec;
}

$(document).on("click", ".question_number_lists .nav-link", function (e) {
    e.preventDefault();

    $(this).addClass('active');
});


$(document).on("click", ".skip", function (e) {
    e.preventDefault();
    $('.question_number_lists .skip_qus').next('.nav-link').trigger('click');


    resetAttempt();
});

function resetAttempt() {
    if (question_time_type == 0) {
        userAttend = 0;
    }
}


function validateData(question_type, question_id, assign_id) {
    let ans = $(".tab-pane:visible").find('.quizAns:checked').val();

    if (question_type == "X") {
        // Check if value exists before accessing .length
        let matchingInput = $('#matching_connection_' + question_id).val();
        ans = matchingInput ? matchingInput.length : 0;

    } else if (question_type == "C") {
        // Handle multiple select or single select dropdown
        let quizSelect = $(".tab-pane:visible").find('.quiz-select').val();
        ans = Array.isArray(quizSelect) ? quizSelect.length : (quizSelect ? quizSelect.length : 0);

    } else if (question_type == "O") {
        // Sorting question, safely checking .val() before accessing .length
        let sortingAnswer = $('#sorting_has_answer_' + question_id).val();
        ans = sortingAnswer ? sortingAnswer.length : 0;

    } else if (question_type == "P") {
        // Puzzle question, safely checking .val() before accessing .length
        let puzzleAnswer = $('#puzzle_answer_' + question_id).val();
        ans = puzzleAnswer ? puzzleAnswer.length : 0;
    }

    if (ans == "undefined" || ans == "" || ans == null) {
        if (question_type == "M" || question_type == "C") {
            toastr.error(jsLang('data_select_option'), jsLang('data_error'));
            return false;
        } else if (question_type == "X") {
            toastr.error(window.jsLang('data_select_match'), window.jsLang('data_error'));
            return false;
        } else if (question_type === "O") {
            toastr.error(window.jsLang('data_change_sort_order'), window.jsLang('data_error'));
            return false;
        } else if (question_type === "P") {
            toastr.error(window.jsLang('data_select_puzzle_answer'), window.jsLang('data_error'));
            return false;
        } else {
            let answer_input = $("#editor" + assign_id).val();
            if (answer_input == "undefined" || answer_input == "" || answer_input == null) {
                toastr.error(jsLang('data_write_answer'), jsLang('data_error'));
                return false;
            }
        }
    }
    return true;
}

$(".next").click(function (e) {
    e.preventDefault();

    resetAttempt();

    let question_type = $(this).data('question_type');
    let question_id = $(this).data('question_id');
    let assign_id = $(this).data('assign_id');

     if (!validateData(question_type, question_id, assign_id)) {
        return false;
    }

     let $this =$(this);


    questionSubmitSingle(question_type, assign_id, question_id,$this);
    $('.question_number_lists .link_' + assign_id).next('.nav-link').trigger('click');

});


// new feature


$(".quizSubmitClose").click(function (e) {
    $(".submitBtn").html('Submit');
});
$(".submitBtn").click(function (e) {
    e.preventDefault();

    let question_type = $(this).data('question_type');
    let assign_id = $(this).data('assign_id');
    let question_id = $(this).data('question_id');


    if (!validateData(question_type, question_id, assign_id)) {
        return false;
    }
    let $this =$(this);

   let submit = questionSubmitSingle(question_type, assign_id, question_id,$this);

     $(".submitBtn").html('Submitting..');
     if (submit){
         $('#submitConfirmModal').modal('show');
     }
    // setTimeout(function () {
    //     $('#submitConfirmModal').modal('show');
    // }, 3000);


});

$("#QuizSubmitBtn").click(function (e) {
    e.preventDefault();
    back = false;
    $("#quizForm").submit();
});

$(".questionLink").click(function (e) {
    var element = $(this);
    var currentNumber = $('#currentNumber');
    var number = element.text();
    currentNumber.text(number);

    questionIsChecked();

    element.removeClass('skip_qus');
    element.removeClass('pouse_qus');
    element.removeClass('wait_for_confirm ')
    element.addClass('skip_qus')

    $('.singleQuestion').each(function (i, obj) {
        var qus_id = $(this).data('qus-id');
        var link = $('#pills-' + qus_id);


        if (element.data('qus') === qus_id) {

            link.addClass('active');
            link.addClass('show');
        } else {
            link.removeClass('active');
            link.removeClass('show');
        }
    })
});


function questionIsChecked() {
    $('.singleQuestion').each(function () {
        var qus_id = $(this).data('qus-id');
        var qus_type = $(this).data('qus-type');
        var link = $('.link_' + qus_id);

        // Remove all status-related classes
        link.removeClass('skip_qus pouse_qus active wait_for_confirm');

        let isAnswered = false;

        // Handle different question types
        if (qus_type == "M") {
            // For multiple-choice with checkboxes
            isAnswered = $(this).find(':checkbox').is(":checked");

        } else if (qus_type == "C") {
            // For multiple select (dropdown selection)
            let quizSelect = $(this).closest('.puzzleQuestionBox').find('.quiz-select').val();
            isAnswered = quizSelect ? quizSelect.length > 0 : false;

        } else if (qus_type == "X") {
            // For matching questions
            let question_id = $(this).data('qus-bank-id');
            let matchingInput = $('#matching_connection_' + question_id);
            isAnswered = matchingInput.length > 0 && matchingInput.val().length > 0;

        } else if (qus_type == "O") {
            // For sorting questions
            let sortingAnswer = $('#sorting_has_answer_' + qus_id).val();
            isAnswered = sortingAnswer ? sortingAnswer.length > 0 : false;

        } else if (qus_type == "P") {
            // For puzzle-type questions
            let puzzleAnswer = $('#puzzle_answer_' + qus_id).val();
            isAnswered = puzzleAnswer ? puzzleAnswer.length > 0 : false;

        } else {
            // For editor-based questions
            let answer_input = $("#editor" + qus_id).val();
            isAnswered = answer_input && answer_input.trim() !== "";
        }

        // Set classes based on answer status
        if (isAnswered) {
            if (link.hasClass('quiz_is_submit')) {
                link.addClass('active');
            } else {
                link.addClass('wait_for_confirm');
            }
        } else {
            link.addClass('pouse_qus');
        }
    });
}


function questionSubmitSingle(question_type, assign_id, question_id,elm) {
    let url = $('input[name="single_quiz_submit_url"]').val();
    let quiz_test_id = $('input[name="quiz_test_id"]').val();
    let show_ans = $('input[name="show_ans"]').val();
    let show_ans_success = $('input[name="show_ans_success"]').val();
    let show_ans_failed = $('input[name="show_ans_failed"]').val();

    $('.link_' + assign_id).addClass('quiz_is_submit');

    var data = [];

    if (question_type == "M") {

        $(elm).closest('.singleQuestion').find('.quizAns:checked').each(function () {
            data.push(this.value);
        });

    } else if (question_type == "O") {
        $(elm).closest('.singleQuestion').find('.sorting_ans').each(function (i) {
            data[i] = $(this).data('id');
        });
    } else if (question_type == "C") {
        $(elm).closest('.singleQuestion').find('.quiz-select').each(function (i) {
            data[i] = $(this).val();
        });
    } else if (question_type == "P") {
        data = $('#puzzle_answer_' + question_id).val()
    } else if (question_type == "X") {
        data = $('#matching_connection_' + question_id).val()
    } else {
        data = $("#editor" + assign_id).val();
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url,
        data: {
            'quiz_test_id': quiz_test_id,
            'assign_id': assign_id,
            'type': question_type,
            'ans': data,
            'focus_lost': userAttend,
            "_token": $('meta[name="csrf-token"]').attr('content')

        },
        success: function (data) {
            // questionIsChecked();
            if (show_ans == 1) {
                if (data) {
                    toastr.success(show_ans_success);
                } else {
                    toastr.error(show_ans_failed);
                }
            }

        }
    });

    return true;

}


$(document).on('change', '.quizAns', function () {
    let total = $(this).closest('.singleQuestion').find('.questionAnsTotal').text();
    let checked = $(this).closest('.singleQuestion').find('.quizAns:checked').length;
    if (total == 1) {
        if (checked > total) {
            $(this).closest('.singleQuestion').find('.quizAns').each(function () {
                $(this).prop('checked', false)
            });
            $(this).prop('checked', true)
        }
    }

});

$('.sorting-options').sortable({
    handle: ".drag-handle",
    update: function (event, ui) {
        let qus_id = $(this).data('question-id');
        $('#sorting_has_answer_' + qus_id).val(1);
    }
});
//puzzle start
var answerLog = {};

// Make answers draggable
$('.answer-box').draggable({
    helper: "clone",
    revert: "invalid",
    cursor: "move"
});

// Make question boxes droppable
$('.question-box').droppable({
    accept: ".answer-box",
    drop: function (event, ui) {
        var $this = $(this);
        var bankId = $this.data('bank');
        var questionId = $this.data('question-id');
        var answerId = ui.helper.data('answer-id');
        var answerText = ui.helper.find('.answer-input').text();
        // Check if this answer is already added to the question
        var existingAnswer = $this.find('.dropped-answer[data-answer-id="' + answerId + '"]');
        if (existingAnswer.length > 0) {
            toastr.warning("Answer already added to the question!");
            return;
        }

        // Clone the dropped answer and append it to the question's answer container
        var clonedAnswer = $('<div class="dropped-answer">').html(`<div class="answer-text-content">${answerText}</div>`)
            .append($('<button class="remove-answer"><i class="ti-close"></i></button>'))
            .attr('data-answer-id', answerId);

        $this.find('.answer-container').append(clonedAnswer);

        // Add to answer log
        if (!answerLog[questionId]) {
            answerLog[questionId] = [];
        }

        // Log the answer added to the question
        answerLog[questionId].push(answerId);


        $('#puzzle_answer_' + bankId).val(JSON.stringify(answerLog));
    }
});

// Remove answer functionality
$(document).on('click', '#QuizCancelBtn', function () {
    $('.modal-backdrop').fadeOut();
    $('#StartConfirmModal').modal().hide();
    $('.quiz_test_body').empty();
});
document.getElementById('StartConfirmModal').addEventListener('hide.bs.modal', function (event) {
    if (document.referrer) {
        location.href = document.referrer;
    } else {
        location.replace($('#QuizCancelBtn').data('url'));
    }
});
$(document).on('click', '.remove-answer', function () {
    var $answer = $(this).closest('.dropped-answer');
    var questionId = $answer.closest('.question-box').data('question-id');
    var answerId = $answer.data('answer-id');
    var bankId = $answer.data('bank');

    // Remove the answer from the log
    if (answerLog[questionId]) {
        answerLog[questionId] = answerLog[questionId].filter(function (id) {
            return id != answerId;
        });

        $('#puzzle_answer_' + bankId).val(JSON.stringify(answerLog));
    }

    $answer.remove();
});
//puzzle end
$(document).ready(function() {
    // Once the DOM is fully loaded, append niceSelect to the desired select element
    $('.quiz-select').niceSelect();
});
