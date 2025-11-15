<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/categories/3.jpg')}}"
     data-aoraeditor-title="Category V5" data-aoraeditor-categories="Home Page;Categories">

    <style>
        .category {
            background-color: #ECEFFD;
            padding-bottom: 380px;
        }

        @media only screen and (max-width: 991px) {
            .category {
                padding-bottom: 330px;
            }
        }

        .category-slider {
            margin-top: -160px;
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .category-slider {
                margin-top: -150px;
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .category-slider {
                margin-top: -148px;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .category-slider {
                margin-top: -140px;
            }
        }

        @media only screen and (max-width: 767px) {
            .category-slider {
                margin-top: var(--section-sepreate-lg);
            }
        }

        .category-item {
            padding: 30px;
            display: block;
            border-radius: 10px;
            background: var(--system_primery_gredient1);
            background: linear-gradient(180deg, var(--system_primery_color_0) 0%, var(--system_primery_gredient1) 50%, var(--system_primery_gredient1) 100%);
            border: 1px solid var(--system_primery_color_50);
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .category-item {
                padding: 20px;
            }
        }

        @media only screen and (max-width: 767px) {
            .category-item {
                padding: 16px;
            }
        }

        .category-item-icon {
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ECF6FF;
            margin-bottom: 25px;
            width: 70px;
            height: 75px;
        }

        .category-item-icon img, .category-item-icon svg {
            height: 30px;
            -o-object-fit: contain;
            object-fit: contain;
            color: var(--system_primery_gredient1);
        }

        .category-item-content h6 {
            color: #FFFFFF!important;
            margin-bottom: 14px;
            font-family: var(--fontFamily1);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            font-size: 20px;
            line-height: 1.5;
            transition: all 0.4s ease-in-out;
            min-height: 40px;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .category-item-content h6 {
                font-size: 18px;
            }
        }

        @media only screen and (max-width: 991px) {
            .category-item-content h6 {
                font-size: 18px;
            }
        }

        .category-item-content p {
            color: #fff!important;
            font-size: 18px;
            line-height: 1.5555555556;
            font-weight: 400;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            min-height: 84px;
        }

        .category-item-icon {
            background: linear-gradient(180deg, var(--system_primery_gredient1) 0%, var(--system_primery_gredient2) 100%) !important;
        }

        @media only screen and (max-width: 991px) {
            .category-item-content p {
                font-size: 16px;
            }
        }
    </style>

    <div class="category position-relative">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div data-type="component-nonExisting"
                         data-preview=""
                         data-table=""
                         data-select="image,name,id,thumbnail,description,total_courses"
                         data-order="id"
                         data-limit="0"
                         data-where-status="1"
                         data-view="_single_category_v5"
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
