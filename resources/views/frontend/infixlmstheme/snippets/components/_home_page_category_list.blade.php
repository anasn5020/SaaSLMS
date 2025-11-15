<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_faq_section.jpg')}}"
     data-aoraeditor-title="HomePage Category List" data-aoraeditor-categories="Home Page">

    <div class="blog_area">
        <div class="container">

            <div class="row">
                <div class="col-md-12">


                    <div data-type="component-nonExisting"
                         data-preview=""
                         data-table=""
                         data-select="*"
                         data-order="position_order"
                         data-dir="asc"
                         data-limit="0"
                         data-where-status="1"
                         data-view="_single_category_list"
                         data-model="Modules\CourseSetting\Entities\Category"
                         data-with="activeSubcategories"
                         data-aoraeditor-title="Category"
                    >
                        <div class="dynamicData"
                             data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                    </div>

                </div>


            </div>
        </div>
    </div>

</div>
