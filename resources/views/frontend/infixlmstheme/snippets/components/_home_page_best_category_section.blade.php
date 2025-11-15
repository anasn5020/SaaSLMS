<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_best_category_section.jpg')}}"
     data-aoraeditor-title="HomePage Best Category Section"
     data-aoraeditor-categories="Home Page">

    <div class="package_area"
         style="background-image: url('{{asset(@$homeContent->best_category_banner)}}')">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-9">
                    <div class="section__title text-center mb_80">
                        <h3>
                            {{@$homeContent->best_category_title}}
                        </h3>
                        <p>
                            {{@$homeContent->best_category_sub_title}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div data-type="component-nonExisting"
                         data-preview=""
                         data-table=""
                         data-select="image,name,id,thumbnail,total_courses"
                         data-order="id"
                         data-limit="0"
                         data-where-status="1"
                         data-view="_single_category"
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
    </div>
</div>
