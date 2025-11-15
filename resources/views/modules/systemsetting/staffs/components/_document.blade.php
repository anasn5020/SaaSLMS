@extends('backend.master')

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.Document') }}</h3>
                            <ul class="d-flex">
                                <li><a class="primary-btn radius_30px   fix-gr-bg"
                                       href="{{route('updatePassword')}}">{{ __('common.Update Profile') }}</a></li>
                                @if(permissionCheck('staffs.resume'))
                                    <li><a class="primary-btn radius_30px   fix-gr-bg"
                                           href="{{route('staffs.resume')}}">{{ __('common.Resume') }}</a></li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="white-box">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('staffs.document.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12 mt-repeater no-extra-space">
                                    @if(count($documents) > 0)
                                        <strong>Existing Documents</strong>
                                        <hr>
                                        @foreach($documents as  $key => $document)
                                            <div class="row">
                                                <input type="hidden" name="existing_document_ids[]"
                                                       value="{{$document->id}}">
                                                <div class="col">
                                                    <div class="primary_input mb-25 position-relative">
                                                        <label class="primary_input_label"
                                                               for="name">{{__('common.Name') }} *</label>
                                                        <input value="{{$document->name}}"
                                                               name="name[{{$document->id}}]" id="name"
                                                               class="primary_input_field emp_name" placeholder="-"
                                                               type="text">
                                                        <span class="text-danger">{{$errors->first('name')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="primary_input mb-35">
                                                        <label class="primary_input_label"
                                                               for="">{{__('common.Choose File')}} *</label>
                                                        <div class="primary_file_uploader">
                                                            <input data-id="1" class="primary-input placeholder_field"
                                                                   type="text" id="c_placeholderFileOneName_{{$key}}_e"
                                                                   placeholder="{{__('setting.Browse file')}}"
                                                                   readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn label_id small fix-gr-bg"
                                                                       for="c_document_file_{{$key}}_e"> {{__('common.Browse')}}</label>
                                                                <input data-id="{{$key}}_e" type="file"
                                                                       class="d-none  file_input_field"
                                                                       name="file[{{$document->id}}]"
                                                                       id="c_document_file_{{$key}}_e">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger">{{$errors->first('file')}}</span>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="position-relative form-group">
                                                        <a href="/{{$document->documents}}"
                                                           download="{{fileNameShow($document->documents)}}"
                                                           class="primary-btn small icon-only fix-gr-bg mt-35">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <a data-id="{{$document->id}}" href="javascript:;"
                                                           class="primary-btn staff_document_delete small icon-only fix-gr-bg mt-35">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <strong>Add New Documents</strong>
                                    <hr>
                                    <div data-repeater-list="documents">
                                        <div data-repeater-item class="mt-repeater-item employee_item">
                                            <div class="mt-repeater-row">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="primary_input mb-25 position-relative">
                                                            <label class="primary_input_label"
                                                                   for="name">{{__('common.Name') }} *</label>
                                                            <input name="name" id="name"
                                                                   class="primary_input_field emp_name" placeholder="-"
                                                                   type="text">
                                                            <span class="text-danger">{{$errors->first('name')}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="primary_input mb-35">
                                                            <label class="primary_input_label"
                                                                   for="">{{__('common.Choose File')}} *</label>
                                                            <div class="primary_file_uploader">
                                                                <input data-id="1"
                                                                       class="primary-input placeholder_field"
                                                                       type="text" id="c_placeholderFileOneName_1"
                                                                       placeholder="{{__('setting.Browse file')}}"
                                                                       readonly="">
                                                                <button class="" type="button">
                                                                    <label class="primary-btn label_id small fix-gr-bg"
                                                                           for="c_document_file_1"> {{__('common.Browse')}}</label>
                                                                    <input data-id="1" type="file"
                                                                           class="d-none  file_input_field" name="file"
                                                                           id="c_document_file_1">
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <span class="text-danger">{{$errors->first('file')}}</span>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <div class="position-relative form-group">
                                                            <a href="javascript:;" data-repeater-delete
                                                               class="primary-btn small icon-only fix-gr-bg mt-35  mt-repeater-delete">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-offset-1 col-md-9">
                                        <a href="javascript:;" data-repeater-create
                                           class="primary-btn radius_30px document_add fix-gr-bg mt-repeater-add"><i
                                                class="fa fa-plus"></i>{{__('common.Add More')}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="submit_btn text-center ">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg"><i
                                            class="ti-check"></i>{{__("common.Save")}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <input type="hidden" value="{{route('staffs.document.remove',':id')}}" id="staff_document_remove_url">
@endsection
@push('scripts')
    <script src="{{asset('public/backend/js/repeater/repeater.js')}}"></script>
    <script src="{{asset('public/backend/js/repeater/indicator-repeater.js')}}"></script>
    <script src="{{asset('public/backend/js/staff_document.js')}}"></script>
@endpush
