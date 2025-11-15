@extends('backend.master')
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row justify-content-between">
                    <div class="col-md-12">

                        <div class="row student-details student-details_tab mt_0_sm m-0">

                            <!-- Start Sms Details -->
                            <div class="col-lg-12 p-0">
                                <ul class="nav nav-tabs no-bottom-border mt_0_sm mb-20 m-0 justify-content-start"
                                    role="tablist">
                                    <li class="nav-item mb-0">
                                        <a class="nav-link active" href="#group_email_sms" selectTab="G" role="tab"
                                           data-bs-toggle="tab">{{__('quiz.Instructor')}}  </a>
                                    </li>
                                    <li class="nav-item mb-0">
                                        <a class="nav-link" selectTab="I" href="#indivitual_email_sms" role="tab"
                                           data-bs-toggle="tab">{{__('quiz.Student')}}</a>
                                    </li>
                                    @if(isModuleActive('HumanResource'))
                                        @if ($roles->where('id',4)->first() != null)
                                            <li class="nav-item mb-0">
                                                <a class="nav-link" selectTab="S" href="#staff_section" role="tab"
                                                   data-bs-toggle="tab">{{__('attendance.Staff')}}</a>
                                            </li>
                                        @endif
                                    @endif

                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <input type="hidden" name="selectTab" id="selectTab">
                                    <div role="tabpanel" class="tab-pane fade active show" id="group_email_sms">

                                        <div class="QA_section QA_section_heading_custom check_box_table mt-20">
                                            <form action="{{route('UpdateUserNotificationControll')}}"
                                                  name="instructor_notification_setup_form"
                                                  class="instructor_notification_setup_form" method="POST">

                                                @csrf
                                                <input type="hidden" name="role_id" value="2">
                                                <div class="QA_table ">
                                                    <table class="Crm_table_active3">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">{{ __('common.SL') }}</th>
                                                            <th scope="col">{{ __('common.Name') }}</th>
                                                            <th>{{__('common.Status')}}</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        @php
                                                            $alreadyHave=[];
                                                        $i=1;
                                                        @endphp
                                                        @foreach($instructor_temps as $temp)
                                                            @php
                                                                if (!in_array($temp->template_act,$alreadyHave)){
                                                                    $alreadyHave[] =$temp->template_act;
                                                                }else{
                                                                    continue;
                                                                }
                                                                    if($temp['template']->is_system==1 || empty($temp['template']->name)){
                                                                        continue;
                                                                    }


                                                            @endphp
                                                            <tr>
                                                                <td>{{translatedNumber($i)}}</td>
                                                                <td>
                                                                    {{$temp['template']->subj}}
                                                                </td>
                                                                <td>
                                                                    <label class="primary_checkbox d-flex mr-12 "
                                                                           for="email_option_check_{{$temp->id}}"
                                                                           yes="">
                                                                        <input type="checkbox"
                                                                               id="email_option_check_{{$temp->id}}"
                                                                               name="status[{{$temp->id}}]"
                                                                               {{$temp->status==1? 'checked':''}}
                                                                               value="1">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $i++;
                                                            @endphp
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-lg-12 text-center mt-3">
                                                    <button class="primary-btn fix-gr-bg" type="submit"
                                                            data-bs-toggle="tooltip" title=""><i
                                                            class="ti-check"></i>
                                                        {{__('common.Update')}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>

                                    <div role="tabpanel" class="tab-pane fade
                                        @if(Session::has('isStudent'))
                                    @if(Session::get('isStudent'))
                                        show   active
                        @endif
                                    @endif
                                        " id="indivitual_email_sms">

                                        <div class="QA_section QA_section_heading_custom check_box_table mt-20">
                                            <form action="{{route('UpdateUserNotificationControll')}}"
                                                  name="student_notification_setup_form"
                                                  class="student_notification_setup_form" method="POST">

                                                @csrf
                                                <input type="hidden" name="role_id" value="3">
                                                <div class="QA_table ">

                                                    <!-- table-responsive -->
                                                    <table class="Crm_table_active3">
                                                        <thead>
                                                        <tr>

                                                            <th scope="col">{{ __('common.SL') }}</th>
                                                            <th scope="col">{{ __('common.Name') }}</th>
                                                            <th>{{__('common.Status')}}</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        @php
                                                            $alreadyHave=[];
                                                            $j=1;
                                                        @endphp
                                                        @foreach($students_temps as $temp)
                                                            @php
                                                                if (!in_array($temp->template_act,$alreadyHave)){
                                                                       $alreadyHave[] =$temp->template_act;
                                                                   }else{
                                                                       continue;
                                                                   }
                                                                   if($temp['template']->is_system==1 || empty($temp['template']->name)){
                                                                       continue;
                                                                   }
                                                            @endphp
                                                            <tr>
                                                                <td>{{translatedNumber($j)}}</td>
                                                                <td>
                                                                    {{$temp['template']->subj}}
                                                                </td>
                                                                <td>
                                                                    <label class="primary_checkbox d-flex mr-12 "
                                                                           for="email_option_check_{{$temp->id}}"
                                                                           yes="">
                                                                        <input type="checkbox"
                                                                               id="email_option_check_{{$temp->id}}"
                                                                               name="status[{{$temp->id}}]"
                                                                               {{$temp->status==1? 'checked':''}}
                                                                               value="1">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $j++;
                                                            @endphp
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-lg-12 text-center mt-3">
                                                    <button class="primary-btn fix-gr-bg" type="submit"
                                                            data-bs-toggle="tooltip" title=""><span
                                                            class="ti-check"></span>
                                                        {{__('common.Update')}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    @if(isModuleActive('HumanResource'))
                                        <div role="tabpanel" class="tab-pane fade
                                        @if(Session::has('isStudent'))
                                        @if(Session::get('isStudent'))
                                            show   active
                                        @endif
                                        @endif
                                            " id="staff_section">

                                            <div class="QA_section QA_section_heading_custom check_box_table mt-20">
                                                <form action="{{route('UpdateUserNotificationControll')}}"
                                                      name="staff_notification_setup_form"
                                                      class="staff_notification_setup_form"
                                                      method="POST">

                                                    @csrf
                                                    <input type="hidden" name="role_id" value="4">
                                                    <div class="QA_table ">
                                                        <!-- table-responsive -->
                                                        <table class="Crm_table_active3">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">{{ __('common.SL') }}</th>
                                                                <th scope="col">{{ __('common.Name') }}</th>
                                                                <th>{{__('common.Status')}}</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            @php
                                                                $k=1;
                                                            @endphp
                                                            @foreach($staffs_temps as $temp)
                                                                @php
                                                                    if($temp['template']->is_system==1){
                                                                        continue;
                                                                    }

                                                                    if($temp['template']->name==''){
                                                                        continue;
                                                                    }
                                                                @endphp
                                                                <tr>
                                                                    <td>{{translatedNumber($k)}}</td>
                                                                    <td>     {{$temp['template']->subj}}
                                                                    </td>
                                                                    <td>
                                                                        <label class="primary_checkbox d-flex mr-12 "
                                                                               for="email_option_check_{{$temp->id}}"
                                                                               yes="">
                                                                            <input type="checkbox"
                                                                                   id="email_option_check_{{$temp->id}}"
                                                                                   name="status[{{$temp->id}}]"
                                                                                   {{$temp->status==1? 'checked':''}}
                                                                                   value="1">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                                @php
                                                                    $k++;
                                                                @endphp
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-lg-12 text-center mt-30">
                                                        <button class="primary-btn fix-gr-bg" type="submit"
                                                                data-bs-toggle="tooltip" title=""><span
                                                                class="ti-check"></span>
                                                            {{__('common.Update')}}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            var table = $('.Crm_table_active3').DataTable(dataTableOptions);
            $('.dataTables_length label select').niceSelect();
            $('.dataTables_length label .nice-select').addClass('dataTable_select');
            // Handle form submission event
            $('.instructor_notification_setup_form').on('submit', function (e) {
                var form = this;
                var params = table.$('input,select,textarea').serializeArray();

                $.each(params, function () {
                    if (!$.contains(document, form[this.name])) {
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', this.name)
                                .val(this.value)
                        );
                    }
                });
            });
            $('.student_notification_setup_form').on('submit', function (e) {
                var form = this;
                var params = table.$('input,select,textarea').serializeArray();

                $.each(params, function () {
                    if (!$.contains(document, form[this.name])) {
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', this.name)
                                .val(this.value)
                        );
                    }
                });
            });
            $('.staff_notification_setup_form').on('submit', function (e) {
                var form = this;
                var params = table.$('input,select,textarea').serializeArray();

                $.each(params, function () {
                    if (!$.contains(document, form[this.name])) {
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
