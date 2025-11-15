@extends('backend.master')
@section('mainContent')
    @push('styles')
        <link href="{{asset('public/backend/vendors/nestable/jquery.nestable.min.css')}}" rel="stylesheet">
        <link href="{{asset('public/backend/css/headermenu.css')}}" rel="stylesheet">
        <style>
            .dd-handle .float-start {
                width: calc(100% - 80px);
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 1;
                line-clamp: 1;
                -webkit-box-orient: vertical;
            }
        </style>
    @endpush


    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h3 class="mb-20">
                                        @lang('common.Add') @lang('frontendmanage.Header Menu')
                                    </h3>
                                </div>
                                @include('frontendmanage::headermenu.menu_list')

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-4 g-0 ">
                                <div class="main-title">
                                    <h3 class="mb-20">@lang('frontendmanage.Menu List')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" id="menuList">
                                @include('frontendmanage::headermenu.submenu_list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Delete Modal Start --}}
        <div class="modal fade admin-query" id="deleteSubmenuItem">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('common.Delete') @lang('frontendmanage.Sub Menu')</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <h4>@lang('common.Are you sure to delete ?')</h4>
                        </div>
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">@lang('common.Cancel')</button>
                            <input type="hidden" name="id" id="item-delete" value="">
                            <a class="primary-btn fix-gr-bg" id="delete-item" href="#">@lang('common.Delete')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="headermenu_reordering_url" value="{{route('frontend.headermenu.reordering')}}">
        <input type="hidden" id="headermenu_delete_url" value="{{ route('frontend.headermenu.delete') }}">
        <input type="hidden" id="headermenu_edit_url" value="{{route('frontend.headermenu.edit-element')}}">
        <input type="hidden" id="headermenu_add_url" value="{{route('frontend.headermenu.add-element')}}">
        <input type="hidden" id="header_token" value="{{csrf_token()}}">
        {{-- Delete Modal End --}}
    </section>
    @push('scripts')
        <script src="{{asset('public/backend/vendors/nestable/jquery.nestable.min.js')}}"></script>
        <script src="{{asset('public/backend/js/headermenu.js')}}"></script>
    @endpush
@endsection
