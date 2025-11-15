<div class="main_content_iner main_content_padding">
    <style>

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
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('assignment.Assignment List')}}</h3>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        @if(count($assignment_list)==0)
                            <div class="col-12">
                                <div class="section__title3 margin_50">
                                    <p class="text-center">{{__('assignment.Assignment Not Found !')}}</p>
                                </div>
                            </div>
                        @else
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
                                            @if(isset($assignment_list))
                                                @foreach ($assignment_list as $key=>$assign)
                                                    @php
                                                        if (isModuleActive('Assignment')){
                                                            $submit_info=Modules\Assignment\Entities\InfixAssignAssignment::assignmentLastSubmitted($assign->id);

                                                        }elseif(isModuleActive('Homework')){
                                                             $submit_info=Modules\Homework\Entities\InfixAssignHomework::assignmentLastSubmitted($assign->id);
                                                        }else{
                                                            $submit_info=null;
                                                        }
                                                    @endphp
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
                                                            @if($submit_info)
                                                                @if ($assign->pass_status==1)
                                                                    {{__('homework.Pass')}}
                                                                @elseif($assign->pass_status==2)
                                                                    {{__('homework.Fail')}}
                                                                @else
                                                                    {{__('homework.Not Marked')}}
                                                                @endif
                                                            @else
                                                                {{__('homework.Not Submitted')}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($assign->assignmentSubmitted->count()>0)
                                                                <a class="link_value theme_btn small_btn4"
                                                                   data-bs-toggle="collapse"
                                                                   href="#collapseExample{{$assign->id}}" role="button"
                                                                   aria-expanded="false"
                                                                   aria-controls="collapseExample">
                                                                    {{__('assignment.History')}}
                                                                </a>
                                                            @endif
                                                            {{-- @if ($assign->pass_status!=1) --}}
                                                            <a href="{{route('myAssignment_details',$assign->id)}}"
                                                               class="link_value theme_btn small_btn4">{{__('common.Details')}}</a>
                                                        {{-- @endif --}}
                                                        <td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" style="border-bottom:0!important;">
                                                            <div class="collapse" id="collapseExample{{$assign->id}}">
                                                                <table class="table  mb-0">
                                                                    <tr>
                                                                        <td scope="col">{{__('common.SL')}}</td>
                                                                        <td scope="col">{{__('common.Date')}}</td>
                                                                        <td scope="col">{{__('assignment.Marks')}}</td>
                                                                        <td scope="col">{{__('common.View')}}</td>
                                                                    </tr>
                                                                    <tbody>
                                                                    @foreach ($assign->assignmentSubmitted as $key => $submitted)
                                                                        <tr>
                                                                            <td>
                                                                                {{$key+1}}
                                                                            </td>
                                                                            <td>
                                                                                {{showDate($submitted->created_at)}}
                                                                            </td>
                                                                            <td>
                                                                                {{@$submitted->marks}}
                                                                            </td>
                                                                            <td>
                                                                                <a data-bs-toggle="modal"
                                                                                   data-bs-target="#viewAttachment{{$submitted->id}}"
                                                                                   href="#"
                                                                                   class="link_value theme_btn small_btn4">{{__('common.View')}}</a>
                                                                            </td>
                                                                        </tr>
                                                                        @include(theme('pages.attachment_view'))
                                                                    @endforeach

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
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

                                                                <form action="{{route('submitAssignment')}}"
                                                                      method="Post" enctype="multipart/form-data">
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

                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        <div class="mt-4">
                                            {{ $assignment_list->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
