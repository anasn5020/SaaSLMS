@php use Illuminate\Support\Facades\Auth; @endphp
@extends('backend.master')
@php
    $table_name='institutes';
@endphp
@section('table')
    {{$table_name}}
@endsection
@section('mainContent')
    @php
        $LanguageList = getLanguageList();
    @endphp
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-xxl-3">
                    <div class="white-box mb_30  student-details header-menu">
                        <div class="box_header common_table_header">
                            <div class="main-title d-flex mb-0">
                                <h3 class="mb-0"> @if(!isset($edit))
                                        {{__('common.New') }}  {{__('student.Institute') }}
                                    @else
                                        {{__('common.Update') }}  {{__('student.Institute') }}
                                    @endif</h3>
                                @if(isset($edit))
                                    <a href="{{route('student.institute.index')}}"
                                       class="primary-btn small fix-gr-bg ml-4 d-flex justify-content-center align-items-center"
                                       style="line-height: 25px;"
                                       title="{{__('courses.Add New')}}">+</a>
                                @endif
                            </div>
                        </div>


                        <form
                            action="{{isset($edit)?route('student.institute.update',$edit->id):route('student.institute.store')}}"
                            method="POST"
                            id="category-form"
                            name="category-form" enctype="multipart/form-data">
                            <input type="hidden" name="id"
                                   value="{{$edit->id??''}}">
                            @csrf

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="nameInput">{{ __('common.Name') }}
                                            <strong
                                                class="text-danger">*</strong></label>
                                        <input name="name"
                                               id="nameInput"
                                               class="primary_input_field name {{ @$errors->has('name') ? ' is-invalid' : '' }}"
                                               placeholder="{{ __('common.Name') }}"
                                               type="text"
                                               value="{{isset($edit)?$edit->name:''}}">

                                    </div>
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="nameInput">{{ __('common.Address') }}
                                        </label>
                                        <input name="address"
                                               id="nameInput"
                                               class="primary_input_field name  "
                                               placeholder="{{ __('common.Address') }}"
                                               type="text"
                                               value="{{isset($edit)?$edit->address:''}}">

                                    </div>
                                </div>
                            </div>
                            <div class="row">


                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center pt_20">
                                        <button type="submit"
                                                class="primary-btn semi_large fix-gr-bg"
                                                id="save_button_parent">
                                            <i class=" fa fa-check "></i>
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
                <div class="col-xxl-9">
                     <div class="white-box">
                        <div class="box_header common_table_header">
                            <div class="main-title d-flex flex-wrap mb-0">
                                <h3 class="mb-0" id="page_title">{{__('student.Institute List')}}</h3>
                            </div>
                        </div>
                        <div class="  QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table id="lms_table" class="table table-data">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            <th scope="col">{{ __('common.Name') }}</th>
                                            <th scope="col">{{ __('common.Address') }}</th>
                                            <th scope="col">{{ __('common.Status') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($institutes as $key => $institute)
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td> {{@$institute->name }}</td>
                                                <td> {{@$institute->address }}</td>


                                                <td class="nowrap">
                                                    <x-backend.status :id="$institute->id"
                                                                      :status="$institute->status"
                                                                      :route="'course.category.status_update'"></x-backend.status>

                                                </td>

                                                <td>
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenu1{{@$institute->id}}"
                                                                data-bs-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>


                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropdownMenu1{{@$institute->id}}">
                                                            <a class="dropdown-item edit_brand"
                                                               href="{{route('student.institute.edit',$institute->id)}}">{{__('common.Edit')}}</a>
                                                            <a onclick="confirm_modal('{{route('student.institute.delete', $institute->id)}}');"
                                                               class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                        </div>
                                                    </div>

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
        </div>
    </section>


    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3,]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush
