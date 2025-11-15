<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_course_section.jpg')}}"
     data-aoraeditor-title="HomePage Default Latest Course" data-aoraeditor-categories="Home Page">
    <link rel="stylesheet" href="{{themeAsset('css/homepageV7/course-v7.css')}}">

    <div class="course">
        <div class="container">
            <div class="section_head withBtn">
                <div>
                    <h2>Our Latest Courses</h2>
                    <h5>Explore New Skills and Knowledge</h5>
                </div>
                <div class="view-all-btn">
                    <a href="{{route('courses')}}">View All <i class="fas fa-arrow-right fa-fw"></i></a>
                </div>
            </div>


            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table=""
                 data-select="id,type,slug,title,thumbnail,price,discount_price,mode_of_delivery,about,total_reviews,total_enrolled,total_rating"
                 data-order="id"
                 data-dir="desc"
                 data-limit="4"
                 data-where-type="1"
                 data-where-status="1"
                 data-view="_single_course_v7"
                 data-model="Modules\CourseSetting\Entities\Course"
                 data-with="lessons"
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>
        </div>
    </div>

</div>
