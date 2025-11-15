<div data-type="component-nonExisting"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/home_sponsor.jpg')}}"
     data-aoraeditor-title="Home Sponsor"
     data-aoraeditor-categories="Home Page;Dynamic component"
>
    <div class="brand_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">


                    <div
                        data-preview=""
                        data-table=""
                        data-select="image"
                        data-order="id"
                        data-limit="0"
                        data-view="_single_sponsor"
                        data-model="Modules\FrontendManage\Entities\Sponsor"
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
