<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 35px !important;
    }

    .select2-container .select2-selection--single {
        height: 37px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 32px !important;
    }

    .select2-container {
        z-index: 99999;
    }

    .select2.select2-container.select2-container--default .select2-selection__rendered {
        line-height: 1.7 !important;
        padding-top: 6px !important;
        padding-bottom: 6px !important;
    }
</style>
<div class="modal fade popup-in-selectbox modal-head-blue" id="courseWaitList" tabindex="-1" role="dialog"
     aria-labelledby="courseWaitListTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <h5 class="modal-title"
                    id="exampleModalLongTitle">   {{ __('frontend.Enter to Wait List') }}</h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="currentColor"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <form action='{{route("storeCourseWaitingListReq")}}' method="post" id="waiting_list_form">
                    @csrf


                    <div class="row">

                        <input type="hidden" name="course_id" id="course_id"
                               value="{{ isset($course) ? $course->id:'' }}">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="font14"> {{ __('common.Name') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder=""
                                       value="{{ Auth::check() ? Auth::user()->name : '' }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="font14"> {{ __('common.Email') }} <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder=""
                                       value="{{ Auth::check() ? Auth::user()->email : '' }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="font14"> {{ __('common.Phone Number') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phone" placeholder="" id="waiting_phone"
                                       value="{{ Auth::check() ? Auth::user()->phone : '' }}">
                            </div>
                        </div>

                        @php
                            $countries  = App\Country::all();
                        @endphp

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="font14"> {{ __('common.Country') }} <span
                                        class="text-danger">*</span></label>
                                <select class="mb-3 wide w-100" name="country_id"
                                        id="country">
                                    <option data-display="{{__('common.Country')}}"
                                            value="">{{__('common.Select')}}</option>
                                    @if(isset($countries))
                                        @foreach ($countries as $country)
                                            <option value="{{@$country->id}}"
                                            @auth()
                                                {{ Auth::user()->country == $country->id ? 'selected' : '' }}
                                                @endauth>{{@$country->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="font14"> {{__('common.State')}} </label>
                                <select class="wide mb_20 stateList" name="state_id"
                                        id="state">
                                    <option data-display="{{__('common.State')}}"
                                            value="#">{{__('common.Select')}} {{__('common.State')}}</option>
                                    @if(isset($states))
                                        @foreach ($states as $state)
                                            <option value="{{$state->id}}"
                                                    @if ($profile->state==$state->id) selected @endif>{{$state->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="font14"> {{__('common.City')}} </label>
                                <select class="  wide mb_20 cityList" name="city_id"
                                        id="city">
                                    <option data-display="{{__('common.City')}}"
                                            value="#">{{__('common.Select')}} {{__('common.City')}}</option>
                                    @if(isset($cities))
                                        @foreach ($cities as $city)
                                            <option value="{{$city->id}}"
                                                    @if ($profile->city==$city->id) selected @endif>{{$city->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center align-items-center">
                <button type="button" class="theme_line_btn me-2"
                        data-bs-dismiss="modal">{{ __('common.Cancel') }}</button>
                <button type="button" id="submitWaitingListForm" class="theme_btn ">{{ __('common.Submit') }}</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).on('click', '#submitWaitingListForm', function () {
        $("#waiting_list_form").submit();
    });

</script>
