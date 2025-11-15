<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/instractor/popular_instructor.jpg')}}"
     data-aoraeditor-title="Popular Instructor" data-aoraeditor-categories="Instructor Page">
    <div class="instractors_wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section__title2 mb_76 text-center">
                        <span class="text-center">{{__('frontend.Popular Instructors')}}</span>
                        <h4 class="text-center">{{__('frontend.Making sure that our products exceed customer expectations')}}
                            <br>{{__('frontend.for quality, style and performance')}}.</h4>
                    </div>
                </div>
            </div>


            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table="users"
                 data-select="image,name,id,headline,total_rating,facebook,twitter,linkedin,instagram,youtube"
                 data-order="total_rating"
                 data-dir="desc"
                 data-limit="10"
                 data-view="_single_popular_instructor"
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
