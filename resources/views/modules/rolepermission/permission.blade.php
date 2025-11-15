@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/role_module_style.css')}}">
@endpush
@section('mainContent')
    <style>
        .erp_role_permission_area .single_permission .permission_header {
            min-height: 47px;
        }

        .module_link_option_div {
            display: flex;
        }

        .erp_role_permission_area .single_permission .permission_header div {
            display: flex;
            left: -13px;
        }
    </style>
    {!! generateBreadcrumb() !!}

    <div class="white-box">
        <div class="role_permission_wrap">
            <div class="permission_title main-title">
                <h3>{{__('role.assign_permission')}} </h3>

            </div>
        </div>
        <form method="POST" action="{{ route('permission.permissions.store') }}" class="form-horizontal"
              enctype="multipart/form-data">
            @csrf
            <div class="erp_role_permission_area mesonary_role_header ">
                <!-- single_permission  -->
                <input type="hidden" name="role_id" value="{{@$role->id}}">
                @foreach($sections as $section)
                    <div class="row">
                        @if ($role->id!=3)
                            <div class="col-sm-12 mb-2">
                                     {{$section->name}}

                                <a class=" btn-modal ms-2"
                                   data-container="#commonModal" type="button"
                                   href="{{route('sidebar-manager.section-edit-form',$section->id)}}?type=module"
                                >
                                    <i class="ti-pencil-alt" style="    color: var(--icon-color);"></i>
                                </a>


                            </div>
                        @endif
                        <div class="col-sm-12">
                            <div class="">
                                @php
                                    if ($role->id==3){
                                          $modules =$section->frontendPermissions->where('type',1)->where('menu_status',1);
                                    }else{
                                     $modules =$section->permissions->where('type',1)->where('menu_status',1);
                                    }
                                @endphp

                                @foreach ($modules as $key => $Module)
                                    @if(!$Module->module ||  isModuleActive($Module->module))
                                        @include('rolepermission::page-components.permissionModule',[ 'key' =>$key, 'Module' =>$Module ])
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mt-40 mb-40">
                <div class="col-lg-12 text-center d-flex justify-content-center">
                    <button type="submit" class="primary-btn semi_large fix-gr-bg">
                        <i class="ti-check"></i>
                        {{__('common.Submit')}}
                    </button>
                </div>
            </div>

        </form>
        <input type="hidden" id="menu_section_url" value="{{route("sidebar-manager.section-edit")}}">
        <input type="hidden" id="menu_edit_url" value="{{route("sidebar-manager.menu-edit")}}">

    </div>
@endsection
@push('scripts')
    <script src="{{asset('public/backend/js/permission.js')}}"></script>
    <script>
        let token = $('meta[name="csrf-token"]').attr('content');

        $(document).on('click', '#menuUpdate', function () {
            showPreLoader();

            let formElement = $('#menuEditForm').serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name, element.value);
            });

            formData.append('_token', token);


            $.ajax({
                url: $('#menu_edit_url').val(),
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    $('#commonModal').modal('hide');
                    location.reload();
                },
                error: function (response) {
                    hidePreLoader()

                    $.each(response.responseJSON.errors, function (k, v) {
                        toastr.error(v);
                    });
                }
            });


        });

        $(document).on('click', '#sectionUpdate', function () {
            showPreLoader();
            let formElement = $('#sectionEditForm').serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name, element.value);
            });

            formData.append('_token', token);

            $.ajax({
                url: $('#menu_section_url').val(),
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    $('#commonModal').modal('hide');
                    location.reload();
                },
                error: function (response) {
                    hidePreLoader()
                    $.each(response.responseJSON.errors, function (k, v) {
                        toastr.error(v);
                    });
                }
            });

        });

        function showPreLoader() {
            $('.preloader').fadeIn('slow');

        }

        function hidePreLoader() {
            $('.preloader').fadeOut('slow');

        }
    </script>
@endpush
