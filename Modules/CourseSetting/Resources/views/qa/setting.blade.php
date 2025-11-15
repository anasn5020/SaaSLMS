@extends('backend.master')

@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">

                            <form class="form-horizontal" method="POST" action="{{ route('qa.setting') }}" enctype="multipart/form-data">
                                @csrf

                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-12  ">
                                            <div class="primary_input">
                                                <div class="row">
                                                    <div class="col-md-4 ">
                                                        <div class="primary_input">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('courses.Assign question answerers') }}</label>
                                                            <select name="assign_question_answerers_role"
                                                                    class="primary_select ">
                                                                <option
                                                                    value="">{{__("common.Select")}} {{__("common.Role")}}</option>
                                                                @foreach($roles as $role)
                                                                    <option
                                                                        value="{{$role->id}}" {{Settings('assign_question_answerers_role')==$role->id ? 'selected' : ''}}>{{$role->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 ">
                                                        <div class="  ">
                                                            <p>{{ __('courses.Real time update') }}</p>


                                                            <div class="d-flex    mt-3">
                                                                <div class="d-flex mr-20">

                                                                    <label class="primary_checkbox d-flex mr-12 ">
                                                                        <input class="real_time_qa_upda"
                                                                               name="real_time_qa_update"
                                                                               type="radio" id="real_time_qa_update_yes"
                                                                               value="1"
                                                                            {{ Settings('real_time_qa_update') == '1' ? 'checked' : ''}}
                                                                        >
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <label class=" "
                                                                           for="real_time_qa_update_yes">@lang('common.Yes')</label>


                                                                </div>
                                                                <div class="d-flex mr-20">
                                                                    <label class="primary_checkbox d-flex mr-12 ">
                                                                        <input class="real_time_qa_upda"
                                                                               name="real_time_qa_update"
                                                                               type="radio" id="real_time_qa_update_no"
                                                                               value="0"
                                                                            {{ Settings('real_time_qa_update') != '1' ? 'checked' : ''}} >
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <label class=" "
                                                                           for="real_time_qa_update_no">@lang('common.No')</label>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div
                                                    class="row {{Settings('real_time_qa_update')==1?'':'d-none'}} mt-3 "
                                                    id="pusher">
                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('setting.pusher_app_id') }}</label>
                                                            <input class="primary_input_field" placeholder="-"
                                                                   type="text"
                                                                   name="pusher_app_id"
                                                                   value="{{ env('PUSHER_APP_ID') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('setting.pusher_app_key') }}</label>
                                                            <input class="primary_input_field" placeholder="-"
                                                                   type="text"
                                                                   name="pusher_app_key"
                                                                   value="{{ env('PUSHER_APP_KEY') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('setting.pusher_app_secret') }}</label>
                                                            <input class="primary_input_field" placeholder="-"
                                                                   type="text"
                                                                   name="pusher_app_secret"
                                                                   value="{{ env('PUSHER_APP_SECRET') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('setting.pusher_app_cluster') }}</label>
                                                            <input class="primary_input_field" placeholder="-"
                                                                   type="text"
                                                                   name="pusher_app_cluster"
                                                                   value="{{ env('PUSHER_APP_CLUSTER') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row ">
                                        <div class="submit_btn d-flex justify-content-center align-items-center">
                                            <button type="submit" class="primary-btn fix-gr-bg  "
                                                    data-bs-toggle="tooltip"><i
                                                    class="ti-check"></i> {{__('common.Update')}}</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        $(document).ready(function () {
            let pusherEl = $('#pusher');

            $(document).on('click', '.real_time_qa_update', function () {
                let method = $('input[name="real_time_qa_update"]:checked').val();

                console.log(method)
                if (method == '1') {
                    pusherEl.removeClass('d-none');
                } else {
                    pusherEl.addClass('d-none');

                }
            })

        });
    </script>
@endpush
