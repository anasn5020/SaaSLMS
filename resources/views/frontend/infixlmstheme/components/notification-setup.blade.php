<div class="main_content_iner main_content_padding">
    <input type="hidden" id="url" value="{{url('/')}}">
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="">
                <div class="row">
                    <div class="col-12">
                        <div class="section__title3 d-flex w-100  justify-content-between align-items-center">
                            <h3 class=" ">{{ __('setting.Notification Setup') }} </h3>

                            <label class="primary_checkbox d-flex ml-12 gap-2"
                                   for="select_all">
                                <input type="checkbox" id="select_all"
                                       value="1">
                                <span class="checkmark"></span>
                                <span class="text-nowrap">{{__('common.Select')}} {{__('common.All')}}</span>
                            </label>

                        </div>
                    </div>
                    <style>
                        .unread_notification {
                            font-weight: bold;
                        }

                        .notifi_par {
                            font-weight: bold;
                        }

                        .notify_normal {
                            color: var(--system_secendory_color);
                        }
                    </style>
                    <div class="col-12">
                        <form action="{{route('update_notification_setup')}}" name="notification_setup_form"
                              id="notification_setup_form" method="POST">

                            @csrf
                            <div class="table-responsive">
                                <table class="table custom_table mb-0" style="width: 100%">
                                    <thead class="align-top">
                                    <tr>
                                        <th scope="col" class="ps-20">{{ __('common.Name') }}</th>
                                        <th scope="col">
                                            <div class="d-flex flex-column gap-3">
                                                {{ __('common.Email') }}
                                                <label class="primary_checkbox d-flex ml-12 gap-2 mb-0"
                                                       for="email_option_check">
                                                    <input type="checkbox" id="email_option_check"
                                                           class="select_all"
                                                           value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>


                                        </th>
                                        <th scope="col">
                                            <div class="d-flex flex-column gap-3">
                                                {{ __('common.Browser') }}
                                                <label class="primary_checkbox d-flex ml-12 gap-2 mb-0"
                                                       for="browser_option_check">
                                                    <input type="checkbox" id="browser_option_check"
                                                           class="select_all"
                                                           value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>


                                        </th>
                                        <th scope="col">
                                            <div class="d-flex flex-column gap-3">
                                                {{ __('setting.SMS') }}
                                                <label class="primary_checkbox d-flex ml-12 gap-2 mb-0"
                                                       for="sms_option_check">
                                                    <input type="checkbox" id="sms_option_check"
                                                           class="select_all"
                                                           value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>

                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $alreadyHave=[];
                                    @endphp
                                    @foreach ($templates as $key => $setup)
                                        @php
                                            if (!in_array($setup->template_act,$alreadyHave)){
                                                                 $alreadyHave[] =$setup->template_act;
                                                             }else{
                                                                 continue;
                                                             }
                                             if($setup['template']->is_system==1 || $setup['template']->name==null){
                                                 continue;
                                             }
                                        @endphp
                                        <tr>
                                            <td>
                                                {{@$setup['template']->subj}}
                                            </td>
                                            <td>
                                                <label class="primary_checkbox  d-flex mr-12 mb-0"
                                                       for="email_option_check_{{$setup->id}}" yes="">
                                                    <input type="checkbox" id="email_option_check_{{$setup->id}}"
                                                           class="email_option_check"
                                                           name="email[{{$setup['template']->act}}]"
                                                           {{isset($user_notification_setup)? in_array($setup['template']->act,$email_ids) ? 'checked':'':'checked'}}
                                                           value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="primary_checkbox d-flex ml-12 gap-2 mb-0"
                                                       for="browser_option_check_{{$setup->id}}" yes="">
                                                    <input type="checkbox" id="browser_option_check_{{$setup->id}}"
                                                           class="browser_option_check"
                                                           name="browser[{{$setup['template']->act}}]"
                                                           {{isset($user_notification_setup)? in_array($setup['template']->act,$browser_ids) ? 'checked':'':'checked'}}
                                                           value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="primary_checkbox d-flex ml-12 gap-2 mb-0"
                                                       for="sms_option_check_{{$setup->id}}" yes="">
                                                    <input type="checkbox" id="sms_option_check_{{$setup->id}}"
                                                           class="sms_option_check"
                                                           name="sms[{{$setup['template']->act}}]"
                                                           {{isset($user_notification_setup)? in_array($setup['template']->act,$sms_ids) ? 'checked':'':'checked'}}
                                                           value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <div class="col-12 text-center  ">
                                <button
                                    class="theme_btn   text-center mt_40">{{__('student.Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    checkEmail();
    checkBrowser();
    checkSMS();
    checkAll();

    function checkEmail() {
        let selectAll = $('#email_option_check');
        let totalEmail = $('.email_option_check').length;
        let totalSelectedEmail = $('.email_option_check:checked').length;

        if (totalEmail === totalSelectedEmail) {
            selectAll.prop('checked', true);
        } else {
            selectAll.prop('checked', false);
        }
    }


    $(document).on('change', '.email_option_check', function () {
        checkEmail()
        checkAll()
    });
    $(document).on('change', '#email_option_check', function () {
        $('.email_option_check').not(this).prop('checked', this.checked);
        checkEmail()
        checkAll()
    });


    function checkBrowser() {
        let selectAll = $('#browser_option_check');
        let totalEmail = $('.browser_option_check').length;
        let totalSelectedEmail = $('.browser_option_check:checked').length;

        if (totalEmail === totalSelectedEmail) {
            selectAll.prop('checked', true);
        } else {
            selectAll.prop('checked', false);
        }
    }


    $(document).on('change', '.browser_option_check', function () {
        checkBrowser()
        checkAll()
    });
    $(document).on('change', '#browser_option_check', function () {
        $('.browser_option_check').not(this).prop('checked', this.checked);
        checkBrowser()
        checkAll()
    });


    function checkSMS() {
        let selectAll = $('#sms_option_check');
        let totalEmail = $('.sms_option_check').length;
        let totalSelectedEmail = $('.sms_option_check:checked').length;

        if (totalEmail === totalSelectedEmail) {
            selectAll.prop('checked', true);
        } else {
            selectAll.prop('checked', false);
        }
    }


    $(document).on('change', '.sms_option_check', function () {
        checkSMS()
        checkAll()
    });
    $(document).on('input', '#sms_option_check', function () {
        $('.sms_option_check').not(this).prop('checked', this.checked);
        checkSMS()
        checkAll()
    });


    function checkAll() {
        let selectAll = $('#select_all');
        let total = $('.select_all').length;
        let totalSelected = $('.select_all:checked').length;
        if (total === totalSelected) {
            selectAll.prop('checked', true);
        } else {
            selectAll.prop('checked', false);
        }
    }


    $(document).on('change', '.select_all', function () {
        checkAll()
    });
    $(document).on('change', '#select_all', function () {
        $('.select_all').trigger('click')
        $('.select_all').not(this).prop('checked', this.checked);
        checkAll()
    });
</script>
