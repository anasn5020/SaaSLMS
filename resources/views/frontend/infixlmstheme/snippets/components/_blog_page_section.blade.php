<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/blog/list.jpg')}}"
     data-aoraeditor-title="Blog Page Section"
     data-aoraeditor-categories="Blog Page"
>

    <div class="lms_blog_details_area">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-xl-7 col-lg-7 ">
                    <div class="blog_page_wrapper pt-0">

                        <div data-type="component-nonExisting"
                             data-preview=""
                             data-table=""
                             data-select="slug,thumbnail,authored_date,authored_time,title,user_id,category_id"
                             data-order="id"
                             data-limit="0"
                             data-where-status="1"
                             data-view="_single_blog"
                             data-model="Modules\Blog\Entities\Blog"
                             data-with="user"
                        >
                            <div class="dynamicData"
                                 data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3">

                    <div>

                        <div class="blog_sidebar_wrap mb_30">
                            <input type="hidden" class="blog_route" name="blog_route" value="{{route('blogs')}}">
                            <form action="{{route('blogs')}}" method="GET">
                                <input type="hidden" value="{{request('category')}}" name="category">
                                <input type="hidden" value="{{request('type')}}" name="category">
                                <div class="input-group  theme_search_field4 w-100 mb_20 style2">

                                    <input type="text" name="query" value="{{request('query')}}"
                                           class="form-control search"
                                           placeholder="{{__('common.Search')}}">
                                </div>
                            </form>

                            <div class="blog_sidebar_box mb_30">
                                <h4 class="font_18 f_w_700 mb_10">
                                    {{__('frontend.Blog categories')}}
                                </h4>
                                <div class="home6_border w-100 mb_20"></div>
                                <ul class="Check_sidebar mb-0">


                                    <div data-type="component-nonExisting"
                                         data-preview=""
                                         data-table=""
                                         data-select="id,title,position_order,total_courses"
                                         data-order="position_order"
                                         data-desc="asc"
                                         data-limit="0"
                                         data-view="_single_category_blog"
                                         data-model="Modules\Blog\Entities\BlogCategory"
                                         data-with=""
                                    >
                                        <div class="dynamicData"
                                             data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                                    </div>

                                </ul>
                            </div>
                            <div class="blog_sidebar_box mb_60">
                                <h4 class="font_18 f_w_700 mb_10">
                                    {{__('frontend.Recent Posts')}}
                                </h4>
                                <div class="home6_border w-100 mb_20"></div>
                                <div class="news_lists">

                                    <div data-type="component-nonExisting"
                                         data-preview=""
                                         data-table=""
                                         data-select="slug,thumbnail,authored_date,authored_time,title"
                                         data-order="id"
                                         data-desc="asc"
                                         data-limit="0"
                                         data-view="_single_latest_post"
                                         data-model="Modules\Blog\Entities\Blog"
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
        </div>
    </div>

</div>
