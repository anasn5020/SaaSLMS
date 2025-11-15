<div>
    <style>
        .nice-select-search-box {
            display: none !important;
        }

        .nice-select.open .list {
            padding: 0 !important;
        }
    </style>
    <div class="course_category_chose  mt_10">
        <div class="course_title d-flex align-items-center">
            {{--<div class="d-flex align-items-center">
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
                <h5 class="font_16 f_w_500 mb-0">{{__('frontend.Filter Category')}}</h5>
            </div>--}}
            <div class="popupClose"><i class="ti-close"></i></div>
        </div>

        <div class="course_category_inner">
            @if(!Route::is('categoryCourse'))
                <div class="single_course_categry">
                    <h4 class="font_18 f_w_700">
                        {{__('frontend.Category')}}
                    </h4>
                    <ul class="Check_sidebar">
                        @if(isset($categories ))
                            @foreach ($categories  as $cat)
                                <li>
                                    <label class="primary_checkbox d-flex">
                                        <input type="checkbox" value="{{$cat->id}}"
                                               class="category" {{in_array($cat->id,explode(',',$category))?'checked':''}}>
                                        <span class="checkmark mr_15"></span>
                                        <span class="label_name">{{$cat->name}}</span>
                                    </label>
                                </li>
                            @endforeach
                        @endif


                    </ul>
                </div>
            @endif

            <div class="single_course_categry">
                <h4 class="font_18 f_w_700">
                    {{__('frontend.Level')}}
                </h4>
                <ul class="Check_sidebar">

                    @foreach($levels as $l)
                        <li>
                            <label class="primary_checkbox d-flex">
                                <input name="level" type="checkbox" value="{{$l->id}}"
                                       class="level" {{in_array($l->id,explode(',',$level))?'checked':''}}>
                                <span class="checkmark mr_15"></span>
                                <span class="label_name">{{$l->title}}</span>
                            </label>
                        </li>
                    @endforeach


                </ul>
            </div>
            <div class="single_course_categry">
                <h4 class="font_18 f_w_700">
                    {{__('frontend.Class Price')}}
                </h4>
                <ul class="Check_sidebar">
                    <li>
                        <label class="primary_checkbox d-flex">
                            <input type="checkbox" class="price"
                                   value="paid" {{in_array("paid",explode(',',$type))?'checked':''}}>
                            <span class="checkmark mr_15"></span>
                            <span class="label_name">{{__('frontend.Paid Class')}}</span>
                        </label>
                    </li>
                    <li>
                        <label class="primary_checkbox d-flex">
                            <input type="checkbox" class="price"
                                   value="free" {{in_array("free",explode(',',$type))?'checked':''}}>
                            <span class="checkmark mr_15"></span>
                            <span class="label_name">{{__('frontend.Free Class')}}</span>
                        </label>
                    </li>
                </ul>
            </div>

            <div class="single_course_categry">
                <h4 class="font_18 f_w_700">
                    {{__('frontend.Language')}}
                </h4>
                <ul class="Check_sidebar">
                    @if(isset($languages))
                        @foreach ($languages as $lang)

                            <li>
                                <label class="primary_checkbox d-flex">
                                    <input type="checkbox" class="language"
                                           value="{{$lang->code}}" {{in_array($lang->code,explode(',',$language))?'checked':''}}>
                                    <span class="checkmark mr_15"></span>
                                    <span class="label_name">{{$lang->name}}</span>
                                </label>
                            </li>
                        @endforeach
                    @endif

                </ul>
            </div>
        </div>
    </div>
</div>
