@extends('backend.master')
@section('table')
    {{__('social_links')}}
@endsection
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <div class="white-box mb_30 ">
                        <form action="{{route('frontend.saveCourseSettings')}}" method="post" id="coupon-form"
                              name="coupon-form" enctype="multipart/form-data">

                            @csrf

                            <h2>{{__('common.Grid')}} {{__('common.View')}}</h2>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb_25">
                                        <label class="switch_toggle "
                                               for="show_rating">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_rating"
                                                   id="show_rating"
                                                   @if (@$data->show_rating == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('frontendmanage.Show Rating') }}
                                        {{-- <i class="ti-move  float-end"></i> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb_25">
                                        <label class="switch_toggle "
                                               for="show_cart">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_cart"
                                                   id="show_cart"
                                                   @if (@$data->show_cart == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('frontendmanage.Show Cart') }}


                                        {{-- <i class="ti-move  float-end"></i> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb_25 mt-40">
                                        <label class="switch_toggle "
                                               for="show_enrolled_or_level_section">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_enrolled_or_level_section"
                                                   id="show_enrolled_or_level_section"
                                                   @if (@$data->show_enrolled_or_level_section == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('frontendmanage.Show Enrolled or Course Level') }}
                                    </div>
                                </div>
                                <div class="col-lg-6" id="select_section"
                                     style="display: @if (@$data->show_enrolled_or_level_section == 1) block @else none @endif">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for=""> {{ __('frontendmanage.Select Enrolled or Level') }}
                                            <strong class="text-danger">*</strong></label>
                                        <select
                                            class="primary_select mb-25  {{ @$errors->has('enrolled_or_level') ? ' is-invalid' : '' }}"
                                            name="enrolled_or_level" id="enrolled_or_level">
                                            <option value="1"
                                                    @if ($data->enrolled_or_level==1) selected @endif > {{ __('frontendmanage.Enrolled Count') }} </option>
                                            <option value="2"
                                                    @if ($data->enrolled_or_level==2) selected @endif > {{ __('frontendmanage.Course Level') }} </option>
                                            <option value="3"
                                                    @if ($data->enrolled_or_level==3) selected @endif > {{ __('courses.Mode of Delivery') }} </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @push('js')
                                <script>
                                    let show_enrolled_or_level_section = $('#show_enrolled_or_level_section');
                                    let select_section = $('#select_section');
                                    show_enrolled_or_level_section.change(function () {
                                        if (show_enrolled_or_level_section.is(':checked')) {
                                            select_section.show();
                                        } else {
                                            select_section.hide();
                                        }
                                    });
                                </script>

                            @endpush
                            <hr>
                            <h2>{{__('courses.Category')}} {{__('common.View')}}</h2>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb_25 mt-40">
                                        <label class="switch_toggle "
                                               for="show_cql_left_sidebar">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_cql_left_sidebar"
                                                   id="show_cql_left_sidebar"
                                                   @if (@$data->show_cql_left_sidebar == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('frontendmanage.Show Left Sidebar from course/quiz/live class') }}
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6" id="grid_select_section" style="display: @if (@$data->show_cql_left_sidebar == 1) block @else none @endif"> --}}
                                <div class="col-lg-6" id="grid_select_section">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for=""> {{ __('frontendmanage.Select Grid Size') }}
                                            <strong class="text-danger">*</strong></label>
                                        <select
                                            class="primary_select mb-25  {{ @$errors->has('size_of_grid') ? ' is-invalid' : '' }}"
                                            name="size_of_grid" id="size_of_grid">
                                            <option value="4" @if ($data->size_of_grid==4) selected @endif > 3</option>
                                            <option value="3" @if ($data->size_of_grid==3) selected @endif > 4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-20">

                                <div class="col-lg-6">
                                    <div class="mb_25">
                                        <label class="switch_toggle "
                                               for="show_mode_of_delivery">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_mode_of_delivery"
                                                   id="show_mode_of_delivery"
                                                   @if (@$data->show_mode_of_delivery == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('courses.Show Mode of Delivery') }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb_25">
                                        <label class="switch_toggle "
                                               for="show_search_in_category">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_search_in_category"
                                                   id="show_search_in_category"
                                                   @if (@$data->show_search_in_category == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('courses.Show Search Box') }}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h2>{{__('common.Details')}} {{__('common.View')}}</h2>
                            <br>
                            <div class="row mt-20">
                                <div class="col-lg-6">
                                    <div class="mb_25">
                                        <label class="switch_toggle "
                                               for="show_rating_option">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_rating_option"
                                                   id="show_rating_option"
                                                   @if (@$data->show_rating_option == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('frontendmanage.Show Rating Section') }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb_25">
                                        <label class="switch_toggle "
                                               for="show_review_option">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_review_option"
                                                   id="show_review_option"
                                                   @if (@$data->show_review_option == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('frontendmanage.Show Review Section') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-lg-6">
                                    <div class="mb_25">
                                        <label class="switch_toggle "
                                               for="show_instructor_rating">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_instructor_rating"
                                                   id="show_instructor_rating"
                                                   @if (@$data->show_instructor_rating == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('frontendmanage.Show Instructor Rating') }}
                                        {{-- <i class="ti-move  float-end"></i> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb_25">
                                        <label class="switch_toggle "
                                               for="show_instructor_review">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_instructor_review"
                                                   id="show_instructor_review"
                                                   @if (@$data->show_instructor_review == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('frontendmanage.Show Instructor Reviews') }}


                                        {{-- <i class="ti-move  float-end"></i> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-lg-6">
                                    <div class="mb_25">
                                        <label class="switch_toggle "
                                               for="show_instructor_enrolled">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_instructor_enrolled"
                                                   id="show_instructor_enrolled"
                                                   @if (@$data->show_instructor_enrolled == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('frontendmanage.Show Enrolled Count') }}
                                        {{-- <i class="ti-move  float-end"></i> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb_25">
                                        <label class="switch_toggle "
                                               for="show_instructor_courses">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_instructor_courses"
                                                   id="show_instructor_courses"
                                                   @if (@$data->show_instructor_courses == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('frontendmanage.Show Total Courses') }}


                                        {{-- <i class="ti-move  float-end"></i> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center pt_20">
                                        <button type="submit" class="primary-btn semi_large fix-gr-bg"
                                                data-bs-toggle="tooltip"
                                                id="save_button_parent">
                                            <i class="ti-check"></i>
                                            @if(!isset($edit))
                                                {{ __('common.Save') }}
                                            @else
                                                {{ __('common.Update') }}
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('backend.partials.delete_modal')
@endsection
@push('scripts')

@endpush
