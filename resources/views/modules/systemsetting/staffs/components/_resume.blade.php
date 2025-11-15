@extends('backend.master')

@push('styles')
    <link href="{{asset('public/frontend/infixlmstheme/css/my_invoice.css')}}" rel="stylesheet"/>
@endpush

@section('mainContent')
    @include("backend.partials.alertMessage")

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{__('common.My Profile')}}</h3>
                            <ul class="d-flex">
                                @if(permissionCheck('staffs.document.upload'))
                                    <li><a class="primary-btn radius_30px   fix-gr-bg"
                                           href="{{route('staffs.document.upload')}}"><i
                                                class="ti-plus"></i>{{ __('common.Document') }}</a></li>
                                @endif
                                <li><a class="primary-btn radius_30px   fix-gr-bg"
                                       href="{{route('updatePassword')}}">{{ __('common.Update Profile') }}</a></li>
                                <button class="primary_btn downloadBtn" type="submit"><i class="ti-download"></i> PDF
                                </button>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="invoice_print pb-5">
                        <div class="container-fluid p-0">
                            <div id="invoice_print" class="invoice_part_iner">
                                <table style=" margin-bottom: 30px" class="table">
                                    <tbody>
                                    <td>
                                        <img style="width: 108px" src="{{ asset($user->avatar) }}"
                                             alt="{{ Settings('site_name')  }}">
                                    </td>
                                    </tbody>
                                </table>

                                <table style="margin-bottom: 0 !important;" class="table">
                                    <tbody>
                                    <tr>
                                        <td class="w-100">
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{__('common.Name')}}: </span><span>{{ $user->name }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{__('common.Email')}}: </span><span>{{ $user->email }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{__('common.Date of Birth')}}: </span><span>{{ $user->dob ? showDate($user->dob) : '' }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span class="black_color">{{__('common.Phone')}}</span>
                                                <span class="black_color">{{ $user->phone ?? 000000000}}</span>
                                            </p>

                                            <p class="invoice_grid"
                                            >
                                                <span class="black_color">{{__('common.Salary Per Hour')}}</span>
                                                <span class="black_color">${{ $user->salary_per_hour ?? 8}}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{ __('common.Current Address') }}: </span><span>{{ $user->staff->current_address ?? '' }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{ __('common.Permanent Address') }}: </span><span>{{ $user->staff->permanent_address ?? '' }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{__('common.Zip Code')}}: </span><span>{{ $user->zip ?? 0000}}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{__('common.Country')}}: </span><span>{{$user->country ?? 'Bangladesh'}}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{__('common.Gender')}}: </span><span>{{ $user->gender ?? 'Not Specified' }}</span>
                                            </p>

                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{__('common.Degree Level')}}: </span><span>{{ $user->degree_level ?? 'Graduation'  }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{__('common.Expertise Area')}}: </span><span>{{ $user->expertise_area ?? ''  }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{__('common.Social Link')}}: </span>
                                                <span>
                                                     @if($user->facebook)
                                                        <a target="_blank" href="{{$user->facebook}}" class=""
                                                           title="Facebook"><i class="fab fa-facebook-square"></i></a>
                                                    @endif
                                                    @if($user->linkedin)
                                                        <a target="_blank" href="{{$user->linkedin}}" class=""
                                                           title="Linkedin"><i class="fab fa-linkedin"></i></a>
                                                    @endif
                                                    @if($user->twitter)
                                                        <a target="_blank" href="{{$user->twitter}}" class=""
                                                           title="Linkedin"><i class="fab fa-twitter-square"></i></a>
                                                    @endif
                                                    @if($user->instagram)
                                                        <a target="_blank" href="{{$user->instagram}}" class=""
                                                           title="Linkedin"><i class="fab fa-instagram"></i></a>
                                                    @endif
                                                    @if($user->youtube)
                                                        <a target="_blank" href="{{$user->youtube}}" class=""
                                                           title="Linkedin"><i class="fab fa-youtube"></i></a>
                                                    @endif
                                                </span>

                                            </p>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('public/frontend/infixlmstheme') }}/js/html2pdf.bundle.js"></script>
    <script src="{{ asset('public/frontend/infixlmstheme/js/my_invoice.js') }}"></script>
@endsection


@push('scripts')
    <script src="{{ asset('public/frontend/infixlmstheme') }}/js/html2pdf.bundle.js"></script>
    <script src="{{ asset('public/frontend/infixlmstheme/js/my_invoice.js') }}"></script>
@endpush
