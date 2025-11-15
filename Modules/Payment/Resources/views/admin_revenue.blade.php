@extends('backend.master')
@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="col-lg-12">
                    <div class="box_header">
                        <div class="main-title d-flex flex-wrap mb-0">
                            <h3 class="mb-0" id="page_title">{{__('payment.Admin Revenue')}}</h3>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <!-- table-responsive -->
                        <div class="">
                            <table id="lms_table" class="table Crm_table_active3">
                                <thead>
                                <tr>
                                    <th scope="col">{{__('courses.Course Title')}}</th>
                                    <th scope="col">{{__('courses.Instructor')}}</th>
                                    <th scope="col">{{__('courses.Price')}}</th>
                                    <th scope="col">{{__('courses.Publish')}}</th>
                                    <th scope="col">{{__('payment.Total')}} {{__('courses.Enrolled')}}</th>
                                    <th scope="col">{{__('courses.Revenue')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($courses as $course)
                                    <tr>
                                        <td scope="row">
                                            {{@$course->title}}
                                        </td>
                                        <td>{{@$course->user->name}}</td>

                                        <td>

                                            {{getPriceFormat($course->purchasePrice)}}
                                        </td>
                                        <td>

                                            {{ showDate(@$course->created_at??now()) }}
                                        </td>
                                        <td>{{translatedNumber($course->enrolls_count)}} </td>


                                        <td>
                                            <a href="{{route('admin.enrollLog',[@$course->id])}}" class="btn_1 light">
                                                {{getPriceFormat(@$course->reveune ?  (@$course->purchasePrice - @$course->sumRev) : 0)}}
                                            </a>
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
    </section>
@endsection
@push('scripts')
    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0,1, 2, 3,4,5]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>

@endpush
