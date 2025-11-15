@extends('backend.master')
@section('mainContent')
    <style>
        .permission_list.sms_list li {
            margin-right: 15px;
        }

    </style>
    {{generateBreadcrumb()}}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid ">
            <div class="row justify-content-center white-box">
                <div class="col-12">
                    <form action="{{route('setting.media-manager.settingUpdate')}}" method="POST" id="DefaultStorage">
                        @csrf

                        <div class="col-xl-12">
                            <label class="primary_input_label"
                                   for="">{{ __('setting.Active File Storage') }}</label>
                            <ul id="" class="permission_list sms_list">
                                @foreach ($cloud_hosts as $key => $host)
                                    <li class="d-flex align-items-center justify-content-center">
                                        <label class="primary_checkbox d-flex mr-12 ">
                                            <input class="active_storage" name="active_storage"
                                                   type="radio" id="active_storage{{ $key }}"
                                                   value="{{$host}}"
                                                   @if ($host == old('active_storage',( Settings('active_storage')?Settings('active_storage'):'LocalStorage'))) checked @endif>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class=" " for="active_storage{{ $key }}">{{ $host }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @if(isModuleActive('AmazonS3'))
                            <div class="col-xl-12 cloud-form d-none media_login_area" id="AmazonS3Form">
                                @include('amazons3::_form')
                            </div>
                        @endif
                        @if(isModuleActive('BunnyStorage'))
                            <div class="col-xl-12 cloud-form d-none media_login_area" id="BunnyStorageForm">
                                @include('bunnystorage::_form')
                            </div>
                        @endif
                        <div class="col-xl-12 cloud-form d-none media_login_area" id="GoogleDriveForm">
                            @includeIf('setting::storage.partials._gdrive_form')
                        </div>

                        @if(isModuleActive('Storage'))
                            <div class="col-xl-12 cloud-form d-none media_login_area" id="DigitalOceanForm">
                                @include('storage::_digital_ocean_form')
                            </div>

                            <div class="col-xl-12 cloud-form d-none media_login_area" id="WasabiForm">
                                @include('storage::_wasabi_form')
                            </div>

                            <div class="col-xl-12 cloud-form d-none media_login_area" id="BackblazeForm">
                                @include('storage::_backblaze_form')
                            </div>

                            <div class="col-xl-12 cloud-form d-none media_login_area" id="DropboxForm">
                                @include('storage::_dropbox_form')
                            </div>

                            <div class="col-xl-12 cloud-form d-none media_login_area" id="ContaboForm">
                                @include('storage::_contabo_form')
                            </div>
                        @endif


                        <div class="col-12 p-0">
                            <div class="submit_btn d-flex justify-content-center align-items-center">
                                <button type="submit" class="primary-btn fix-gr-bg  " data-bs-toggle="tooltip"><i
                                        class="ti-check"></i> {{__('common.Save')}}</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')

    <script type="text/javascript">
        (function ($) {
            "use strict";

            $(document).ready(function () {

                $(document).on('change', '.active_storage', function () {
                    let active = $('input[name="active_storage"]:checked').val();
                    $('.cloud-form').addClass('d-none');
                    $('#' + active + 'Form').removeClass('d-none')
                });

                $('.active_storage').trigger('change');

                toggleField();

                $(document).on('click', 'input[type=radio][name=service_type]', function (event) {
                    toggleField();
                });

                function toggleField() {
                    let service = $('input[type=radio][name=service_type]:checked').val();
                    let streamService = $('.stream_service');
                    let storageService = $('.storage_service');
                    streamService.hide();
                    storageService.hide();
                    if (service === 'stream') {
                        streamService.show();
                    } else if (service === 'storage') {
                        storageService.show();
                    }
                }

                // $(document).on('click', '#submit_storage', function () {
                //     let file_storage = $("input[name='file_storage_type']:checked").val();
                //     console.log(file_storage);
                //     file_storage = file_storage.split('-');
                //     if (file_storage[0] == 'DigitalOcean') {
                //         $('#file_storage_do').val(file_storage[1])
                //         $('#DigitalOcean').submit();
                //     } else if (file_storage[0] == 'AmazonS3') {
                //         $('#file_storage_S3').val(file_storage[1])
                //         $('#AmazonS3').submit();
                //     } else if (file_storage[0] == 'GoogleDrive') {
                //         $('#file_storage_google_drive').val(file_storage[1])
                //         $('#GoogleDrive').submit();
                //     } else if (file_storage[0] == 'Wasabi') {
                //         $('#file_storage_wasabi').val(file_storage[1])
                //         $('#Wasabi').submit();
                //     } else if (file_storage[0] == 'Backblaze') {
                //         $('#file_storage_backblaze').val(file_storage[1])
                //         $('#Backblaze').submit();
                //     } else if (file_storage[0] == 'Dropbox') {
                //         $('#file_storage_dropbox').val(file_storage[1])
                //         $('#Dropbox').submit();
                //     } else if (file_storage[0] == 'GoogleCloud') {
                //         $('#file_storage_googlecloud').val(file_storage[1])
                //         $('#GoogleCloud').submit();
                //     } else if (file_storage[0] == 'BunnyCDN') {
                //         $('#file_storage_bunnycdn').val(file_storage[1])
                //         $('#BunnyCDN').submit();
                //     } else if (file_storage[0] == 'Contabo') {
                //         $('#file_storage_contabo').val(file_storage[1])
                //         $('#Contabo').submit();
                //     } else {
                //         $('#file_storage_default').val(file_storage[1])
                //         $('#DefaultStorage').submit();
                //     }
                // });
                // file_storage_form();
                // do_file_storage_form();
                // google_drive_file_storage_form();
                // wasabi_file_storage_form();
                // backblaze_file_storage_form();
                // dropbox_file_storage_form();
                // googlecloud_file_storage_form();
                // bunnycdn_file_storage_form();
                // contabo_file_storage_form();
                //
                // $(document).on('change', '.file_storage', function () {
                //     file_storage_form();
                //     do_file_storage_form();
                //     google_drive_file_storage_form();
                //     wasabi_file_storage_form();
                //     backblaze_file_storage_form();
                //     dropbox_file_storage_form();
                //     googlecloud_file_storage_form();
                //     bunnycdn_file_storage_form();
                //     contabo_file_storage_form();
                // });
                //
                // function file_storage_form() {
                //     let file_storage_type = $('.file_storage:checked').data("type");
                //     let aws3Div = $('#aws3_host_div');
                //     if (file_storage_type === 'AmazonS3') {
                //         aws3Div.show();
                //         let hiddenInput = $('<input>').attr({
                //             type: 'hidden',
                //             id: 'aws3_hidden_field',
                //             name: 'aws3',
                //             value: 1
                //         })
                //         hiddenInput.appendTo('#aws3_hidden_div');
                //     } else {
                //         aws3Div.hide();
                //         $('#aws3_hidden_div').html('');
                //     }
                // }
                //
                // function do_file_storage_form() {
                //     let file_storage_type = $('.file_storage:checked').data("type");
                //     let doDiv = $('#do_host_div');
                //     if (file_storage_type === 'DigitalOcean') {
                //         doDiv.show();
                //         let hiddenInput = $('<input>').attr({
                //             type: 'hidden',
                //             id: 'do_hidden_field',
                //             name: 'digitalocean',
                //             value: 1
                //         })
                //         hiddenInput.appendTo('#do_hidden_div');
                //     } else {
                //         doDiv.hide();
                //         $('#do_hidden_div').html('');
                //     }
                // }
                //
                // function google_drive_file_storage_form() {
                //     let file_storage_type = $('.file_storage:checked').data("type");
                //     let google_drive_Div = $('#google_drive_host_div');
                //     if (file_storage_type === 'GoogleDrive') {
                //         google_drive_Div.show();
                //         let hiddenInput = $('<input>').attr({
                //             type: 'hidden',
                //             id: 'google_drive_hidden_div',
                //             name: 'googledrive',
                //             value: 1
                //         })
                //         hiddenInput.appendTo('#google_drive_hidden_div');
                //     } else {
                //         google_drive_Div.hide();
                //         $('#google_drive_hidden_div').html('');
                //     }
                // }
                //
                // function wasabi_file_storage_form() {
                //     let file_storage_type = $('.file_storage:checked').data("type");
                //     let wasabi_Div = $('#wasabi_host_div');
                //     if (file_storage_type === 'Wasabi') {
                //         wasabi_Div.show();
                //         let hiddenInput = $('<input>').attr({
                //             type: 'hidden',
                //             id: 'wasabi_hidden_div',
                //             name: 'wasabi',
                //             value: 1
                //         })
                //         hiddenInput.appendTo('#wasabi_hidden_div');
                //     } else {
                //         wasabi_Div.hide();
                //         $('#wasabi_hidden_div').html('');
                //     }
                // }
                //
                // function backblaze_file_storage_form() {
                //     let file_storage_type = $('.file_storage:checked').data("type");
                //     let backblaze_Div = $('#backblaze_host_div');
                //     if (file_storage_type === 'Backblaze') {
                //         backblaze_Div.show();
                //         let hiddenInput = $('<input>').attr({
                //             type: 'hidden',
                //             id: 'backblaze_hidden_div',
                //             name: 'backblaze',
                //             value: 1
                //         })
                //         hiddenInput.appendTo('#backblaze_hidden_div');
                //     } else {
                //         backblaze_Div.hide();
                //         $('#backblaze_hidden_div').html('');
                //     }
                // }
                //
                // function dropbox_file_storage_form() {
                //     let file_storage_type = $('.file_storage:checked').data("type");
                //     let dropbox_Div = $('#dropbox_host_div');
                //     if (file_storage_type === 'Dropbox') {
                //         dropbox_Div.show();
                //         let hiddenInput = $('<input>').attr({
                //             type: 'hidden',
                //             id: 'dropbox_hidden_div',
                //             name: 'dropbox',
                //             value: 1
                //         })
                //         hiddenInput.appendTo('#dropbox_hidden_div');
                //     } else {
                //         dropbox_Div.hide();
                //         $('#dropbox_hidden_div').html('');
                //     }
                // }
                //
                // function googlecloud_file_storage_form() {
                //     let file_storage_type = $('.file_storage:checked').data("type");
                //     let googlecloud_Div = $('#google_cloud_host_div');
                //     if (file_storage_type === 'GoogleCloud') {
                //         googlecloud_Div.show();
                //         let hiddenInput = $('<input>').attr({
                //             type: 'hidden',
                //             id: 'google_cloud_hidden_div',
                //             name: 'googlecloud',
                //             value: 1
                //         })
                //         hiddenInput.appendTo('#google_cloud_hidden_div');
                //     } else {
                //         googlecloud_Div.hide();
                //         $('#google_cloud_hidden_div').html('');
                //     }
                // }
                //
                // function bunnycdn_file_storage_form() {
                //     let file_storage_type = $('.file_storage:checked').data("type");
                //     let bunnycdn_Div = $('#bunny_cdn_host_div');
                //     if (file_storage_type === 'BunnyCDN') {
                //         bunnycdn_Div.show();
                //         let hiddenInput = $('<input>').attr({
                //             type: 'hidden',
                //             id: 'bunny_cdn_hidden_div',
                //             name: 'bunnycdn',
                //             value: 1
                //         })
                //         hiddenInput.appendTo('#bunny_cdn_hidden_div');
                //     } else {
                //         bunnycdn_Div.hide();
                //         $('#bunny_cdn_hidden_div').html('');
                //     }
                // }
                //
                // function contabo_file_storage_form() {
                //     let file_storage_type = $('.file_storage:checked').data("type");
                //     let contabo_Div = $('#contabo_host_div');
                //     if (file_storage_type === 'Contabo') {
                //         contabo_Div.show();
                //         let hiddenInput = $('<input>').attr({
                //             type: 'hidden',
                //             id: 'contabo_hidden_div',
                //             name: 'contabo',
                //             value: 1
                //         })
                //         hiddenInput.appendTo('#contabo_hidden_div');
                //     } else {
                //         contabo_Div.hide();
                //         $('#contabo_hidden_div').html('');
                //     }
                // }
                //
                //
                //
                //
                //
                //
            });


        })(jQuery);

    </script>

@endpush
