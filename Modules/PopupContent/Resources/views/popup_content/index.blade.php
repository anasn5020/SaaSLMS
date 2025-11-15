@extends('backend.master')
@section('styles')
    <style>
        #blogImgShow {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            max-height: 150px;
        }

        .img_div {
            display: flex;
            height: 150px;
            width: 150px;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">

                </div>
                <div class="col-12">
                    <div class="white-box student-details header-menu">
                        @include('popupcontent::popup_content.componant.form')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('popupcontent::popup_content.componant.scripts')
