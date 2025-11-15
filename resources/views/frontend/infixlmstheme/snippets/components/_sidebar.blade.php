<div class="course_category_chose  mt_10">
    <div class="course_title d-flex align-items-center">
        {{--<div class="d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="19.5" height="13" viewBox="0 0 19.5 13">
                <g id="filter-icon" transform="translate(28)">
                    <rect id="Rectangle_1" data-name="Rectangle 1" width="19.5" height="2" rx="1"
                          transform="translate(-28)" fill="var(--system_primery_color)"/>
                    <rect id="Rectangle data-name=" Rectangle 2
                    " width="15.5" height="2" rx="1"
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
        <div class="single_course_categry">
            <h4 class="font_18 f_w_700">
                {{__('frontend.Category')}}
            </h4>

            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table=""
                 data-select="id,name"
                 data-order=""
                 data-limit=""
                 data-where-status="1"
                 data-view="_single_sidebar_category"
                 data-model="Modules\CourseSetting\Entities\Category"
                 data-with=""
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>

        </div>
        <div class="single_course_categry">
            <h4 class="font_18 f_w_700">
                {{__('frontend.Level')}}
            </h4>
            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table=""
                 data-select="id,title"
                 data-order=""
                 data-limit=""
                 data-view="_single_sidebar_level"
                 data-model="Modules\CourseSetting\Entities\CourseLevel"
                 data-with=""
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>


        </div>
        <div class="single_course_categry">
            <h4 class="font_18 f_w_700">
                {{__('frontend.Price')}}
            </h4>
            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table=""
                 data-select=""
                 data-order=""
                 data-limit=""
                 data-view="_single_sidebar_price"
                 data-model=""
                 data-with=""
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>
        </div>
        <div class="single_course_categry">
            <h4 class="font_18 f_w_700">
                {{__('frontend.Language')}}
            </h4>
            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table="languages"
                 data-select="id,name"
                 data-order=""
                 data-limit=""
                 data-where-status="1"
                 data-view="_single_sidebar_language"
                 data-model=""
                 data-with=""
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>
        </div>

        <div class="single_course_categry">
            <h4 class="font_18 f_w_700">
                {{__('frontend.Instructors')}}
            </h4>
            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table="users"
                 data-select="id,name"
                 data-order="id"
                 data-dir="asc"
                 data-limit=""
                 data-where_not-role_id="3"
                 data-where-status="1"
                 data-view="_single_sidebar_instructor"
                 data-model=""
                 data-with=""
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>
        </div>
        <div class="single_course_categry">
            <h4 class="font_18 f_w_700">
                {{__('frontend.Rating')}}
            </h4>
            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table=""
                 data-select=""
                 data-order=""
                 data-limit=""
                 data-where-status="1"
                 data-view="_single_sidebar_rating"
                 data-model=""
                 data-with="course"
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>
        </div>
    </div>

</div>
