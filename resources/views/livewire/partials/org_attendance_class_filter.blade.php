<div>
    <style>
        .ms-options-wrap > button, .ms-options-wrap > button, .ms-options-wrap > button:focus {
            height: auto;
            margin-top: 7px;
        }

    </style>
    <div class="row " wire:ignore>
        <div class="col-xl-3 ">
            <div class="primary_input ">

                <select class="primary_select studentPositionSelect " name="category" id="category">
                    <option
                        data-display="{{__('common.Select')}} {{__('courses.Category')}}"
                        value="">{{__('common.Select')}} {{__('courses.Category')}}</option>
                    @foreach($categories->where('parent_id',0) as $category)
                        @include('coursesetting::parts_of_course_details.category_select_option',['category'=>$category,'level'=>1,'category_search'=>request('category')])

                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-3 ">
            <div class="primary_input ">

                <select class="primary_select studentPositionSelect" name="type" id="type">
                    <option value="offline"> {{__('org.Offline Class')}}</option>
                    <option
                        value="class"> {{__('virtual-class.Virtual Class')}}</option>

                </select>
            </div>
        </div>


        <div class="col-xl-3   selectOption offlineCourseSelect">
            <div class="primary_input mb-25">

                <select class=" active courseList " name="course[]"
                        id="course"
                        multiple>

                </select>
            </div>
        </div>

        <div class="col-xl-3   selectOption offlineClassSelect">
            <div class="primary_input mb-25">

                <select class=" active classList " name="class[]"
                        id="class"
                        multiple>
                </select>
            </div>
        </div>

    </div>

    @push('js')
        <script>
            let  lang =window._locale;
            $(function () {
                $("select[multiple].active.classList").multiselect({
                    columns: 1,
                    placeholder: "{{__('common.Select')}} {{__('org.Offline Class')}}",
                    search: true,
                    searchOptions: {
                        default: "Select",
                    },
                    selectAll: true,
                });

                $("select[multiple].active.courseList").multiselect({
                    columns: 1,
                    placeholder: "{{__('common.Select')}} {{__('org.Offline Course')}}",
                    search: true,
                    searchOptions: {
                        default: "Select",
                    },
                    selectAll: true,
                });
            });

            $(document).ready(function () {
                let classIds, option;
                $('.classList').on('change', function (e) {
                    classIds =$(this).map(function(i, el) {
                        return $(el).val();
                    }).get();
                 if(classIds.length!=0){
                     $('.classList .ms-selectall').text('ok')
                 }
                    option = $("#type option:selected").val();
                @this.set('class_ids', classIds);
                @this.set('class_type', option);
                @this.selectClass(option, classIds)
                });

                $('#type').on('change', function (e) {
                @this.set('class_type', $("#type option:selected").val());
                });
            });
        </script>


        <script>
            $(document).ready(function () {
                $(document).on("change", "#course", function () {
                    updateClassList();
                });
                let classTitle = '';
                $('#type,#category').change(function () {
                    let option = $("#type option:selected").val();
                    if (option === 'offline') {
                        $('.offlineCourseSelect').removeClass('d-none');
                        $('.selectOption').removeClass('col-xl-4');
                        $('.selectOption').addClass('col-xl-3');
                        classTitle = '{{__('common.Select')}} {{__('org.Offline Class')}} (*)';
                        updateCourseList();
                    } else {
                        $('.selectOption').removeClass('col-xl-3');
                        $('.selectOption').addClass('col-xl-4');
                        $('.offlineCourseSelect').addClass('d-none');
                        classTitle = '{{__('common.Select')}} {{__('virtual-class.Virtual Class')}} (*)';
                        updateClassList();
                    }
                    $('.classTitle').html(classTitle);


                });
            });

            function updateCourseList() {
                var url = $("#url").val();

                var formData = {
                    category: $("#category option:selected").val(),
                    type: $("#type option:selected").val(),
                };
                $.ajax({
                    type: "GET",
                    data: formData,
                    dataType: "json",
                    url: url + "/" + "org-subscription/offline-courses",
                    success: function (data) {
                        $("#course").empty();
                        $(".offlineCourseSelect .infix_ul_lists li").empty();
                        $(".offlineCourseSelect .ms-options-wrap button span").text('Select');


                        $("#course").find("option").not(":first").remove();
                        $("#course ul").find("li").not(":first").remove();

                        $.each(data, function (i, item) {
                           var title =JSON.parse(item.title);
                            $("#course").append(
                                $("<option>", {
                                    value: item.id,
                                    text: title[lang],
                                })
                            );

                            $(".offlineCourseSelect  .infix_ul_lists").append(' <li data-search-term="' + title[lang] + '">\n' +
                                '                        <label for="ms-opt-user-' + item.id + '">\n' +
                                '                            <span class="checkmark"></span>\n' +
                                '                            <input  type="checkbox" title="' + title[lang] + '" id="ms-opt-user-' + item.id + '" value="' + item.id + '"">' + title[lang] + '</label></li>');
                        });
                    },
                    error: function (data) {
                        console.log("Error:", data);
                    },
                });


            }

            function updateClassList() {

                var url = $("#url").val();

                var formData = {
                    category: $("#category option:selected").val(),
                    course: $("#course :selected").map(function (i, el) {
                        return $(el).val();
                    }).get(),
                    type: $("#type option:selected").val(),
                };

                $.ajax({
                    type: "GET",
                    data: formData,
                    dataType: "json",
                    url: url + "/" + "org-subscription/offline-classes",
                    success: function (data) {
                        $("#class").empty();
                        $(".offlineClassSelect .infix_ul_lists li").empty();
                        $(".offlineClassSelect .ms-options-wrap button span").text('Select');
                        let type = $("#type option:selected").val();

                        $("#class").find("option").not(":first").remove();
                        $("#class ul").find("li").not(":first").remove();

                        $.each(data, function (i, item) {
                            var title;
                            if(type=='offline'){
                                title =item.title;
                            }else{
                                title =item.title[lang];
                            }


                            $("#class").append(
                                $("<option>", {
                                    value: item.id,
                                    text: title,
                                })
                            );
                            $(".offlineClassSelect .infix_ul_lists").append(' <li data-search-term="' + title + '">\n' +
                                '                        <label for="ms-opt-user-class-' + item.id + '">\n' +
                                '                            <span class="checkmark"></span>\n' +
                                '                            <input  type="checkbox" title="' + title + '" id="ms-opt-user-class-' + item.id + '" value="' + item.id + '"">' + title + '</label></li>');


                        });


                    },
                    error: function (data) {
                        console.log("Error:", data);
                    },
                });
            }
        </script>
    @endpush
</div>
