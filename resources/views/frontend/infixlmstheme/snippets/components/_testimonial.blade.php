<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/about/testimonial.jpg')}}"
     data-table=""
     data-select="image,author,star,body"
     data-order="id"
     data-limit="0"
     data-view="_single_testimonial"
     data-model="Modules\SystemSetting\Entities\Testimonial"
     data-where-status="1"
     data-with=""
     data-aoraeditor-title="Testimonial"
     data-aoraeditor-categories="About Us Page;Dynamic component">

    <div class="testmonial_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section__title text-center mb_80">
                        <h3>Client Testimonial</h3>
                        <p>The world’s largest selection of courses choose from 130,000 online video courses
                            with new additions published every month.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="">
                        <div data-type="component-nonExisting"
                             data-preview=""
                             data-table=""
                             data-select="image,author,star,body"
                             data-order="id"
                             data-limit="0"
                             data-view="_single_testimonial"
                             data-model="Modules\SystemSetting\Entities\Testimonial"
                             data-with=""
                        >
                            <div class="dynamicData"
                                 data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
