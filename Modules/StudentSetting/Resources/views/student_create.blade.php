@php use Illuminate\Support\Facades\Auth; @endphp
@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/student_list.css')}}"/>
@endpush
@php
    $table_name='users';
@endphp
@section('table')
    {{$table_name}}
@endsection

@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">

                <div class="col-lg-12 ">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <div class="white-box">
                                <form action="{{isset($user)?route('student.update'):route('student.store')}}"
                                      method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{isset($user)?$user->id:''}}">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('common.Name')}}
                                                    <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="name" placeholder="-"
                                                       type="text" id="addName"
                                                       value="{{ old('name',isset($user)?$user->name:'') }}" {{$errors->first('name') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.About')}}</label>
                                                <textarea class="lms_summernote" name="about" id="addAbout"
                                                          cols="30"
                                                          rows="10">{{ old('about',isset($user)?$user->about:'') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Date of Birth')}}
                                                </label>
                                                <div class="primary_datepicker_input">
                                                    <div class="g-0  input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="{{__('common.Date')}}"
                                                                       class="primary_input_field primary-input date form-control"
                                                                       id="startDate" type="text" name="dob" data-prevent-future="1"
                                                                       data-prevent-future="1"
                                                                       value="{{ old('dob',isset($user)?$user->dob:'') }}"
                                                                       autocomplete="off" {{$errors->first('dob') ? 'autofocus' : ''}}>
                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Phone')}} </label>
                                                <input class="primary_input_field phoneNumberInput"
                                                       value="{{ old('phone',isset($user)?$user->phone:'') }}"
                                                       name="phone" id="addPhone"
                                                       placeholder="-"
                                                       type="number" {{$errors->first('phone') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('common.Email')}}
                                                    <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="email" placeholder="-"
                                                       value="{{ old('email',isset($user)?$user->email:'') }}"
                                                       id="addEmail"
                                                       {{$errors->first('email') ? 'autofocus' : ''}}
                                                       type="email">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">{{__('common.gender')}}
                                                </label>

                                                <select class="primary_select"
                                                        data-course_id="{{@$course->id}}" name="gender">
                                                    <option
                                                        data-display="{{__('common.Select')}} {{__('common.gender')}}"
                                                        value="">{{__('common.Select')}} {{__('common.gender')}} </option>

                                                    <option
                                                        value="male" {{(old('gender',isset($user)?$user->gender:'')=='male')?'checked':''}}>{{__('common.Male')}}</option>
                                                    <option
                                                        value="female" {{(old('gender',isset($user)?$user->gender:'')=='female')?'checked':''}}>{{__('common.Female')}}</option>
                                                    <option
                                                        value="other" {{(old('gender',isset($user)?$user->gender:'')=='other')?'checked':''}}>{{__('common.Other')}}</option>


                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.company')}} {{__('common.Name')}} </label>
                                                <input class="primary_input_field"
                                                       value="{{ old('company',isset($user)?$user->company:'') }}"
                                                       name="company" id="addCompany"
                                                       placeholder="-"
                                                       type="text" {{$errors->first('company') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                        @php
                                            $selectedInstitute =isset($user)?$user->institute_id:'';
                                        @endphp
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Institute Name')}} </label>
                                                <select class="primary_select"
                                                        name="institute_id">
                                                    <option
                                                        data-display="{{__('common.Select')}} {{__('student.Institute')}}"
                                                        value="">{{__('common.Select')}} {{__('student.Institute')}} </option>

                                                    @foreach($institutes as $institute)
                                                        <option
                                                            value="{{$institute->id}}" {{ ($selectedInstitute==$institute->id)?'selected':''}}>{{$institute->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class=" mb-35">
                                                <x-upload-file
                                                    name="image"
                                                    type="image"
                                                    media_id="{{isset($user)?$user->image_media?->media_id:''}}"
                                                    label="{{__('common.Image')}}"
                                                    note=""/>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('common.Password')}}
                                                    <strong
                                                        class="text-danger">*</strong></label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i style="cursor:pointer;"
                                                                                         class="fas fa-eye-slash eye toggle-password"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" class="form-control primary_input_field"
                                                           id="addPassword" name="password"
                                                           autocomplete="new-password"
                                                           placeholder="{{__('common.Minimum 8 characters')}}" {{$errors->first('password') ? 'autofocus' : ''}}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Confirm Password')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i style="cursor:pointer;"
                                                                                         class="fas fa-eye-slash eye toggle-password"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" class="form-control primary_input_field"
                                                           {{$errors->first('password_confirmation') ? 'autofocus' : ''}}
                                                           id="addCpassword" name="password_confirmation"
                                                           placeholder="{{__('common.Minimum 8 characters')}}">
                                                </div>
                                                {{--                                                    <input class="primary_input_field"  name="password_confirmation" placeholder="-" type="text">--}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Facebook URL')}}</label>
                                                <input class="primary_input_field" name="facebook" placeholder="-"
                                                       id="addFacebook"
                                                       type="text"
                                                       value="{{ old('facebook',isset($user)?$user->facebook:'') }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Twitter URL')}}</label>
                                                <input class="primary_input_field" name="twitter" placeholder="-"
                                                       id="addTwitter"
                                                       type="text"
                                                       value="{{ old('twitter',isset($user)?$user->twitter:'') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.LinkedIn URL')}}</label>
                                                <input class="primary_input_field" name="linkedin" placeholder="-"
                                                       id="addLinked"
                                                       type="text"
                                                       value="{{ old('linkedin',isset($user)?$user->linkedin:'') }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Youtube URL')}}</label>
                                                <input class="primary_input_field" name="youtube" placeholder="-"
                                                       id="addYoutube"
                                                       type="text"
                                                       value="{{ old('youtube',isset($user)?$user->youtube:'') }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Instagram URL')}}</label>
                                                <input class="primary_input_field" name="instagram" placeholder="-"
                                                       id="addInstagram"
                                                       type="text"
                                                       value="{{ old('instagram',isset($user)?$user->instagram:'') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg"
                                                    id="save_button_parent"
                                                    type="submit"><i
                                                    class="ti-check"></i> {{isset($user)?__('common.Update'):__('common.Save')}} {{__('student.Student')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection
@push('scripts')

    <script src="{{asset('public/backend/js/student_list.js')}}"></script>

@endpush
