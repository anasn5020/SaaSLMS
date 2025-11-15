<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/class/class_page_section.jpg')}}"
     data-aoraeditor-title="Course Page Section"
     data-aoraeditor-categories="Course Page"
>

    <input type="hidden" class="class_route" name="class_route" value="{{route('courses')}}">
    <div class="courses_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xl-3">
                    @include(theme('snippets.components._sidebar'))
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div data-type="component-nonExisting"
                         data-preview=""
                         data-table=""
                         data-select=""
                         data-order=""
                         data-limit=""
                         data-where-type="1"
                         data-where-status="1"
                         data-pagination="12"
                         data-view="_single_topic"
                         data-model="Modules\CourseSetting\Entities\Course"
                         data-with="lessons"
                         data-request="price,discount_price,lang_id,level,category_id,order,search,about,user_id,rating"
                    >
                        <div class="dynamicData"
                             data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
