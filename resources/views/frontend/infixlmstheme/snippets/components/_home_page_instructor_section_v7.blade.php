<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_instructor_section.jpg')}}"
     data-aoraeditor-title="HomePage Default Instructor Section" data-aoraeditor-categories="Home Page">
    <link rel="stylesheet" href="{{themeAsset('css/homepageV7/team-v7.css')}}">

    <div class="container">
        <div class="team-section">
            <div class="section_head">
                <h2>{{__('frontend.Popular Instructors')}}</h2>
                <h5>{{__('frontend.Making sure that our products exceed customer expectations')}}</h5>
            </div>


            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table="users"
                 data-select="image,name,id,headline,total_rating,facebook,twitter,linkedin,youtube"
                 data-order="total_rating"
                 data-dir="desc"
                 data-limit="10"
                 data-view="_single_instructor_v7"
                 data-model=""
                 data-with=""
                 data-with-count=""
                 data-where-role_id="2"
                 data-where-status="1"
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>

        </div>
    </div>

</div>
