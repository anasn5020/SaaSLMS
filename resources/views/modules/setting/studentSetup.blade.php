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
                        <form action="{{route('settings.student_setup_update')}}" method="post" id="coupon-form"
                              name="coupon-form" enctype="multipart/form-data">

                            @csrf

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb_25">
                                        <label class="switch_toggle "
                                               for="show_recommended_section">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_recommended_section"
                                                   id="show_recommended_section"
                                                   @if (@$data->show_recommended_section == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('frontendmanage.Show Recommended Section') }}
                                        {{-- <i class="ti-move  float-end"></i> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb_25">
                                        <label class="switch_toggle "
                                               for="show_running_course_thumb">
                                            <input type="checkbox" class="status_enable_disable"
                                                   name="show_running_course_thumb"
                                                   id="show_running_course_thumb"
                                                   @if (@$data->show_running_course_thumb == 1) checked
                                                   @endif value="1">
                                            <i class="slider round"></i>


                                        </label>
                                        {{ __('frontendmanage.Show Running Course Thumbnail') }}
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
