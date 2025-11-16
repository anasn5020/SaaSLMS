let lang = window._locale;
let baseURL = $("#url").val();
$(document).ready(function () {
    $("#category_id").on("change", function () {
        var url = $("#url").val();
        // console.log(url);

        var formData = {
            id: $(this).val(),
        };
        // get section for student
        $.ajax({
            type: "GET",
            data: formData,
            dataType: "json",
            url: url + "/" + "admin/course/ajaxGetCourseSubCategory",
            success: function (data) {
                // console.log(data);
                var a = "";
                // $.loading.onAjax({img:'loading.gif'});
                $.each(data, function (i, item) {
                    if (item.length) {
                        $("#subcategory_id").find("option").not(":first").remove();
                        $("#subCategoryDiv ul").find("li").not(":first").remove();

                        $.each(item, function (i, section) {
                            $("#subcategory_id").append(
                                $("<option>", {
                                    value: section.id,
                                    text: section.name[lang],
                                })
                            );

                            $("#subCategoryDiv ul").append(
                                "<li data-value='" +
                                section.id +
                                "' class='option'>" +
                                section.name[lang] +
                                "</li>"
                            );
                        });
                    } else {
                        $("#subCategoryDiv .current").html("Select Sub Category");
                        $("#subcategory_id").find("option").not(":first").remove();
                        $("#subCategoryDiv ul").find("li").not(":first").remove();
                    }
                });
                // console.log(a);
            },
            error: function (data) {
                console.log("Error:", data);
            },
        });
    });

    $("#subcategory_id").on("change", function () {
        var url = $("#url").val();

        var formData = {
            category_id: $('#category_id').val(),
            subcategory_id: $(this).val(),
        };

        $.ajax({
            type: "GET",
            data: formData,
            dataType: "json",
            url: url + "/" + "ajaxGetCourseList",
            success: function (data) {
                $.each(data, function (i, item) {
                    if (item.length) {
                        $("#course_id").find("option").not(":first").remove();
                        $("#CourseDiv ul").find("li").not(":first").remove();

                        $.each(item, function (i, course) {
                            $("#course_id").append(
                                $("<option>", {
                                    value: course.id,
                                    text: course.title2,
                                })
                            );
                            $("#CourseDiv ul").append("<li data-value='" + course.id + "' class='option'>" + course.title2 + "</li>");
                        });
                    } else {
                        $("#CourseDiv .current").html("Select A Course *");
                        $("#course_id").find("option").not(":first").remove();
                        $("#CourseDiv ul").find("li").not(":first").remove();
                    }
                });
                // console.log(a);
            },
            error: function (data) {
                console.log("Error:", data);
            },
        });
    });
});

$(document).ready(function () {
    $(".edit_category_id").on("change", function () {
        var url = $("#url").val();

        var course_id = $(this).closest('#course').data('course_id');

        var formData = {
            id: $(this).val(),
        };


        $.ajax({
            type: "GET",
            data: formData,
            dataType: "json",
            url: url + "/" + "admin/course/ajaxGetCourseSubCategory",
            success: function (data) {
                // console.log("#edit_subcategory_id"+course_id);
                // console.log("#edit_subCategoryDiv"+course_id+" ul");
                var a = "";
                // $.loading.onAjax({img:'loading.gif'});
                $.each(data, function (i, item) {
                    if (item.length) {
                        $("#edit_subcategory_id" + course_id).find("option").not(":first").remove();
                        $("#edit_subCategoryDiv" + course_id + " ul").find("li").not(":first").remove();

                        $.each(item, function (i, section) {
                            $("#edit_subcategory_id" + course_id).append(
                                $("<option>", {
                                    value: section.id,
                                    text: section.name[lang],
                                })
                            );

                            $("#edit_subCategoryDiv" + course_id + " ul").append(
                                "<li data-value='" +
                                section.id +
                                "' class='option'>" +
                                section.name[lang] +
                                "</li>"
                            );
                        });
                    } else {
                        $("#edit_subCategoryDiv" + course_id + ".current").html("SECTION *");
                        $("#edit_subcategory_id" + course_id).find("option").not(":first").remove();
                        $("#edit_subCategoryDiv" + course_id + " ul").find("li").not(":first").remove();
                    }
                });
                // console.log(a);
            },
            error: function (data) {
                console.log("Error:", data);
            },
        });

    });
});

$(document).ready(function () {
    let discount = $('#addDiscount');
    let discountDiv = $('#discountDiv');
    $('#course_2').change(function () {
        if (this.checked) {
            $('#price_div').fadeOut('slow');
            discountDiv.fadeOut('slow');
            discount.val('');
            $('.booking_amount_field').val(0);
        } else {
            discountDiv.fadeIn('slow');
            discount.val('');
            $('#price_div').fadeIn('slow');
        }
    });

});
$(document).ready(function () {
    $('#course_3').change(function () {
        if (this.checked)
            $('#discount_price_div').fadeIn('slow');
        else
            $('#discount_price_div').fadeOut('slow');
    });
});


$(document).ready(function () {
    let discount = $('.editDiscount');
    let discountDiv = $('.editDiscountDiv');
    $('.edit_course_2').change(function () {
        var course_id = $(this).val();

        if (this.checked) {
            $('#edit_price_div').fadeOut('slow');
            discountDiv.fadeOut('slow');
            // discount.val();
        } else {
            $('#edit_price_div').fadeIn('slow');
            discountDiv.fadeIn('slow');
            // discount.val('');
        }
    });

    $('.edit_course_2').trigger('change');

});
$(document).ready(function () {
    $('.edit_course_3').change(function () {
        if (this.checked)
            $('#edit_discount_price_div').fadeIn('slow');
        else
            $('#edit_discount_price_div').fadeOut('slow');

    });
});
$(document).ready(function () {
    $("#type1").on("click", function () {
        if ($('#type1').is(':checked')) {
            $(".courseBox").show();
            $(".quizBox").hide();
            $(".videoOption").show();
            $("#quiz_id").val('');
            $("#dripCheck").show();
            // $(".makeResize").addClass("col-xl-4");
            // $(".makeResize").removeClass("col-xl-6");
        }
    });

    $("#type2").on("click", function () {
        if ($('#type2').is(':checked')) {
            $(".courseBox").hide();
            $(".quizBox").show();
            $(".videoOption").hide();
            $("#dripCheck").hide();
            // $(".makeResize").addClass("col-xl-6");
            // $(".makeResize").removeClass("col-xl-4");
        }
    });

    $(".type1").on("click", function () {
        if ($('.type1').is(':checked')) {
            $(".courseBox").show();
            $(".quizBox").hide();
            $("#quiz_id").val('');
            $(".videoOption").show();
            $(".dripCheck").show();
            // $(".makeResize").addClass("col-xl-4");
            // $(".makeResize").removeClass("col-xl-6");
        }
    });

    $(".type2").on("click", function () {

        if ($('.type2').is(':checked')) {
            $(".courseBox").hide();
            $(".videoOption").hide();
            $(".quizBox").show();
            $(".dripCheck").hide();
            /*        $(".makeResize").addClass("col-xl-6");
                    $(".makeResize").removeClass("col-xl-4");*/
        }
    });

    $(document).on('change', '.category_id', function () {
        let category_id = $(this).find(":selected").val();
        if (category_id === 'Youtube' || category_id === 'URL'|| category_id === 'm3u8'|| category_id === 'Custom') {
            $(this).closest('.videoOption').find('.VdoCipherUrl').hide();
            $(this).closest('.videoOption').find('.videoUrl').show();
            $(this).closest('.videoOption').find('.vimeoUrl').hide();
            $(this).closest('.videoOption').find('.videofileupload').hide();
            $(this).closest('.videoOption').find('.vimeoVideo');
            $(this).closest('.videoOption').find('.youtubeVideo');
            $(this).closest('.videoOption').find('.videofileupload');

        } else if (category_id === 'Self' || (category_id === 'AmazonS3')) {
            $(this).closest('.videoOption').find('.VdoCipherUrl').hide();
            $(this).closest('.videoOption').find('.videofileupload').show();
            $(this).closest('.videoOption').find('.videoUrl').hide();
            $(this).closest('.videoOption').find('.vimeoUrl').hide();
            $(this).closest('.videoOption').find('.vimeoVideo');
            $(this).closest('.videoOption').find('.youtubeVideo');
            $(this).closest('.videoOption').find('.videofileupload');

        } else if (category_id === 'Vimeo') {
            $(this).closest('.videoOption').find('.VdoCipherUrl').hide();
            $(this).closest('.videoOption').find('.videofileupload').hide();
            $(this).closest('.videoOption').find('.videoUrl').hide();
            $(this).closest('.videoOption').find('.vimeoUrl').show();
            $(this).closest('.videoOption').find('.vimeoVideo');
            $(this).closest('.videoOption').find('.youtubeVideo');
            $(this).closest('.videoOption').find('.videofileupload');
        } else if (category_id === 'VdoCipher') {
            $(this).closest('.videoOption').find('.videofileupload').hide();
            $(this).closest('.videoOption').find('.videoUrl').hide();
            $(this).closest('.videoOption').find('.vimeoUrl').hide();
            $(this).closest('.videoOption').find('.VdoCipherUrl').show();
            $(this).closest('.videoOption').find('.vimeoVideo');
            $(this).closest('.videoOption').find('.youtubeVideo');
            $(this).closest('.videoOption').find('.videofileupload');
        } else if (category_id === 'BunnyStorage') {
            $(this).closest('.videoOption').find('.VdoCipherUrl').hide();
            $(this).closest('.videoOption').find('.videofileupload').hide();
            $(this).closest('.videoOption').find('.videoUrl').hide();
            $(this).closest('.videoOption').find('.vimeoUrl').hide();
            $(this).closest('.videoOption').find('.bunnyStreamUrl').show();
            $(this).closest('.videoOption').find('.vimeoVideo');
            $(this).closest('.videoOption').find('.youtubeVideo');
            $(this).closest('.videoOption').find('.videofileupload');
        } else {
            $(this).closest('.videoOption').find('.VdoCipherUrl').hide();
            $(this).closest('.videoOption').find('.videofileupload').hide();
            $(this).closest('.videoOption').find('.videoUrl').hide();
            $(this).closest('.videoOption').find('.vimeoUrl').hide();
            $(this).closest('.videoOption').find('.vimeoVideo');
            $(this).closest('.videoOption').find('.youtubeVideo');
            $(this).closest('.videoOption').find('.videofileupload');
        }
    });
    $(document).on('change', '.type', function () {
        let type = $(this).val();
        if (type == 0) {
            $('.single_class').show();
            $('.continuous_class').hide();
        } else {
            $('.single_class').hide();
            $('.continuous_class').show();
        }
    })
    $(document).on('change', '.free_class', function () {
        if ($(this).is(':checked')) {
            $('.fees').hide();
        } else {
            $('.fees').show();
        }
    })

});

function changeType(el) {
    var validity = document.getElementById('show_validity');
    var course = document.getElementById('show_course');
    if (el.value == 1) {
        validity.style.display = 'block';
        course.style.display = 'none';
    } else {
        validity.style.display = 'none';
        course.style.display = 'block';
    }
}


$(document).on('click', '#add_course_btn', function () {
    $('#addTitle').val('');
    $('#addDuration').val('');
    $('#addPrice').val('');
    $('#addMeta').val('');
});

$('input[type=radio][name=host]').change(function () {
    let host = this.value;
    if (host == "Zoom") {
        $('.zoomSetting').show();
        $('.bbbSetting').hide();
        $('.InAppLiveClassSetting').hide();
        $('.jitsiSetting').hide();
    } else if (host == "BBB") {
        $('.zoomSetting').hide();
        $('.bbbSetting').show();
        $('.InAppLiveClassSetting').hide();
        $('.jitsiSetting').hide();
    } else if (host == "Jitsi") {
        $('.zoomSetting').hide();
        $('.bbbSetting').hide();
        $('.InAppLiveClassSetting').hide();
        $('.jitsiSetting').show();
    } else if (host == "InAppLiveClass") {
        $('.zoomSetting').hide();
        $('.bbbSetting').hide();
        $('.jitsiSetting').hide();
        $('.InAppLiveClassSetting').show();
    } else {
        $('.zoomSetting').hide();
        $('.bbbSetting').hide();
        $('.jitsiSetting').hide();
        $('.InAppLiveClassSetting').hide();
    }

    allowCalendarDivToggle(host);
});

allowCalendarDivToggle();

function allowCalendarDivToggle(host = '') {
    let div = $('.allow_google_calendar_div');
    if (host == 'GoogleMeet') {
        div.hide();
    } else {
        div.show()
    }
}

function getVimeoList(obj) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: baseURL + "/" + "admin/course/get-vimeo-list",
        success: function (data) {


            $.each(data, function (index, value) {
                obj.html('<option value=' + value.uri + '>' + value.name + '</option>');
            });


            // $.each(data, function (i, item) {
            //     if (item.length) {
            //         $("#subcategory_id").find("option").not(":first").remove();
            //         $("#subCategoryDiv ul").find("li").not(":first").remove();
            //
            //         $.each(item, function (i, section) {
            //             $("#subcategory_id").append(
            //                 $("<option>", {
            //                     value: section.id,
            //                     text: section.name[lang],
            //                 })
            //             );
            //
            //             $("#subCategoryDiv ul").append(
            //                 "<li data-value='" +
            //                 section.id +
            //                 "' class='option'>" +
            //                 section.name[lang] +
            //                 "</li>"
            //             );
            //         });
            //     } else {
            //         $("#subCategoryDiv .current").html("Select Sub Category");
            //         $("#subcategory_id").find("option").not(":first").remove();
            //         $("#subCategoryDiv ul").find("li").not(":first").remove();
            //     }
            // });
            //
        },
        error: function (data) {
            console.log("Error:", data);
        },
    });
}

$(document).ready(function () {
    $('.vimeo_video_list').each(function (i, obj) {
        getVimeoList(obj);

    });
});
