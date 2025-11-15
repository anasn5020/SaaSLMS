@extends('backend.master')

@section('table')
    @php
        $table_name='why_chooses';
    @endphp
    {{$table_name}}
@stop
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3 mb-15">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="box_header common_table_header">
                                <div class="main-title d-flex flex-wrap mb-0">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px"> @if(!isset($why))
                                            {{__('frontendmanage.Add New Why Choose') }}
                                        @else
                                            {{__('common.Update')}}
                                        @endif</h3>
                                    @if(isset($why))

                                        <a href="{{route('frontend.why.index')}}"
                                           class="primary-btn small fix-gr-bg ms-3 "
                                           style="position: absolute;  right: 0;   margin-right: 15px;"
                                           title="{{__('coupons.Add')}}">+ </a>

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="white-box ">
                        <form action="{{isset($why)?route('frontend.why.update'):route('frontend.why.store')}}"
                              method="POST" id="coupon-form"
                              name="coupon-form"
                              enctype="multipart/form-data">@csrf
                            @if(isset($why))
                                <input type="hidden" name="id" value="{{$why->id}}">
                            @endif
                            @csrf
                            <div class="row">


                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="">{{ __('common.Title') }}*</label>
                                        <input name="title" id="title"
                                               class="primary_input_field name {{ @$errors->has('title') ? ' is-invalid' : '' }}"
                                               placeholder="{{ __('frontendmanage.Title') }}"
                                               type="text"
                                               value="{{isset($why)?$why->title:old('title')}}" {{$errors->has('title') ? 'autofocus' : ''}}>

                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="">{{ __('common.Sub Title') }}*</label>
                                        <input name="sub_title" id="sub_title"
                                               class="primary_input_field name {{ @$errors->has('sub_title') ? ' is-invalid' : '' }}"
                                               placeholder="{{ __('frontendmanage.Sub Title') }}"
                                               type="text"
                                               value="{{isset($why)?$why->sub_title:old('sub_title')}}" {{$errors->has('sub_title') ? 'autofocus' : ''}}>

                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="">{{__('frontendmanage.Image')}}*

                                        </label>
                                        <div class="primary_file_uploader">
                                            <input class="primary-input filePlaceholder" type="text"
                                                   placeholder="{{isset($why) && $why->image ? showPicName($why->image) :__('virtual-class.Browse Image file')}}"
                                                   readonly="" {{ $errors->has('image') ? ' autofocus' : '' }}>
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg"
                                                       for="document_file1">{{__('common.Browse')}}</label>
                                                <input type="file"
                                                       class="d-none fileUpload" name="image"
                                                       id="document_file1">
                                            </button>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center pt_20">
                                        <button type="submit" class="primary-btn semi_large fix-gr-bg"
                                                id="save_button_parent">
                                            <i class="ti-check"></i>
                                            @if(!isset($why))
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
                <div class="col-lg-9 ">
                    <div class="main-title">
                        <h3 class="mb-20">{{__('frontendmanage.Why Choose List')}}</h3>
                    </div>

                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.SL') }}</th>
                                        <th scope="col">{{ __('common.Title') }}</th>
                                        <th scope="col">{{ __('common.Sub Title') }}</th>
                                        <th scope="col">{{ __('common.Image') }}</th>
                                        <th scope="col">{{ __('common.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($whys as $key => $why)
                                        <tr>
                                            <th><span class="m-3">{{ $key+1 }}</span></th>
                                            <td>{{@$why->title }}</td>
                                            <td>{{@$why->sub_title }}</td>
                                            <td>
                                                <div>
                                                    <img style="max-width: 100px" src="{{asset(@$why->image)}}"
                                                         alt=""
                                                         class="img img-responsive m-2">
                                                </div>
                                            </td>

                                            <td>
                                                <!-- shortby  -->
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-bs-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu2">

                                                        <a class="dropdown-item edit_brand"
                                                           href="{{route('frontend.why.edit',$why->id)}}">{{__('common.Edit')}}</a>


                                                        <a onclick="confirm_modal('{{route('frontend.why.destroy', $why->id)}}');"
                                                           class="dropdown-item edit_brand">{{__('common.Delete')}}</a>

                                                    </div>
                                                </div>
                                                <!-- shortby  -->
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="edit_form">

    </div>
    <div id="view_details">

    </div>


    @include('backend.partials.delete_modal')
@endsection
@push('scripts')

@endpush
