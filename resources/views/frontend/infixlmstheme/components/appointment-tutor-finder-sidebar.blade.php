<div>
    <style>
        .nice-select-search-box {
            display: none !important;
        }

        .nice-select.open .list {
            padding: 0 !important;
        }

    </style>
    <div class="course_category_chose mb_30 mt_10">
        <div class="popupClose"><i class="ti-close"></i></div>

        <div class="course_title mb_30 d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="19.5" height="13" viewBox="0 0 19.5 13">
                <g id="filter-icon" transform="translate(28)">
                    <rect id="Rectangle_1" data-name="Rectangle 1" width="19.5" height="2" rx="1"
                          transform="translate(-28)" fill="var(--system_primery_color)"/>
                    <rect id="Rectangle_2" data-name="Rectangle 2" width="15.5" height="2" rx="1"
                          transform="translate(-26 5.5)" fill="var(--system_primery_color)"/>
                    <rect id="Rectangle_3" data-name="Rectangle 3" width="5" height="2" rx="1"
                          transform="translate(-20.75 11)" fill="var(--system_primery_color)"/>
                </g>
            </svg>
            <h5 class="font_16 f_w_500 mb-0">{{ __('frontend.Filter Category') }}</h5>
        </div>
        <div class="course_category_inner mb_30">
            {{-- category --}}
            <div class="single_course_categry">
                <h4 class="font_18 f_w_700">
                    {{ __('frontend.Category') }}
                </h4>

                <ul class="Check_sidebar">
                    @if (isset($categories))
                        @foreach ($categories as $cat)
                            <li>
                                <label class="primary_checkbox d-flex">
                                    <input type="checkbox" value="{{ $cat->id }}" class="category"
                                        {{ isset($categoriesIds) ? (in_array($cat->id, $categoriesIds) ? 'checked' : '') : '' }}
                                    >
                                    <span class="checkmark mr_15"></span>
                                    <span class="label_name">{{ $cat->name }}</span>
                                </label>
                            </li>
                        @endforeach
                    @endif


                </ul>
            </div>
            {{-- level --}}
            <div class="single_course_categry">
                <h4 class="font_18 f_w_700">
                    {{ __('frontend.Level') }}
                </h4>
                <ul class="Check_sidebar">
                    @isset($levels)
                        @foreach ($levels as $l)
                            <li>
                                <label class="primary_checkbox d-flex">
                                    <input name="level" type="checkbox" value="{{ $l->id }}" class="level"
                                        {{ isset($levelIds) ? (in_array($l->id, $levelIds) ? 'checked' : '') : '' }}
                                    >
                                    <span class="checkmark mr_15"></span>
                                    <span class="label_name">{{ $l->title }}</span>
                                </label>
                            </li>
                        @endforeach
                    @endisset

                </ul>
            </div>
            {{-- gender --}}
            <div class="single_course_categry">
                <h4 class="font_18 f_w_700">
                    {{ __('common.Gender') }}
                </h4>
                <ul class="Check_sidebar">
                    @isset($genders)
                        @foreach ($genders as $g)
                            <li>
                                <label class="primary_checkbox d-flex">
                                    <input name="gender" type="checkbox" value="{{ strtolower($g) }}" class="gender"
                                        {{ isset($genderIds) ? (in_array(strtolower($g), $genderIds) ? 'checked' : '') : '' }}
                                    >
                                    <span class="checkmark mr_15"></span>
                                    <span class="label_name">{{ $g }}</span>
                                </label>
                            </li>
                        @endforeach
                    @endisset

                </ul>
            </div>
            {{-- price range --}}
            <div class="single_course_categry">
                <label for="#">{{ __('appointment.Price Range') }}</label>
                <input class="category-item-price price_range" name="price_range" id='price_range'/>
            </div>
            {{-- age range --}}
            <div class="single_course_categry">
                <label for="#">{{ __('appointment.Instructor Age') }}</label>
                <input class="category-item-price age_range" name="age_range" id='instructor_age'/>
            </div>
            {{-- week days --}}
            <div class="single_course_categry">
                <h4 class="font_18 f_w_700">
                    {{ __('appointment.Available Day') }}
                </h4>
                <ul class="Check_sidebar">
                    @isset($weekDays)
                        @foreach ($weekDays as $d)
                            <li>
                                <label class="primary_checkbox d-flex">
                                    <input name="days" type="checkbox" value="{{ strtolower($d) }}" class="days"
                                        {{ isset($days) ? (in_array(strtolower($d), $days) ? 'checked' : '') : '' }}
                                    >
                                    <span class="checkmark mr_15"></span>
                                    <span class="label_name">{{ $d }}</span>
                                </label>
                            </li>
                        @endforeach
                    @endisset

                </ul>
            </div>

        </div>
        <div class="course_category_inner">
            <h4>{{ __('appointment.Instructor Location') }}</h4>
            <div class="category-item">
                <label for="#">{{ __('appointment.Country') }}</label>
                <select name="country" class="category-item-input country" id="country">
                    <option value="">{{ __('appointment.Select Country') }}</option>
                    @foreach ($countries as $c)
                        <option value="{{$c->id}}"
                            {{ isset($country) ? ($c->id==$country ? 'selected' : '') : '' }}
                        >{{$c->name}}</option>
                    @endforeach
                </select>
            </div>
            {{-- <div class="category-item">
                <label for="#">Province</label>
                <select name="province_id" class="category-item-input" disabled="">
                    <option value="">Select Province</option>
                </select>
            </div>
            <div class="category-item">
                <label for="#">{{ __('common.City') }}</label>
                <select name="city_id" class="category-item-input city" disabled="">
                    <option value="">{{ __('common.Select City') }}</option>
                </select>
            </div>
            <div class="category-item">
                <label for="#">District</label>
                <select name="district_id" class="category-item-input district" disabled="">
                    <option value="">Select District</option>
                </select>
            </div> --}}
        </div>
    </div>
</div>
