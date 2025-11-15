@extends('backend.master')
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <div class="white-box mb_30 ">
                        <form action="{{route('course.setting')}}" method="post" id="coupon-form"
                              name="coupon-form" enctype="multipart/form-data">

                            @csrf


                            <div class="row">

                                <div class="col-xl-4">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="show_seek_bar">{{__('setting.Show SeekBar In Player')}}  </label>
                                        <select class="primary_select mb-25" name="show_seek_bar"
                                                id="show_seek_bar">

                                            <option value="0"
                                                    @if (Settings('show_seek_bar') != 1) selected @endif>   {{__('common.No')}}
                                            </option>
                                            <option value="1"
                                                    @if (Settings('show_seek_bar') == 1) selected @endif>   {{__('common.Yes')}}
                                            </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="show_drip">{{ __('common.Drip Content') }}</label>
                                        <select class="primary_select mb-25" name="show_drip" id="show_drip">
                                            <option value="0"
                                                    @if (Settings('show_drip') != 1) selected @endif>{{ __('common.Show All') }}</option>
                                            <option value="1"
                                                    @if (Settings('show_drip') == 1) selected @endif>{{ __('common.Show After Unlock') }}</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-xl-4">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="course_approve">{{__('setting.Course Approval By Admin')}}  </label>
                                        <select class="primary_select mb-25" name="course_approval"
                                                id="course_approval">
                                            <option value="1"
                                                    @if (Settings('course_approval') == 1) selected @endif>   {{__('common.Yes')}}
                                            </option>

                                            <option value="0"
                                                    @if (Settings('course_approval') != 1) selected @endif>   {{__('common.No')}}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                @if(currentTheme()!='tvt')
                                    <div class="col-xl-4">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="hide_blog_comment">{{__('setting.Hide QA Section')}}  </label>
                                            <select class="primary_select mb-25" name="hide_qa_section"
                                                    id="hide_qa_section">

                                                <option value="0"
                                                        @if (Settings('hide_qa_section') != 1) selected @endif>   {{__('common.No')}}
                                                </option>
                                                <option value="1"
                                                        @if (Settings('hide_qa_section') == 1) selected @endif>   {{__('common.Yes')}}
                                                </option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="hide_review_section">{{__('setting.Hide Review Section')}}  </label>
                                            <select class="primary_select mb-25" name="hide_review_section"
                                                    id="hide_qa_section">

                                                <option value="0"
                                                        @if (Settings('hide_review_section') != 1) selected @endif>   {{__('common.No')}}
                                                </option>
                                                <option value="1"
                                                        @if (Settings('hide_review_section') == 1) selected @endif>   {{__('common.Yes')}}
                                                </option>

                                            </select>
                                        </div>
                                    </div>

                                @endif

{{--                                <div class="col-xl-4">--}}
{{--                                    <div class="primary_input mb-25">--}}
{{--                                        <label class="primary_input_label"--}}
{{--                                               for="mobile_app_only_mode">{{__('setting.Youtube Default Player')}}  </label>--}}
{{--                                        <select class="primary_select mb-25" name="youtube_default_player"--}}
{{--                                                id="youtube_default_player">--}}

{{--                                            <option value="0"--}}
{{--                                                    @if (Settings('youtube_default_player') != 1) selected @endif>   {{__('common.No')}}--}}
{{--                                            </option>--}}
{{--                                            <option value="1"--}}
{{--                                                    @if (Settings('youtube_default_player') == 1) selected @endif>   {{__('common.Yes')}}--}}
{{--                                            </option>--}}

{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="col-xl-4">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="">{{_trans('courses.Send Mail Before Expire')}}
                                            (<small>{{__('courses.In Days')}}</small>) </label>
                                        <input class="primary_input_field" name="send_mail_before_expire"
                                               id="send_mail_before_expire"
                                               placeholder="-"
                                               value="{{Settings('send_mail_before_expire')}}"
                                               type="number" {{$errors->has('send_mail_before_expire') ? 'autofocus' : ''}}>

                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="primary-btn semi_large fix-gr-bg"
                                                data-bs-toggle="tooltip"
                                                id="save_button_parent">
                                            <i class="ti-check"></i>
                                            {{ __('common.Update') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('backend.partials.delete_modal')
@endsection
@push('scripts')

@endpush
