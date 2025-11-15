<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_testimonial_section.jpg')}}"
     data-aoraeditor-title="HomePage Default Testimonial" data-aoraeditor-categories="Home Page">
    <link rel="stylesheet" href="{{themeAsset('css/homepageV7/testimonial-v7.css')}}">

    <div class="container">
        <div class="section_head">
            <h2 class="mb-0">Our Client Feedback</h2>
        </div>
        <div class="testimonial position-relative mb-3 mb-md-4 section-margin-lg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div data-type="component-nonExisting"
                             data-preview=""
                             data-table=""
                             data-select="image,author,star,body"
                             data-order="id"
                             data-limit="0"
                             data-view="_single_testimonial_v7"
                             data-model="Modules\SystemSetting\Entities\Testimonial"
                             data-where-status="1"
                             data-with="">
                            <div class="dynamicData"
                                 data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
