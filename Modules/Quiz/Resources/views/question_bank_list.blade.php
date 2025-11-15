@extends('backend.master')
@section('mainContent')
    <style>
        .select2-container {
            width: unset;
        }

        .select2-container--default .select2-selection--single {
            background-color: transparent;
            width: 100%;
            height: 46px;
            line-height: 46px;
            font-size: 13px;
            padding: 3px 20px;
            padding-left: 20px;
            font-weight: 300;
            border-radius: 4px;
            color: var(--dynamic-text-color);
            border: 1px solid var(--backend-border-color);
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
            position: absolute;
            top: 1px;
            right: 20px;
            width: 20px;
            color: var(--text-color);
        }

        .select2-dropdown {
            background-color: white;
            border: 1px solid var(--backend-border-color);
            border-radius: 4px;
            box-sizing: border-box;
            display: block;
            position: absolute;
            left: -100000px;
            width: 100%;
            width: 100%;
            background: var(--backend-main-bg);
            overflow: auto !important;
            border-radius: 0px 0px 10px 10px;
            margin-top: 1px;
            z-index: 9999 !important;
            border: 0;
            box-shadow: var(--selector-shadow);
            z-index: 1051;
            min-width: 200px;
        }

        .select2-search--dropdown .select2-search__field {
            padding: 4px;
            width: 100%;
            box-sizing: border-box;
            box-sizing: border-box;
            background-color: transparent;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
            border-radius: 3px;
            box-shadow: none;
            color: var(--theme-default-color);
            display: inline-block;
            vertical-align: middle;
            padding: 0px 8px;
            width: 100% !important;
            height: 46px;
            line-height: 46px;
            outline: 0 !important;
        }

        .select2-container {
            width: 100% !important;
            min-width: 90px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--dynamic-text-color);
            line-height: 40px;
        }

        .select2-container--default.select2-container--open.select2-container--below .select2-selection--single {
            border-radius: 10px 10px 0px 0px;
        }

        .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
            line-height: 35px;
            display: flex;
            align-items: center;
        }

        .groupList {
            height: 35px;
            display: flex;
            align-items: center;
        }

        /*span.select2-dropdown.select2-dropdown--below {*/
        /*    width: max-content !important;*/
        /*    max-width: max-content !important;*/
        /*}*/

        .select2-container--default .select2-results > .select2-results__options li {
            padding-right: 24px;
        }

        .select2-container--default .select2-results > .select2-results__options {
            max-height: 400px;
        }

        .select2-container--default .select2-results > .select2-results__options li {
            padding-right: 0;
            white-space: normal;
            line-height: 1.5;
            height: auto;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .min_width_300 {
            min-width: 300px;
        }

        .primary_checkbox {
            display: flex;
            align-items: center;
        }
    </style>
    {!! generateBreadcrumb() !!}
    @if(!isModuleActive('AdvanceQuiz'))
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box mb-30">
                    <form method="GET" action="" class="form-horizontal" id="search_group">
                    <div class="row">

                        <div class="col-lg-4 mt-30-md md_mb_20">
                            <label class="primary_input_label" for="category_id">{{__('quiz.Group')}}</label>
                            <select class="primary_select "
                                    id="group" name="group">
                                <option data-display=" {{__('common.Select')}}" value=""> {{__('quiz.Group')}}
                                </option>
                                @foreach($groups as $g)
                                    <option value="{{$g->id}}" {{$group==$g->id?'selected':''}}>{{$g->title}}</option>
                                @endforeach
                            </select>

                        </div>


                        <div class="col-lg-12 mt-100-md md_mb_20 mt-2">
                            <label class="primary_input_label" for=""  ></label>
                            <button type="submit" class="primary-btn   fix-gr-bg">
                                <span class="ti-search pe-2"></span>
                                {{__('quiz.Search')}}
                            </button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    @endif
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="white-box">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title d-flex align-items-center justify-content-between mb-3">
                            <h3 class="mb-20" id="page_title">{{__('quiz.Question Bank List')}}</h3>
                            @if(isModuleActive('AdvanceQuiz'))
                                <div class="filter">
                                    <ul class="d-flex float-end gap-10">
                                        <li class="pe-3">
                                            <input placeholder="{{__('common.Search')}}" type="text" id="tableSearch"
                                                   class="primary_input_field height_px_35 me-2">
                                        </li>
                                        <li class="min_width_300 me-3 ">

                                            <select class="select2  groupList" name="group" id="group">
                                                <option
                                                    data-display="{{__('common.Select')}} {{__('quiz.Group')}}"
                                                    value="">{{__('common.Select')}} {{__('quiz.Group')}} </option>
                                                @foreach($groups->where('parent_id',0) as $group)
                                                    @include('advancequiz::group._single_select_option_id',['group'=>$group,'level'=>1])
                                                @endforeach
                                            </select>
                                        </li>
                                        @if(permissionCheck('question-bank'))
                                            <li>
                                                <a class="primary-btn radius_30px fix-gr-bg"
                                                   href="{{route('question-bank')}}">
                                                    <i class="ti-plus"></i>{{__('common.Add')}} {{__('quiz.Question')}}
                                                </a>
                                            </li>
                                        @endif
                                        @if(permissionCheck('question-bank-bulk'))
                                            <li>

                                                <a class="primary-btn radius_30px fix-gr-bg"
                                                   href="{{route('question-bank-bulk')}}"><i
                                                        class="ti-plus"></i>{{__('common.Import')}}
                                                </a>
                                            </li>
                                        @endif
                                        @if(permissionCheck('quiz.question-bank-export'))
                                            <li>
                                                <div class="d-flex align-content-lg-end">
                                                    <a class="primary-btn radius_30px fix-gr-bg"
                                                       href="{{route('quiz.question-bank-export')}}"><i
                                                            class="ti-download"></i>{{__('common.Export')}}
                                                    </a>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>


                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table">

                                <div class="">
                                    <table id="question_table" class="table Crm_table_active3 quiz-bank-checkbox">
                                        <thead>

                                        <tr>
                                            <th>
                                                <div class="d-flex items-center">

                                                    <label class=" primary_checkbox  "
                                                           for="questionSelectAll">
                                                        <input type="checkbox"
                                                               id="questionSelectAll"
                                                               class="common-checkbox selectAllQuizQuestion">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <a href="#" id="deleteAllBtn"
                                                       style="display: none;    margin-top: -5px;"
                                                       class="primary-btn small fix-gr-bg ms-2">
                                                        <span class="ti-trash"></span>
                                                    </a>
                                                </div>
                                            </th>
                                            <th>{{__('common.SL')}}</th>
                                            <th>{{__('quiz.Group')}}</th>
                                            <th>{{__('quiz.Question')}}</th>
                                            <th>{{__('common.Type')}}</th>
                                            @if(isModuleActive('AdvanceQuiz'))
                                                <th>{{__('common.Level')}}</th>
                                            @endif
                                            <th>{{__('quiz.Image')}}</th>
                                            <th>{{__('common.Action')}}</th>
                                        </tr>
                                        </thead>


                                        <tbody>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade admin-query" id="deleteBank">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Delete')}} </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('question-bank-delete')}}" method="post">
                        @csrf

                        <div class="text-center">

                            <h4>{{__('common.Are you sure to delete ?')}} </h4>
                        </div>
                        <input type="hidden" name="id" value="" id="classQusId">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button class="primary-btn fix-gr-bg"
                                    type="submit">{{__('common.Delete')}}</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade admin-query" id="deleteBankWarring">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Warring')}} </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <div class="text-center">

                        <h4>{{__('quiz.You cannot delete this question because it has been used in')}} <span
                                id="totalAssignQus"></span> {{__('quiz.quiz already')}} </h4>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade admin-query" id="deleteAllBank">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Delete')}} </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('question-bank-bulk-delete')}}" method="post">
                        @csrf

                        <div class="text-center">
                            <h4>{{__('common.Are you sure to delete ?')}} </h4>
                        </div>
                        <input type="hidden" name="questions" value="" id="qusList">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button class="primary-btn fix-gr-bg"
                                    type="submit">{{__('common.Delete')}}</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        //
        @if(isModuleActive('AdvanceQuiz'))
        $('.groupList').select2();
        @endif

        $("#question_table").on("change", ".question", function () {
            qusIsCheck();
        });

        function qusIsCheck() {
            if ($("#question_table input:checkbox:checked").length > 0) {
                $('#deleteAllBtn').show();
            } else {
                $('#deleteAllBtn').hide();

            }
        }

        var questions = [];

        $('#deleteAllBtn').click(function (e) {
            e.preventDefault();
            $('#qusList').val('');

            $('#question_table input:checkbox').each(function () {
                if (this.checked) {
                    questions.push($(this).val());
                }

            });
            $('#qusList').val(questions.toString());
            $('#deleteAllBank').modal('show');
        });
    </script>

    @php
        $url = route('getAllQuizData').'?group='.request('group');
    @endphp

    <script>

        dataTableOptions.dom = '{{isModuleActive('AdvanceQuiz')?'rtip':'Blfrtip'}}',

            dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.ajax = {
            url: '{!! $url !!}',
            data: function (d) {
                d.group = $('.groupList').val();
            }
        };
        dataTableOptions.columns = [
            {data: 'delete_btn', name: 'delete_btn', orderable: false, searchable: false},
            {data: 'DT_RowIndex', name: 'id', orderable: true},

            {data: 'questionGroup_title', name: 'questionGroup.title'},
            {data: 'question', name: 'question'},
            {data: 'type', name: 'type'},
                @if(isModuleActive('AdvanceQuiz'))
            {
                data: 'level_title', name: 'level_title',
            },
                @endif
            {
                data: 'image', name: 'image', orderable: false
            },
            {data: 'action', name: 'action', orderable: false},

        ]

        @if(isModuleActive('AdvanceQuiz'))
            dataTableOptions = updateColumnExportOption(dataTableOptions, [1, 2, 3, 4, 5]);

        @else
            dataTableOptions = updateColumnExportOption(dataTableOptions, [1, 2, 3, 4]);
        @endif


        let table = $('#question_table').DataTable(dataTableOptions);


        $(document).on('input', '#tableSearch', function () {
            table.search($(this).val()).draw();
        });

        $(document).on('change', '.groupList ', function () {
            table.ajax.reload();
        });
        $(document).on('click', '.deleteQuiz_bank', function () {
            let id = $(this).data('id');
            let total = $(this).data('total');
            if (total == 0) {
                $('#classQusId').val(id);
                $("#deleteBank").modal('show');
            } else {
                $("#totalAssignQus").text(total);
                $("#deleteBankWarring").modal('show');

            }

        });


        $(document).on('click', '.selectAllQuizQuestion', function () {
            if ($(this).is(':checked') == true) {

                table.rows().nodes().to$().find('input[type="checkbox"].question').each(function () {
                    $(this).prop('checked', true);
                });
            } else {
                table.rows().nodes().to$().find('input[type="checkbox"].question').each(function () {
                    $(this).prop('checked', false);

                });
            }
            qusIsCheck();
        });
    </script>
    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/course.js"></script>
@endpush
