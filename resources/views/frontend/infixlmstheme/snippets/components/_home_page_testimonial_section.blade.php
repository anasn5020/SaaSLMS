<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_testimonial_section.jpg')}}"
     data-aoraeditor-title="HomePage Testimonial Section" data-aoraeditor-categories="Home Page">


    <div class="testmonial_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section__title text-center mb_80">
                        <h3>{{@$homeContent->testimonial_title}}</h3>
                        <p>
                            {{@$homeContent->testimonial_sub_title}}

                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div data-type="component-nonExisting"
                         data-preview=""
                         data-table=""
                         data-select="image,author,star,body"
                         data-order="id"
                         data-limit="0"
                         data-view="_single_testimonial"
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
