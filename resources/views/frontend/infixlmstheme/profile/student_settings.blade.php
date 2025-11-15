@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('profile.profile')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/infixlmstheme/css/select2.min.css')}}{{assetVersion()}}" rel="stylesheet"/>
    <link href="{{asset('public/frontend/infixlmstheme/css/checkout.css')}}{{assetVersion()}}" rel="stylesheet"/>
    {{--    <link href="{{asset('public/frontend/infixlmstheme/css/myProfile.css')}}{{assetVersion()}}" rel="stylesheet"/>--}}
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/gijgo.min.css{{assetVersion()}}">
    <link rel="stylesheet"
          href="{{asset('Modules/Blog/Resources/views/assets/taginput/tagsinput.css')}}{{assetVersion()}}"/>
    <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/student_profile.css')}}{{assetVersion()}}">
    <style>
        .lmsSwitch_toggle input:checked + .slider {
            background: #e3e3e3;
        }

        .nice-select {
            border-radius: 100px !important;
            padding: 0 20px;
        }

        .nice-select::before {
            right: 20px;
        }

        html[dir=rtl] .nice-select::before {
            right: auto;
            left: 20px;
        }

    </style>

@endsection
@section('js')
    <!-- ajax setup -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name=_token]').attr('content')
            }
        });
    </script>
    <script src="{{ asset('public/frontend/infixlmstheme') }}/js/gijgo.min.js"></script>
    <!-- tag input css -->
    <script src="{{asset('public/frontend/infixlmstheme/js/select2.min.js')}}"></script>
    <script src="{{asset('public/backend/js/summernote-bs5.min.js')}}"></script>
    <!-- repeater js -->
    <script src="{{asset('public/modules/profile/repeater/repeater.js')}}"></script>
    <script src="{{asset('public/modules/profile/repeater/indicator-repeater.js')}}"></script>

    <!-- tag input plugin js -->
    <script src="{{asset('Modules/Blog/Resources/views/assets/taginput/tagsinput.js')}}"></script>
    <!-- education js -->
    <script src="{{asset('public/modules/profile/education.js')}}"></script>
    <!-- experience js -->
    <script src="{{asset('public/modules/profile/experience.js')}}"></script>
    <!-- skill js -->
    <script src="{{asset('public/modules/profile/skill.js')}}"></script>
    <script src="{{asset('public/modules/profile/common.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.primary_textarea4').summernote({
                codeviewFilter: true,
                codeviewIframeFilter: true,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen']],
                ],
                placeholder: 'Write here',
                tabsize: 2,
                tooltip: true,
                height: 200,
            });
            $(document).ready(function () {
                $('.note-toolbar').find('[data-toggle]').each(function () {
                    $(this).attr('data-bs-toggle', $(this).attr('data-toggle')).removeAttr('data-toggle');
                });
            });
            $(document).ready(function () {
                $('.note-modal').find('[data-dismiss]').each(function () {
                    $(this).attr('data-bs-dismiss', $(this).attr('data-dismiss')).removeAttr('data-dismiss');
                });
            });
            $(".toggle-password, .toggle-password2, .toggle-password3").click(function () {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            if ($('.datepicker').length > 0) {
                $('.datepicker').datepicker();
            }
        });
    </script>

    <script>

        (function ($) {
            "use strict";
            $(document).ready(function () {
                // delete modal show
                $(document).on('click', '.delete_item', function (event) {
                    event.preventDefault();
                    let href = $(this).attr('href');
                    $("#delete_confirm_btn").attr('href', href);
                    $('#deleteModal').modal('show');
                });
                // delete confirm
                $(document).on('click', '#delete_confirm_btn', function (event) {
                    event.preventDefault();
                    let url = $(this).attr('href');
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function (response) {
                            $('#deleteModal').modal('hide');

                            if (response.type && response.type === 'reload') {
                                toastr.success(response.msg, 'Success');
                                location.reload();
                            } else {
                                resetAfterChange(response.selector, response.response);
                                toastr.success(response.msg, 'Success');
                            }

                        },
                        error: function (response) {
                            $('#deleteModal').modal('hide');
                            toastr.error(response.responseJSON.error);
                        }
                    });

                });

                //after delete
                function resetAfterChange(selector, TableData) {
                    $(selector).html(TableData);
                }

                //payout account data
                financialAccountData();
                $(document).on('change', '#account_type', function (event) {
                    event.preventDefault();
                    financialAccountData();
                });

                function financialAccountData() {
                    let id = $('#account_type').val();
                    let url = $('#payout_account_type_change_route').val();
                    url = url.replace(':id', id);
                    if (id) {
                        $.ajax({
                            url: url,
                            type: "GET",
                            success: function (response) {
                                $('#payout_data_div').html(response);
                            },
                            error: function (response) {
                                toastr.error(response.responseJSON.error);
                            }
                        });
                    }
                }


                //active tab state
                $('a[data-bs-toggle="tab"]').on('show.bs.tab', function (e) {
                    localStorage.setItem('activeSettingsTab', $(e.target).attr('href'));
                });
                let activeSettingsTab = localStorage.getItem('activeSettingsTab');

                if (activeSettingsTab) {
                    $('a[href="' + activeSettingsTab + '"]').tab('show');
                }

                //onchange profile picture
                $(document).on('change', '#profile_picture', function () {
                    imageChangeWithFile($(this)[0], '#profile_picture_show');
                });

                //onchange cover photo
                $(document).on('change', '#cover_photo', function () {
                    imageChangeWithFile($(this)[0], '#cover_photo_show');
                });

                //city
                $('.cityList').select2({
                    ajax: {
                        url: '{{route('ajaxCounterCity')}}',
                        type: "GET",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                id: $('#state').find(':selected').val(),
                            }
                            return query;
                        },
                        cache: false
                    }
                });
                //state
                $('.stateList').select2({
                    ajax: {
                        url: '{{route('ajaxCounterState')}}',
                        type: "GET",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                id: $('#country').find(':selected').val(),
                            }
                            return query;
                        },
                        cache: false
                    }
                });

                //onchange country
                $(document).on('change', '#country', function () {
                    $('.stateList').val(null).trigger('change');
                    $('.cityList').val(null).trigger('change');
                });

                //onchange state
                $(document).on('change', '.stateList', function () {
                    $('.cityList').val(null).trigger('change');
                });

                //user document
                $(document).on('change', '#passport', function () {
                    showFileName($(this).val(), '#placeholderPassportName');
                    imageChangeWithFile($(this)[0], '#passport_show');
                });

                $(document).on('change', '#nid', function () {
                    showFileName($(this).val(), '#placeholderNidName');
                    imageChangeWithFile($(this)[0], '#nid_show');
                });

                $(document).on('click', '.document_add', function (event) {
                    event.preventDefault();
                    let itemNo = $(".document_items").find('.mt-repeater-row').length;
                    let selectRow = $(".document_item");
                    selectRow.find('.placeholder_field').last().prop('id', 'placeholderDocumentName_' + itemNo);
                    selectRow.find('.file_input_field').last().prop('id', 'document_' + itemNo);
                    selectRow.find('.document_show').last().prop('id', 'document_show_' + itemNo);
                    selectRow.find('.label_id').last().attr('for', 'document_' + itemNo);
                    selectRow.find('.placeholder_field').last().attr('data-id', itemNo);
                    selectRow.find('.file_input_field').last().attr('data-id', itemNo);
                    selectRow.find('.document_show').last().attr('data-id', itemNo);
                });

                $(document).on('change', '.file_input_field', function (event) {
                    event.preventDefault();
                    let id = $(this).data('id');
                    let ph = '#placeholderDocumentName_' + id;
                    let ps = '#document_show_' + id;
                    showFileName($('#document_' + id).val(), ph);
                    imageChangeWithFile($(this)[0], ps);
                });

                $(document).on('change', '.ex_file_input_field', function (event) {
                    event.preventDefault();
                    let id = $(this).data('id');
                    let ph = '#exPlaceholderDocumentName_' + id;
                    let ps = '#ex_document_show_' + id;
                    showFileName($('#ex_document_' + id).val(), ph);
                    imageChangeWithFile($(this)[0], ps);
                });


                //onchange image show function
                function imageChangeWithFile(input, srcId) {

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $(srcId)
                                .attr('src', e.target.result);
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }

                function showFileName(value, placeholder) {
                    if (value) {
                        var startIndex = (value.indexOf('\\') >= 0 ? value.lastIndexOf('\\') : value.lastIndexOf('/'));
                        var filename = value.substring(startIndex);
                        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                            filename = filename.substring(1);
                        }
                        $(placeholder).text('');
                        $(placeholder).text(filename);

                    }
                }

            });
        })(jQuery);
    </script>

    <script>
        $('.select2').select2();
    </script>
@endsection



@section('mainContent')

    <section class="main_content_iner main_content_padding">
        <div class="box_header">
            <div class="main-title align-items-center flex-wrap d-flex mb_30">
                <h3 class="mb-0 fw-bold">{{__('profile.profile_settings')}}</h3>
                <div class="d-flex align-items-center ms-auto  pe-0 pr-lg-4">
                    <p class="mb-0 me-2">{{ __('profile.active_offline_status') }}</p>
                    <label class="lmsSwitch_toggle d-flex align-items-center ms-auto" for="autoNext">
                        <input value="1" name="offline_status"
                               {{@$user->userInfo->offline_status?'checked':""}}  class="offline_status_change"
                               type="checkbox" id="autoNext">
                        <div class="slider round"></div>
                    </label>
                </div>
            </div>
        </div>
        <div class="profile p-0 m-0">
            <!-- tab link -->
            @include(theme('profile._tab_link'))
        </div>
        <div class="dashboard_lg_card">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">

                    </div>
                    <div class="col-lg-12">
                        <div class="white-box">
                            <div class="tab-content mt-20">
                                <!-- basic information -->
                                @include(theme('profile._basic_information_tab'))
                                <!-- change password tab -->
                                @include(theme('profile._change_password_tab'))
                                @if(isModuleActive('TwoFA') && Settings('enable_student_two_fa'))
                                    @include(theme('profile._2fa_tab'))
                                @endif
                                <!-- image tab -->
                                @include(theme('profile._images_tab'))
                                <!-- about tab -->
                                @include(theme('profile._about_tab'))
                                <!-- education tab -->
                                @include(theme('profile._education_tab'))
                                <!-- experience tab -->
                                @include(theme('profile._experience_tab'))
                                <!-- skills tab -->
                                @include(theme('profile._skills_tab'))
                                <!-- financial tab -->
                                @include(theme('profile._financial_tab'))
                                <!-- api tab -->
                                @include(theme('profile._api_tab'))
                                <!-- extra information tab -->
                                @include(theme('profile._extra_info_tab'))
                                <!-- identity & documents tab -->
                                @include(theme('profile._identity_tab'))
                                <!-- social & contact tab -->
                                @include(theme('profile._social_tab'))
                                <!-- delete account -->
                                @include(theme('profile._delete_account_tab'))


                            </div>
                        </div>
                    </div>
                    @include('backend.profile._route')
                    @include(theme('profile._delete_modal'))
                    @include(theme('profile._offline_message_modal'))
                    <div id="append_html"></div>

                </div>
            </div>
        </div>
    </section>

@endsection

