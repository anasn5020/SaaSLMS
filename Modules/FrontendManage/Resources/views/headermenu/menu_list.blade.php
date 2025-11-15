<div class="row m-0">
    <div class="col-lg-12 card pt-4 pb-4">
        <div id="accordion">
            <div class="card mt-10">
                <div class="card-header" id="pages">
                    <h5 class="mb-0 collapsed create-title" data-bs-toggle="collapse" data-bs-target="#dynamicPages"
                        aria-expanded="false" aria-controls="dynamicPages">
                        <button class="btn btn-link cust-btn-link add_btn_link">
                            @lang('frontendmanage.Pages')
                        </button>
                    </h5>
                </div>
                <div id="dynamicPages" class="collapse" aria-labelledby="pages" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="menu_pagess">
                                        @lang('frontendmanage.Pages')
                                        <span class="text-danger">*</span></label>
                                    <select name="page[]" id="menu_pagess" class="multypol_check_select active mb-15"
                                            multiple>
                                        @foreach ($pages as $key => $page)
                                            <option value="{{ $page->id }}">{{ $page->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="row">

                                        <div class="col-lg-7">
                                            <button id="add_page_btn" type="submit"
                                                    class="primary-btn text-nowrap fix-gr-bg  mt-3  submit_btn"
                                                    data-bs-toggle="tooltip"
                                                    title="" data-original-title="">
                                                <i class="ti-check"></i>
                                                @lang('frontendmanage.Add Menu')
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="staticPages">
                    <h5 class="mb-0 collapsed create-title" data-bs-toggle="collapse" data-bs-target="#staticPage"
                        aria-expanded="false" aria-controls="staticPage">
                        <button class="btn btn-link cust-btn-link add_btn_link">
                            @lang('frontendmanage.Static Pages')
                        </button>
                    </h5>
                </div>
                <div id="staticPage" class="collapse" aria-labelledby="staticPages" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                           for="menu_staticPagesInput">@lang('frontendmanage.Pages')
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="static_pages[]" id="menu_staticPagesInput"
                                            class="multypol_check_select active mb-15 e1" multiple>
                                        @foreach ($static_pages as $key => $static_page)
                                            <option value="{{ $static_page->id }}">{{ $static_page->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="row">
                                        {{--                                        <div class="col-lg-5">--}}
                                        {{--                                            <input type="checkbox" id="staticPagesCheckbox" class="common-checkbox">--}}
                                        {{--                                            <label for="staticPagesCheckbox"--}}
                                        {{--                                                   class="mt-3">@lang('frontendmanage.Select All')</label>--}}
                                        {{--                                        </div>--}}
                                        <div class="col-lg-7">
                                            <button id="add_static_page_btn" type="submit"
                                                    class="primary-btn text-nowrap fix-gr-bg  mt-3   submit_btn"
                                                    data-bs-toggle="tooltip"
                                                    title="" data-original-title="">
                                                <i class="ti-check"></i>
                                                @lang('frontendmanage.Add Menu')
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header" id="category">
                    <h5 class="mb-0 collapsed create-title" data-bs-toggle="collapse" data-bs-target="#categoryPage"
                        aria-expanded="false" aria-controls="categoryPage">
                        <button class="btn btn-link cust-btn-link add_btn_link">
                            @lang('frontendmanage.Category')
                        </button>
                    </h5>
                </div>
                <div id="categoryPage" class="collapse" aria-labelledby="category" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                           for="menu_categoryInput">@lang('frontendmanage.Pages')
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="category[]" id="menu_categoryInput"
                                            class="multypol_check_select active  mb-15 e1"
                                            multiple>
                                        @foreach ($categories as $key => $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="row">

                                        <div class="col-lg-7">
                                            <button id="add_category_page_btn" type="submit"
                                                    class="primary-btn text-nowrap fix-gr-bg  mt-3   submit_btn"
                                                    data-bs-toggle="tooltip"
                                                    title="" data-original-title="">
                                                <i class="ti-check"></i>
                                                @lang('frontendmanage.Add Menu')
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card d-none">
                <div class="card-header" id="subcategory">
                    <h5 class="mb-0 collapsed create-title" data-bs-toggle="collapse" data-bs-target="#subcategoryPage"
                        aria-expanded="false" aria-controls="subcategoryPage">
                        <button class="btn btn-link cust-btn-link add_btn_link">
                            @lang('frontendmanage.Sub Category')
                        </button>
                    </h5>
                </div>
                <div id="subcategoryPage" class="collapse" aria-labelledby="subcategory" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                           for="subCategoryInput">@lang('frontendmanage.Pages')
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="subCategory[]" id="menu_subCategoryInput"
                                            class="multypol_check_select active  mb-15 e1"
                                            multiple>
                                        @foreach ($subCategories as $key => $sub)
                                            <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <button id="add_sub_category_page_btn" type="submit"
                                                    class="primary-btn text-nowrap fix-gr-bg  mt-3  submit_btn"
                                                    data-bs-toggle="tooltip"
                                                    title="" data-original-title="">
                                                <i class="ti-check"></i>
                                                @lang('frontendmanage.Add Menu')
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header" id="courses">
                    <h5 class="mb-0 collapsed create-title" data-bs-toggle="collapse" data-bs-target="#coursePage"
                        aria-expanded="false" aria-controls="coursePage">
                        <button class="btn btn-link cust-btn-link add_btn_link">
                            @lang('frontendmanage.Courses')
                        </button>
                    </h5>
                </div>
                <div id="coursePage" class="collapse" aria-labelledby="courses" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                           for="menu_courseInput">@lang('frontendmanage.Pages')
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="courses[]" id="menu_courseInput"
                                            class="multypol_check_select active  mb-15 e1"
                                            multiple>
                                        @foreach ($courses as $key => $course)
                                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <button id="add_course_page_btn" type="submit"
                                                    class="primary-btn text-nowrap fix-gr-bg  mt-3  submit_btn"
                                                    data-bs-toggle="tooltip"
                                                    title="" data-original-title="">
                                                <i class="ti-check"></i>
                                                @lang('frontendmanage.Add Menu')
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header" id="quizzes">
                    <h5 class="mb-0 collapsed create-title" data-bs-toggle="collapse" data-bs-target="#quizPages"
                        aria-expanded="false" aria-controls="quizPages">
                        <button class="btn btn-link cust-btn-link add_btn_link">
                            @lang('frontendmanage.Quizzes')
                        </button>
                    </h5>
                </div>
                <div id="quizPages" class="collapse" aria-labelledby="quizzes" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                           for="menu_quizInput">@lang('frontendmanage.Pages')
                                        <span class="text-danger">*</span>
                                    </label>


                                    <select name="quiz[]" id="menu_quizInput"
                                            class="multypol_check_select active  mb-15 e1"
                                            multiple>
                                        @foreach ($quizzes as $key => $quiz)
                                            <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="row">
                                        {{--                                        <div class="col-lg-5">--}}
                                        {{--                                            <input type="checkbox" id="quizCheckbox" class="common-checkbox">--}}
                                        {{--                                            <label for="quizCheckbox"--}}
                                        {{--                                                   class="mt-3">@lang('frontendmanage.Select All')</label>--}}
                                        {{--                                        </div>--}}
                                        <div class="col-lg-7">
                                            <button id="add_quiz_page_btn" type="submit"
                                                    class="primary-btn text-nowrap fix-gr-bg  mt-3   submit_btn"
                                                    data-bs-toggle="tooltip"
                                                    title="" data-original-title="">
                                                <i class="ti-check"></i>
                                                @lang('frontendmanage.Add Menu')
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header" id="liveClass">
                    <h5 class="mb-0 collapsed create-title" data-bs-toggle="collapse" data-bs-target="#liveClassPage"
                        aria-expanded="false" aria-controls="liveClassPage">
                        <button class="btn btn-link cust-btn-link add_btn_link">
                            @lang('frontendmanage.Live Class')
                        </button>
                    </h5>
                </div>
                <div id="liveClassPage" class="collapse" aria-labelledby="liveClass" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                           for="menu_classInput">@lang('frontendmanage.Pages')
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="class[]" id="menu_classInput"
                                            class="multypol_check_select active  mb-15 e1"
                                            multiple="multiple">
                                        @foreach ($classes as $key => $class)
                                            <option value="{{ $class->id }}">{{ $class->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="row">

                                        <div class="col-lg-7">
                                            <button id="add_class_page_btn" type="submit"
                                                    class="primary-btn text-nowrap fix-gr-bg mt-3 submit_btn"
                                                    data-bs-toggle="tooltip"
                                                    title="" data-original-title="">
                                                <i class="ti-check"></i>
                                                @lang('frontendmanage.Add Menu')
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header" id="customLink">
                    <h5 class="mb-0 collapsed create-title" data-bs-toggle="collapse" data-bs-target="#pages5"
                        aria-expanded="false" aria-controls="collapsePages">
                        <button class="btn btn-link cust-btn-link add_btn_link">
                            @lang('frontendmanage.Custom Links')
                        </button>
                    </h5>
                </div>
                <div id="pages5" class="collapse" aria-labelledby="customLink" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class='input-effect'>
                                    <label class="primary_input_label mt-1">@lang('common.Title')<span class="required_mark">*</span></label>
                                    <input class='primary_input_field' type='text' id="tTitle" name='title'
                                           data-error="{{__('validation.title.required')}}"
                                           autocomplete='off'>
                                    <span class='focus-border'></span>
                                </div>
                                <span class="text-danger" id="titleError"></span>
                            </div>
                            <div class="col-lg-12 mt-30 mb-30">
                                <div class='input-effect'>
                                    <label class="primary_input_label mt-1">@lang('frontendmanage.Link')</label>
                                    <input class='primary_input_field' type='text' id="tLink" name='link'
                                           autocomplete='off'>
                                    <span class='focus-border'></span>
                                </div>
                                <span class="text-danger" id="linkError"></span>
                            </div>
                            <div class="col-lg-12 text-center ">
                                <button id="add_custom_link_btn" type="submit"
                                        class="primary-btn text-nowrap fix-gr-bg   submit_btn"
                                        data-bs-toggle="tooltip" title="" data-original-title="">
                                    <i class="ti-check"></i>
                                    @lang('frontendmanage.Add Menu')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
