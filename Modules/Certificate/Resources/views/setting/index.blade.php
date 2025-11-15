@extends('backend.master')

@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">

                            <form class="form-horizontal" method="POST" action="{{ route('certificate.setting') }}" enctype="multipart/form-data">
                                @csrf


                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-12 mb-10">
                                            <div class="primary_input">
                                                <div class="row">
                                                    <div class="col-md-12 ">
                                                        <label class="primary_input_label"
                                                               for=""> {{__('certificate.Manually assign certificate')}}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-1 col-sm-3 mb-25">
                                                        <label class="primary_checkbox d-flex mr-12 w-100">
                                                            <input type="radio" id="type1"
                                                                   name="manually_assign_certificate"
                                                                   value="1"
                                                                {{Settings('manually_assign_certificate') == '1' ? 'checked' :''}}
                                                            >
                                                            <span
                                                                class="checkmark me-2"></span>
                                                            {{__('common.Yes')}}
                                                        </label>
                                                    </div>
                                                    <div class="col-md-1 col-sm-3 mb-25  ">
                                                        <label class="primary_checkbox d-flex mr-12">
                                                            <input type="radio" id="type2"
                                                                   name="manually_assign_certificate"
                                                                   value="0"
                                                                {{Settings('manually_assign_certificate') != '1' ? 'checked' :''}}
                                                            >
                                                            <span class="checkmark me-2"></span>
                                                            {{__('common.No')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row  ">
                                        <div class="col-lg-12 text-center">
                                            <button type="submit" class="primary-btn fix-gr-bg"
                                                    id="">
                                                <i class="ti-check"></i>
                                                {{__('common.Update')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

