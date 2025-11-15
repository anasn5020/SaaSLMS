<div class="col-xl-12 mt-5 mt-lg-0  ">
    <div class="white-box ">


        <div class="main-title box_header common_table_header d-md-flex">
            <h3 class="mb-20" id="page_title">{{ __('virtual-class.Class List') }}</h3>

        @if (permissionCheck('virtual-class.index'))
                <ul class="d-flex">
                    <li>

                        <a class="primary-btn radius_30px   fix-gr-bg"
                           href="{{route('virtual-class.create')}}">
                            <i class="ti-plus"></i>{{__('common.Add')}} {{__('virtual-class.Class')}}
                             </a>
                    </li>
                </ul>
            @endif
        </div>

        <div class="QA_section QA_section_heading_custom check_box_table">
            <div class="QA_table">
                <!-- table-responsive -->
                <div class="">
                    <table id="lms_table" class="table Crm_table_active3">
                        <thead>
                        @if (session()->has('message-success-delete') != '' || session()->get('message-danger-delete') != '')
                            <tr>
                                <td colspan="5">
                                    @if (session()->has('message-success-delete'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message-success-delete') }}
                                        </div>
                                    @elseif(session()->has('message-danger-delete'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('message-danger-delete') }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th>{{ __('common.SL') }}</th>
                            <th>{{ __('virtual-class.Title') }}</th>
                            @if (isModuleActive('Org'))
                                <th>{{ __('courses.Required Type') }}</th>
                            @endif
                            <th>{{ __('virtual-class.Category') }}</th>
                            <th>{{ __('virtual-class.Sub Category') }}</th>
                            <th>{{ __('virtual-class.Language') }}</th>
                            <th>{{ __('virtual-class.Duration') }}</th>
                            @if (showEcommerce())
                                <th>{{ __('virtual-class.Fees') }}</th>
                            @endif
                            <th>{{ __('common.Total') }} {{ __('virtual-class.Class') }}</th>
                            <th>{{ __('virtual-class.Start Date') }}</th>
                            <th>{{ __('virtual-class.End Date') }}</th>
                            <th>{{ __('virtual-class.Time') }}</th>
                            <th>{{ __('virtual-class.Host') }}</th>
                            <th>{{ __('courses.Level') }}</th>
                            <th>{{ __('courses.View Scope') }}</th>
                            <th>{{ __('common.Status') }}</th>
                            <th>{{ __('common.Action') }}</th>
                        </tr>
                        </thead>


                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
