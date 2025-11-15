<div>
    <style>
        .pb_50 {
            padding-bottom: 50px;
        }

        .cs_modal .modal-body input, .cs_modal .modal-body .nice_Select {
            height: 60px;
            line-height: 50px;
            padding: 0px 22px;
            border: 1px solid #F1F3F5;
            color: #707070;
            font-size: 14px;
            font-weight: 500;
            background-color: #fff;
            width: 100%;
        }

        .modal_1000px {
            max-width: 1000px;
        }
    </style>


    <div class="main_content_iner main_content_padding">
        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="row">
                    <div class="col-12">
                        <div class="p-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section__title3 mb_40">
                                        <h3 class="mb-0">{{_trans('homework.Homework List')}}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table custom_table3 mb-0">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('common.SL')}}</th>
                                                <th scope="col">{{__('common.Date')}}</th>
                                                <th scope="col">{{__('common.Title')}}</th>
                                                <th scope="col">{{__('common.Course')}}</th>
                                                <th scope="col">{{__('assignment.Marks')}}</th>
                                                <th scope="col">{{__('common.Status')}}</th>
                                                <th scope="col" style="text-align: center">{{__('common.Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @forelse ($homework_list as $key=>$assign)

                                                <tr>
                                                    <td scope="row">{{@$key+1}}</td>

                                                    <td>{{ showDate($assign->assignment->last_date_submission) }}</td>

                                                    <td>
                                                        {{@$assign->assignment->title}}

                                                    </td>
                                                    <td>
                                                        {{@$assign->assignment->course->title}}

                                                    </td>
                                                    <td>
                                                        {{@$assign->obtain_marks}}

                                                    </td>
                                                    <td>
                                                        @if ($assign->pass_status==1)
                                                            {{__('common.Pass')}}
                                                        @elseif($assign->pass_status==2)
                                                            {{__('common.Fail')}}
                                                        @else
                                                            ...
                                                        @endif

                                                    </td>
                                                    <td>
                                                        <a href="{{route('myHomework_details',$assign->id)}}"
                                                           class="link_value theme_btn small_btn4">{{__('common.Details')}}</a>

                                                    <td>

                                                </tr>


                                                <div class="modal cs_modal fade admin-query"
                                                     id="addAssignment{{$assign->id}}" role="dialog">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{__('assignment.Upload')}} {{__('assignment.Assignment')}} </h5>
                                                                <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"><i
                                                                        class="ti-close "></i></button>
                                                            </div>

                                                            <form action="{{route('submitHomework')}}" method="Post"
                                                                  enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="assignment_id"
                                                                           value="{{$assign->assignment->id}}">
                                                                    <input type="hidden" name="assign_id"
                                                                           value="{{$assign->id}}">
                                                                    <div class="col-12">
                                                                        <div class="preview_upload">
                                                                            <div
                                                                                class="preview_upload_thumb d-none">
                                                                                <img src="" alt="" id="imgPreview"
                                                                                     style=" display:none;height: 100%;width: 100%;">
                                                                                <span
                                                                                    id="previewTxt">{{__('assignment.Assignment')}} {{__('assignment.Upload')}}</span>
                                                                            </div>
                                                                            <div class="preview_drag">
                                                                                <div class="preview_drag_inner">
                                                                                    <div class="chose_file">
                                                                                        <input type="file"
                                                                                               name="attached_file"
                                                                                               id="imgInp">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-center">
                                                                    <div
                                                                        class="mt-40 d-flex justify-content-between">
                                                                        <button type="button"
                                                                                class="theme_line_btn me-2"
                                                                                data-bs-dismiss="modal">{{ __('common.Cancel') }}
                                                                        </button>
                                                                        <button class="theme_btn "
                                                                                type="submit">{{ __('common.Submit') }}</button>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <tr>
                                                    <td colspan="7">
                                                        <p class="text-center">{{__('homework.Homework Not Found !')}}</p>
                                                    </td>
                                                </tr>
                                            @endforelse

                                            </tbody>
                                        </table>
                                        <div class="mt-4">
                                            {{ $homework_list->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
