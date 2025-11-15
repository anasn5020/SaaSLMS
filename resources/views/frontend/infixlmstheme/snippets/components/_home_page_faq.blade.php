<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_faq_section.jpg')}}"
     data-aoraeditor-title="HomePage FAQ Section" data-aoraeditor-categories="Home Page">

    <div class="blog_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section__title text-center mb_80">
                        <h3>
                            {{@$homeContent->home_page_faq_title}}
                        </h3>
                        <p>
                            {{@$homeContent->home_page_faq_sub_title}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 offset-md-2">


                    <div data-type="component-nonExisting"
                         data-preview=""
                         data-table=""
                         data-select="question,answer"
                         data-order="order"
                         data-dir="asc"
                         data-limit="0"
                         data-where-status="1"
                         data-view="_single_faq"
                         data-model="Modules\FrontendManage\Entities\HomePageFaq"
                         data-with=""
                         data-aoraeditor-title="FAQ"
                    >
                        <div class="dynamicData"
                             data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                    </div>

                </div>


            </div>
        </div>
    </div>

</div>
