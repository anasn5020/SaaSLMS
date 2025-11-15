@extends('backend.master')
@php
    $table_name='school_subjects';
@endphp
@section('table')
    {{$table_name}}
@endsection
@section('mainContent')

    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row row-gap-24">
                <div class="col-xxl-3">

                <div class="white-box mb_30  student-details header-menu">

                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex align-items-center mb-0">
                                <h3 class="mb-0" style="max-width: 80%;flex: 0 0 100%"> @if(!isset($edit))
                                        {{__('common.Add') }} {{__('common.New') }} {{__('courses.School Subjects') }}
                                    @else
                                        {{__('common.Update')}} {{__('courses.School Subjects') }}
                                    @endif</h3>
                                @if(isset($edit))
                                    @if (permissionCheck('schoolSubject.store'))
                                        <a href="{{route('schoolSubject')}}"
                                           class="primary-btn small fix-gr-bg"
                                           style="line-height: 25px;max-width: 20%;flex: 0 0 100%;height: max-content"
                                           title="{{__('courses.Add New')}}">+</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @if (isset($edit))
                            <form action="{{route('schoolSubject.update',$edit->id)}}" method="POST"
                                  id="category-form"
                                  name="category-form" enctype="multipart/form-data">
                                <input type="hidden" name="id"
                                       value="{{$edit->id}}">
                                @method('PATCH')
                                @else
                                    @if (permissionCheck('schoolSubject.store'))
                                        <form action="{{route('schoolSubject.store') }}" method="POST"
                                              id="category-form" name="category-form"
                                              enctype="multipart/form-data">
                                            @endif
                                            @endif
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
                                                </div>
                                            </div>

                                            <div class="row">


                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="order">{{ __('courses.Position Order') }}</label>
                                                        <select class="primary_select mb-25"
                                                                name="order"
                                                                id="order">
                                                            @for($i = $max_id; $i >= 1; $i--)
                                                                <option value="{{ $i }}" {{ isset($edit) ? ($edit->order == $i ? 'selected' : '') : (old('order') == $i ? 'selected' : '') }}>
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="status">{{ __('courses.Status') }}</label>
                                                        <select class="primary_select mb-25" name="status"
                                                                id="status"
                                                        >
                                                            <option
                                                                value="1" {{isset($edit)?($edit->status==1?'selected':''):''}}>{{__('common.Active') }}</option>
                                                            <option
                                                                value="0" {{isset($edit)?($edit->status==0?'selected':''):''}}>{{__('common.Inactive') }}</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12 text-center">
                                                    <div class="d-flex justify-content-center pt_20">
                                                        <button type="submit"
                                                                class="primary-btn semi_large fix-gr-bg"
                                                                data-bs-toggle="tooltip"
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
                                <h3 class="mb-0" id="page_title">{{__('courses.School Subjects') }}</h3>
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
                                            <th scope="col">{{ __('common.Position') }}</th>
                                            <th scope="col">{{ __('common.Status') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($subjects as $key => $subject)
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td> {{@$subject->name }}</td>
                                                <td> {{@$subject->order }}</td>
                                                <td class="nowrap">
                                                    <x-backend.status :id="$subject->id" :status="$subject->status"
                                                                      :route="'course.category.status_update'"></x-backend.status>

                                                </td>

                                                <td>
                                                    <!-- shortby  -->
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenu1{{@$subject->id}}"
                                                                data-bs-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropdownMenu1{{@$subject->id}}">
                                                            @if (permissionCheck('schoolSubject.edit'))
                                                                <a class="dropdown-item edit_brand"
                                                                   href="{{route('schoolSubject.edit',$subject->id)}}">{{__('common.Edit')}}</a>
                                                            @endif
                                                            @if (permissionCheck('schoolSubject.destroy'))
                                                                <a onclick="confirm_modal('{{route('schoolSubject.destroy', $subject->id)}}');"
                                                                   class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                            @endif
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


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush
