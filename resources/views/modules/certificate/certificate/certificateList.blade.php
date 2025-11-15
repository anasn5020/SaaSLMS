<div class="QA_section QA_section_heading_custom check_box_table">
    <div class="QA_table">
        <!-- table-responsive -->
        <div class="">
            <table id="lms_table" class="table Crm_table_active3">
                <thead>
                @if(session()->has('message-success-delete') != "" ||
                session()->get('message-danger-delete') != "")
                    <tr>
                        <td colspan="5">
                            @if(session()->has('message-success-delete'))
                                <div class="alert alert-success">
                                    {{ session()->get('message-success-delete') }}
                                </div>
                            @elseif(session()->has('message-danger-delete'))
                                <div class="alert alert-danger">
                                    {{ session()->get('message-danger-delete') }}
                                </div>
                            @endif
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>{{__('common.SL')}}</th>
                    <th>{{__('certificate.Title')}}</th>
                    <th>{{__('certificate.Body')}}</th>
                    <th>{{__('certificate.Default For')}}</th>
                    @if(isModuleActive('CPD') || isModuleActive('Membership'))
                        <th>{{__('common.Type')}}</th>
                    @endif
                    <th>{{__('common.Action')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($certificates as $key=>$certificate)
                    <tr>
                        <td>{{translatedNumber(++$key)}}</td>
                        <td>{{$certificate->title}} </td>
                        <td>{{$certificate->body}}</td>
                        <td>
                            <button type="button" class="primary-btn small fix-gr-bg text-nowrap">
                                @if($certificate->for_course == 1)
                                    {{__('certificate.Course')}}
                                @elseif($certificate->for_quiz == 1)
                                    {{__('certificate.Quiz')}}
                                @elseif($certificate->for_class == 1)
                                    {{__('certificate.Live Class')}}
                                @elseif(isModuleActive('CPD') && $certificate->for_cpd==1 )
                                    {{__('cpd.CPD')}}
                                @elseif(isModuleActive('Membership') && $certificate->is_membership==1 )
                                    {{__('membership.Membership')}}
                                @else
                                    {{__('common.N/A')}}
                                @endif
                            </button>
                        </td>
                        @if(isModuleActive('CPD') || isModuleActive('Membership'))
                            <td>{{ $certificate->type ? strtoupper($certificate->type) : strtoupper('course')}}</td>
                        @endif
                        <td>
                            <div class="dropdown CRM_dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenu2" data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                    {{ __('common.Select') }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right"
                                     aria-labelledby="dropdownMenu2">
                                    <a class="dropdown-item edit_brand" target="_blank"
                                       href="{{route('certificate.view',$certificate->id)}}">{{__('common.View')}} </a>
                                    <a class="dropdown-item edit_brand"
                                       href="{{route('certificate.download',$certificate->id)}}">{{__('common.Download')}}</a>
                                    @if(isModuleActive('CPD') || isModuleActive('Membership'))
                                        @if(isModuleActive('CPD') && $certificate->type == 'cpd')
                                            @if($certificate->for_cpd == 0)
                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                   data-bs-target="#cpd_certificate{{$certificate->id}}"
                                                   href="#">{{__('certificate.Make Default')}}
                                                    ({{__('cpd.cpd')}})</a>
                                            @endif
                                        @endif
                                        @if(isModuleActive('Membership') && $certificate->type == 'membership')
                                            @if($certificate->is_membership == 0 ||$certificate->is_membership == null)
                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                   data-bs-target="#membership_certificate{{$certificate->id}}"
                                                   href="#">{{__('certificate.Make Default')}}
                                                    ({{__('membership.Membership')}})</a>
                                            @endif
                                        @endif

                                        @if($certificate->type == 'course' || $certificate->typ == null)
                                            @if($certificate->for_course == 0)
                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                   data-bs-target="#course_certificate{{$certificate->id}}"
                                                   href="#">{{__('certificate.Make Default')}}
                                                    ({{__('certificate.Course')}})</a>
                                            @endif
                                            @if($certificate->for_quiz == 0)
                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                   data-bs-target="#quiz_certificate{{$certificate->id}}"
                                                   href="#">{{__('certificate.Make Default')}}
                                                    ({{__('certificate.Quiz')}})</a>
                                            @endif
                                            @if($certificate->for_class == 0)
                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                   data-bs-target="#class_certificate{{$certificate->id}}"
                                                   href="#">{{__('certificate.Make Default')}}
                                                    ({{__('certificate.Live Class')}})</a>
                                            @endif
                                        @endif
                                    @else
                                        @if($certificate->for_course == 0)
                                            <a class="dropdown-item" data-bs-toggle="modal"
                                               data-bs-target="#course_certificate{{$certificate->id}}"
                                               href="#">{{__('certificate.Make Default')}}
                                                ({{__('certificate.Course')}})</a>
                                        @endif
                                        @if($certificate->for_quiz == 0)
                                            <a class="dropdown-item" data-bs-toggle="modal"
                                               data-bs-target="#quiz_certificate{{$certificate->id}}"
                                               href="#">{{__('certificate.Make Default')}}
                                                ({{__('certificate.Quiz')}})</a>
                                        @endif
                                        @if($certificate->for_class == 0)
                                            <a class="dropdown-item" data-bs-toggle="modal"
                                               data-bs-target="#class_certificate{{$certificate->id}}"
                                               href="#">{{__('certificate.Make Default')}}
                                                ({{__('certificate.Live Class')}})</a>
                                        @endif

                                    @endif
                                    @if (permissionCheck('certificate.edit'))
                                        <a class="dropdown-item edit_brand"
                                           href="{{route('certificate.edit', [$certificate->id])}}">{{__('common.Edit')}}</a>
                                    @endif
                                    @if (permissionCheck('certificate.delete'))
                                        <a class="dropdown-item" data-bs-toggle="modal"
                                           data-bs-target="#certificate_delete{{$certificate->id}}"
                                           href="#">{{__('common.Delete')}}</a>
                                    @endif
                                    @if (permissionCheck('certificate.clone'))
                                        <a class="dropdown-item edit_brand"
                                           href="{{route('certificate.clone', [$certificate->id])}}">{{__('common.Clone')}}</a>
                                    @endif

                                </div>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade admin-query"
                         id="certificate_delete{{$certificate->id}}">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('common.Delete')}} {{__('certificate.Certificate')}}</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <h4> {{__('common.Are you sure to delete ?')}}</h4>
                                    </div>
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                                        <form method="POST" action="{{ route('certificate.destroy', $certificate->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('DELETE')
                                            <button class="primary-btn fix-gr-bg"
                                                type="submit">{{__('common.Delete')}}</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade admin-query"
                         id="course_certificate{{$certificate->id}}">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('certificate.Default for Course')}}</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <h4> {{__('certificate.Are you sure')}}?</h4>
                                    </div>
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                                        <form method="POST" action="{{ route('course.certificate.update', $certificate->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            <button class="primary-btn fix-gr-bg"
                                                type="submit">{{__('certificate.Make Default')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade admin-query"
                         id="quiz_certificate{{$certificate->id}}">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('certificate.Default for Quiz')}}</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <h4> {{__('certificate.Are you sure')}}?</h4>
                                    </div>
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                                        <form method="POST" action="{{ route('quiz.certificate.update', $certificate->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            <button class="primary-btn fix-gr-bg"
                                                type="submit">{{__('certificate.Make Default')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade admin-query"
                         id="class_certificate{{$certificate->id}}">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('certificate.Default for Live Class')}}</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <h4> {{__('certificate.Are you sure')}}?</h4>
                                    </div>
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                                        <form method="POST" action="{{ route('class.certificate.update', $certificate->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            <button class="primary-btn fix-gr-bg"
                                                type="submit">{{__('certificate.Make Default')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(isModuleActive('CPD'))
                        <div class="modal fade admin-query"
                             id="cpd_certificate{{$certificate->id}}">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{__('cpd.Default for CPD')}}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                                class="ti-close "></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <h4> {{__('certificate.Are you sure')}}?</h4>
                                        </div>
                                        <div class="mt-40 d-flex justify-content-between">
                                            <button type="button" class="primary-btn tr-bg"
                                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                                            <form method="POST" action="{{ route('cpd.certificate.update', $certificate->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                <button class="primary-btn fix-gr-bg"
                                                    type="submit">{{__('certificate.Make Default')}}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isModuleActive('Membership'))
                        <div class="modal fade admin-query"
                             id="membership_certificate{{$certificate->id}}">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{__('membership.Default for Membership')}}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                                class="ti-close "></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <h4> {{__('certificate.Are you sure')}}?</h4>
                                        </div>
                                        <div class="mt-40 d-flex justify-content-between">
                                            <button type="button" class="primary-btn tr-bg"
                                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                                            <form method="POST" action="{{ route('membership.certificate.update', $certificate->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                <button class="primary-btn fix-gr-bg"
                                                    type="submit">{{__('certificate.Make Default')}}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
