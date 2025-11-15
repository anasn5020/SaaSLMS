<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_category_section.jpg')}}"
     data-aoraeditor-title="HomePage Default Category" data-aoraeditor-categories="Home Page">
    <link rel="stylesheet" href="{{themeAsset('css/homepageV7/category-v7.css')}}">

    <div class="category-section overflow-hidden">
        <div class="container">

            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table=""
                 data-select="image,name,id,thumbnail,total_courses"
                 data-order="position_order"
                 data-dir="asc"
                 data-limit="0"
                 data-where-status="1"
                 data-view="_single_category_v7"
                 data-model="Modules\CourseSetting\Entities\Category"
                 data-with=""
                 data-with-count="courses"
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>

        </div>
    </div>
</div>


