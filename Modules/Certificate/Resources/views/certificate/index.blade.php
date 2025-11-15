@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/certificate.css')}}">
@endpush
@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row">
                @if(!isset($certificates))
                    @include('certificate::certificate.addEdit')
                @endif
                <div class="mt-4 mt-lg-0 {{isset($certificates) ? 'col-lg-12' : 'col-lg-8'}}">
                    <div class="white-box">

                        @isset($certificates)
                            <div class="main-title">
                                <h3 class="mb-20" id="page_title">{{__('certificate.Certificate List')}}</h3>
                            </div>
                        @else
                            <div class="main-title">
                                <h3 class="mb-20">{{__('certificate.Preview')}} (
                                    <span id="width"></span>
                                    x
                                    <span id="height"></span>
                                    )
                                    <small>
                                        {{__('certificate.All measurement depends on background height & width')}}
                                    </small>
                                </h3>
                            </div>
                        @endisset

                        @isset($certificates)
                            @include('certificate::certificate.certificateList')
                        @else
                            @include('certificate::certificate.preview')
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/course.js"></script>
    <script src="{{asset('public/backend/js/certificate.js')}}"></script>
    <script src="{{asset('public/js/html2pdf.bundle.js')}}"></script>

    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush
