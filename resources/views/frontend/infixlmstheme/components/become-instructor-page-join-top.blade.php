<style>
    .instructor_cta {
        background-image: url('{{$joining_part->bg_image}}');
        background-size: cover;
        background-position: center center;
    }
</style>
<div>
    <section class="cta_part instructor_cta section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8">
                    <div class="cta_part_iner">
                        <h2>{{$joining_part->title??''}}</h2>
                        <p> {{$joining_part->description??''}}</p>
                        <!-- Button trigger modal -->
                        @if(Settings('instructor_reg') ==1)
                            <a href="#" class="theme_btn" data-bs-toggle="modal"
                               data-bs-target="#Instructor">

                                @if(!empty($joining_part->btn_name))
                                    {{$joining_part->btn_name}}
                                @else
                                    {{__('frontendmanage.Become Instructor')}}
                                @endif
                            </a>
                        @endif

                        @if(Settings('instructor_reg') ==1)
                            <div class="modal fade" id="Instructor" tabindex="-1" role="dialog"
                                 aria-labelledby="InstructorTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content cs_modal">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="InstructorTitle">{{__('frontendmanage.Become Instructor')}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true" class="ti-close"></span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('register')}}" method="POST">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <input type="text" class="form-control "
                                                               placeholder="{{__('student.Enter Full Name')}}*"
                                                               aria-label="Username"
                                                               name="name" value="{{old('name')}}">
                                                        <span class="text-danger"
                                                              role="alert">{{$errors->first('name')}}</span>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <input type="email" class="form-control "
                                                               placeholder="{{__('common.Enter Email')}}*"
                                                               aria-label="email" name="email" value="{{old('email')}}">
                                                        <span class="text-danger"
                                                              role="alert">{{$errors->first('email')}}</span>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="text" class="form-control "
                                                               placeholder="{{__('common.Enter Phone Number')}}"
                                                               aria-label="phone" name="phone" value="{{old('phone')}}">
                                                        <span class="text-danger"
                                                              role="alert">{{$errors->first('phone')}}</span>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <input type="password" class="form-control"
                                                               placeholder="{{__('frontend.Enter Password')}}*"
                                                               autocomplete="new-password"
                                                               aria-label="password" name="password">
                                                        <span class="text-danger"
                                                              role="alert">{{$errors->first('password')}}</span>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="password" class="form-control"
                                                               placeholder="{{__('common.Enter Confirm Password')}}*"
                                                               name="password_confirmation"
                                                               aria-label="password_confirmation">
                                                        <span class="text-danger"
                                                              role="alert">{{$errors->first('password_confirmation')}}</span>
                                                    </div>
                                                </div>


                                                <div class="col-12 ">
                                                    <div class="remember_forgot_pass d-flex align-items-center">
                                                        <label class="primary_checkbox d-flex" for="checkbox">
                                                            <input checked="" type="checkbox" id="checkbox">
                                                            <span class="checkmark mr_15"></span>
                                                            <span>{{__('frontend.By signing up, you agree to')}}
                                                            <a target="_blank" href="{{route('privacy')}}">
                                                                {{__('frontend.Terms of Service and Privacy Policy')}}.
                                                            </a>
                                                        </span>

                                                        </label>

                                                    </div>

                                                </div>
                                                <input type="hidden" name="type" value="Instructor">

                                                @auth
                                                    <div class="form-group col-md-12">
                                                        <small
                                                            class="text-danger">* {{__("Already login. You can't register right now")}}
                                                            .</small>
                                                    </div>
                                                @endauth
                                                @guest
                                                    <button type="submit" class="theme_btn small_btn2" id="submitBtn"
                                                            @auth disabled @endauth>
                                                        {{__('common.Register')}}
                                                    </button>
                                                @endguest
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
