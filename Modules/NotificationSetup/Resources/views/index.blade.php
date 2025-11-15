@extends('backend.master')
@php
    $table_name='categories';
@endphp
@section('table')
    {{$table_name}}
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            var table = $('.Crm_table_active3').DataTable();

            // Handle form submission event
            $('#notification_setup_form').on('submit', function (e) {
                var form = this;

                // Encode a set of form elements from all pages as an array of names and values
                var params = table.$('input,select,textarea').serializeArray();

                // Iterate over all form elements
                $.each(params, function () {
                    // If element doesn't exist in DOM
                    if (!$.contains(document, form[this.name])) {
                        // Create a hidden element
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', this.name)
                                .val(this.value)
                        );
                    }
                });
            });
        });
    </script>
@endpush
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-flex flex-wrap mb-0">
                                <h3 class="mb-0">{{ __('setting.Notification') }} {{ __('common.List') }}</h3>
                            </div>
                        </div>
                        <div class="  QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                {{-- <form action="{{route('update_notification_setup')}}" id="frm-example" method="post"> --}}
                                <form action="{{route('update_notification_setup')}}" name="notification_setup_form"
                                      id="notification_setup_form" method="POST">

                                    @csrf

                                    <div class="">
                                        <table class="table Crm_table_active3">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{ __('common.SL') }}</th>
                                                <th scope="col">{{ __('common.Name') }}</th>
                                                <th scope="col">{{ __('common.Email') }}</th>
                                                <th scope="col">{{ __('common.Browser') }}</th>
                                                <th scope="col">{{ __('setting.SMS') }}</th>
                                                <th scope="col">{{ __('setting.Push Notification') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                            $index=0;
                                            @endphp
                                            @foreach ($templates as $key => $setup)
                                                @php
                                                    if($setup['template']->is_system==1 || $setup['template']->name==null){
                                                        continue;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{++$index}}</td>
                                                    <td>
                                                        {{@$setup['template']->subj}}
                                                    </td>
                                                    <td>
                                                        <label class="primary_checkbox d-flex mr-12 "
                                                               for="email_option_check_{{$setup->id}}" yes="">
                                                            <input type="checkbox"
                                                                   id="email_option_check_{{$setup->id}}"
                                                                   name="email[{{$setup['template']->act}}]"
                                                                   {{isset($user_notification_setup)? in_array($setup['template']->act,$email_ids) ? 'checked':'':'checked'}}
                                                                   value="1">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="primary_checkbox d-flex mr-12 "
                                                               for="browser_option_check_{{$setup->id}}" yes="">
                                                            <input type="checkbox"
                                                                   id="browser_option_check_{{$setup->id}}"
                                                                   name="browser[{{$setup['template']->act}}]"
                                                                   {{isset($user_notification_setup)? in_array($setup['template']->act,$browser_ids) ? 'checked':'':'checked'}}
                                                                   value="1">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="primary_checkbox d-flex mr-12 "
                                                               for="sms_option_check_{{$setup->id}}" yes="">
                                                            <input type="checkbox" id="sms_option_check_{{$setup->id}}"
                                                                   name="sms[{{$setup['template']->act}}]"
                                                                   {{isset($user_notification_setup)? in_array($setup['template']->act,$sms_ids) ? 'checked':'':'checked'}}
                                                                   value="1">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="primary_checkbox d-flex mr-12 "
                                                               for="mobile_option_check_{{$setup->id}}" yes="">
                                                            <input type="checkbox"
                                                                   id="mobile_option_check_{{$setup->id}}"
                                                                   name="mobile[{{$setup['template']->act}}]"
                                                                   {{isset($user_notification_setup)? in_array($setup['template']->act,$mobile_ids) ? 'checked':'':'checked'}}
                                                                   value="1">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-12 mt-30 text-center">
                                        <button class="primary-btn fix-gr-bg" type="submit" data-bs-toggle="tooltip"
                                                title="">
                                            <i class="ti-check"></i>
                                            {{__('common.Update')}}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <input type="hidden" name="status_route" class="status_route" value="{{ route('course.category.status_update') }}">
    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script src="{{asset('public/backend/js/category.js')}}"></script>
@endpush
