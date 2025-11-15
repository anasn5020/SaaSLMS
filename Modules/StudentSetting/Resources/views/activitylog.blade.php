@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/student_list.css')}}"/>
@endpush


@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">

                <div class="col-lg-12 mt-40">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        <th scope="col">{{__('common.Date')}}</th>
                                        <th scope="col">{{__('frontend.OS')}}</th>
                                        <th scope="col">{{__('frontend.Browser')}}</th>
                                        <th scope="col">{{__('frontend.LogOut Date')}}</th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($logins))
                                        @foreach ($logins as $key=> $login)
                                            <tr>
                                                <td scope="row">{{translatedNumber($key+1)}}</td>
                                                <td>{{ showDate($login->login_at) }}</td>
                                                <td>{{$login->os}}</td>
                                                <td>{{$login->browser}}</td>
                                                <td>{{ $login->logout_at ? showDate($login->logout_at) : trans('common.N/A') }}</td>
                                                <td>
                                                    @php
                                                        $ip = request()->ip();
                                                        $browser = Browser::browserName();
                                                        $os = Browser::platformName();
                                                    @endphp
                                                    @if(empty($login->logout_at))
                                                        <a href="#" data-bs-toggle="modal"
                                                           data-bs-target="#logOut" data-id="{{$login->id}}"
                                                           class="primary-btn radius_30px   fix-gr-bg text-white logoutBtn w-fit">{{__('frontend.Logout from system')}}</a>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade admin-query" id="logOut">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">  {{__('student.Student')}} {{__('frontend.Logout from system')}} </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                        class="ti-close "></i></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{route('log.out.device')}}" method="post">
                                    @csrf

                                    <div class="text-center">

                                        <h4>{{__('common.Are you sure')}}? </h4>
                                        <p>{{__('common.Note')}}
                                            : {{__('student.This feature allows students to login on other devices while crossing device limits')}}</p>
                                    </div>
                                    <input type="hidden" name="id" value="" id="studentId">
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                                        <button class="primary-btn fix-gr-bg"
                                                type="submit">{{__('frontend.LogOut')}}</button>

                                    </div>
                                </form>
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
        $(document).on('click', '.logoutBtn', function () {
            let id = $(this).data('id');
            $('#studentId').val(id);
        });

    </script>

@endpush
