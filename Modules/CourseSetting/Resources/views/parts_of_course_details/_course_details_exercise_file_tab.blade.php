<div class="">
    <div class="row mb_20 mt-20">
        <div class="col-lg-2">

            <ul class="d-flex">
                <li><a data-bs-toggle="modal" data-bs-target="#addFile"
                       class="primary-btn radius_30px  fix-gr-bg" href="#"><i
                            class="ti-plus"></i>{{__('common.Add')}} {{__('common.File')}}
                    </a></li>
            </ul>
        </div>
    </div>

    <div class="modal fade admin-query" id="addFile">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Add')}} {{__('courses.Exercise')}} {{__('common.File')}}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('saveFile')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{@$course->id}}">

                        <x-upload-file
                            name="file"
                            required="true"
                           label="{{ __('common.File') }}"
                        />


                        <div class="row">
                            <div class="col-xl-12 mt-20">
                                <div class="primary_input">
                                    {{-- <label class="primary_input_label mt-1" for=""> {{__('common.Name')}} </label> --}}
                                    <input class="primary_input_field"
                                           name="fileName" value="" required
                                           placeholder="{{__('common.File')}} {{__('common.Name')}} *"
                                           type="text">
                                </div>
                            </div>
                            <div class="col-12">
                                <select class="primary_select  mt-20"
                                        name="status"
                                        id="">
                                    <option
                                        data-display="{{__('common.Select')}} {{__('common.Status')}}"
                                        value="">{{__('common.Select')}} {{__('common.Status')}} </option>
                                    <option
                                        value="1"
                                        selected>{{__('courses.Active')}}</option>
                                    <option
                                        value="0">{{__('courses.Pending')}}</option>
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <select
                                    class="primary_select"
                                    name="lock" id="">
                                    <option
                                        data-display="{{__('common.Select')}} {{__('courses.Privacy')}}"
                                        value="">{{__('common.Select')}} {{__('courses.Privacy')}} </option>
                                    <option value="0"
                                    >{{__('courses.Unlock')}}</option>
                                    <option value="1"
                                            selected>{{__('courses.Locked')}}</option>

                                </select>
                            </div>
                            <div class="col-12">
                                <div
                                    class="mt-40 d-flex justify-content-between">
                                    <button type="button"
                                            class="primary-btn tr-bg"
                                            data-bs-dismiss="modal"> {{__('common.Cancel')}} </button>
                                    <button class="primary-btn fix-gr-bg"
                                            type="submit"><i
                                            class="ti-check"></i> {{__('common.Add')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div
        class="QA_section QA_section_heading_custom check_box_table hide_btn_tab overflow-hidden pt-3">
        <div class="QA_table ">
            <!-- table-responsive -->
            <div class="">
                <table id="lms_table"  class="table table-data">

                    <thead>
                    <tr>
                        <th scope="col">{{ __('common.SL') }}</th>
                        <th scope="col">{{__('common.Name')}}</th>
                        <th scope="col">{{ __('common.Download') }}</th>
                        <th scope="col">{{ __('common.Status') }}</th>
                        <th scope="col">{{ __('common.Privacy') }}</th>
                        <th scope="col">{{ __('common.Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($course_exercises)==0)
                        <tr>
                            <td colspan="4"
                                class="text-center">{{__('courses.No Data Found')}}</td>
                        </tr>
                    @endif
                    @foreach($course_exercises as $key => $exercise_file)
                        <tr>
                            <th>{{ $key+1 }}</th>

                            <td>{{@$exercise_file->fileName }}</td>
                            <td>

                                @if (file_exists($exercise_file->file))

                                    <a style="font-weight: 460"
                                       href="{{route('download_course_file',[$exercise_file->id])}}">{{ __('common.Click To Download') }}</a>

                                @else
                                    {{__('common.File Not Found')}}
                                @endif
                            </td>
                            <td>
                                {{$exercise_file->status==1?__('common.Active'):__('common.Inactive')}}
                            </td>
                            <td>
                                {{$exercise_file->lock==1?__('common.Locked'):__('common.Unlock')}}

                            </td>
                            <td>
                                <!-- shortby  -->
                                <div class="dropdown CRM_dropdown">
                                    <button
                                        class="btn btn-secondary dropdown-toggle"
                                        type="button"
                                        id="dropdownMenu2"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ __('common.Select') }}
                                    </button>
                                    <div
                                        class="dropdown-menu dropdown-menu-right "
                                        aria-labelledby="dropdownMenu2">
                                        <a class="dropdown-item btn-modal"
                                           data-container="#commonModal" type="button"
                                           href="{{route('updateFileAjax',$exercise_file->id)}}"


                                        >{{__('common.Edit')}}</a>
                                        <a class="dropdown-item"
                                           data-bs-toggle="modal"
                                           data-bs-target="#deleteQuestionGroupModal{{$exercise_file->id}}"
                                           href="#">{{__('common.Delete')}}</a>
                                    </div>
                                </div>
                                <!-- shortby  -->
                            </td>
                        </tr>


                        <div class="modal fade admin-query"
                             id="deleteQuestionGroupModal{{$exercise_file->id}}">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{__('common.Delete')}} {{ __('courses.Exercise') }} {{ __('common.File') }}</h4>
                                        <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"><i
                                                class="ti-close "></i></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="text-center">
                                            <h4> {{__('common.Are you sure to delete ?')}}</h4>
                                        </div>

                                        <div
                                            class="mt-40 d-flex justify-content-between">
                                            <button type="button"
                                                    class="primary-btn tr-bg"
                                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                                            <form method="POST" action="{{ route('deleteFile') }}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id"
                                                       value="{{$exercise_file->id}}">
                                                <button
                                                    class="primary-btn fix-gr-bg"
                                                    type="submit">{{__('common.Delete')}}</button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="application/javascript">
        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4]);
        let table = $('#lms_table').DataTable(dataTableOptions);
    </script>
@endpush
