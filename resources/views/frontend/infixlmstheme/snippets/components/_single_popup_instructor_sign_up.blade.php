@if(Settings('instructor_reg') ==1)
    <div class="modal fade" id="Instructor" tabindex="-1" role="dialog"
         aria-labelledby="InstructorTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content cs_modal">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="InstructorTitle">{{__('frontendmanage.Become Instructor')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
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
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="email" class="form-control "
                                       placeholder="{{__('common.Enter Email')}}*"
                                       aria-label="email" name="email" value="{{old('email')}}">

                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control "
                                       placeholder="{{__('common.Enter Phone Number')}}"
                                       aria-label="phone" name="phone" value="{{old('phone')}}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="password" class="form-control"
                                       placeholder="{{__('frontend.Enter Password')}}*"
                                       autocomplete="new-password"
                                       aria-label="password" name="password">

                            </div>
                            <div class="form-group col-md-12">
                                <input type="password" class="form-control"
                                       placeholder="{{__('common.Enter Confirm Password')}}*"
                                       name="password_confirmation"
                                       aria-label="password_confirmation">

                            </div>
                        </div>


                        <div class="col-12 ">
                            <div class="remember_forgot_pass d-flex align-items-center">
                                <label class="primary_checkbox d-flex" for="checkbox">
                                    <input type="checkbox" id="checkbox">
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
@if(\Illuminate\Support\Facades\Auth::check())
    <span class="text-danger">
        {{__('common.Already logged in as')}} {{Auth::user()->role?->name}}
    </span>
                        @else
                            <button type="submit" class="theme_btn small_btn2" id="submitBtn">
                                {{__('common.Register')}}
                            </button>
@endif

                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
