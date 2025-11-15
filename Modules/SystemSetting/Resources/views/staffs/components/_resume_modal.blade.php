<div class="modal fade admin-query" id="resume_staff_modal">
    <div class="modal-dialog modal_1000px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Resume of {{$user->name}}</h4>
                <button type="button" class="close " data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
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
                                                    class="black_color">{{ __('common.Name') }}: {{ $user->name }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{ __('common.Email') }}: {{ $user->email }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{ __('common.Date of Birth') }}: {{ $user->staff->date_of_birth ? showDate($user->staff->date_of_birth) : '' }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span class="black_color">{{ __('common.Phone') }}: </span>
                                                <span class="black_color">{{ $user->phone ?? 000000000}}</span>
                                            </p>

                                            <p class="invoice_grid"
                                            >
                                                <span class="black_color">{{ __('common.Basic Salary') }}: </span>
                                                <span
                                                    class="black_color">{{ getPriceFormat($user->staff->basic_salary)}}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{ __('common.Current Address') }}: {{ $user->staff->current_address ?? '' }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{ __('common.Permanent Address') }}: {{ $user->staff->permanent_address ?? '' }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{ __('common.Current Address') }}: {{ $user->staff->current_address }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{ __('common.Permanent Address') }}: {{ $user->staff->permanent_address }}</span>
                                            </p>
                                            @if($user->degree_level)
                                                <p class="invoice_grid"
                                                >
                                                <span
                                                    class="black_color">{{__('frontend.Degree Level')}}: {{ $user->degree_level ?? ''  }}</span>
                                                </p>
                                            @endif
                                            @if($user->expertise_area)
                                                <p class="invoice_grid"
                                                >
                                                <span
                                                    class="black_color">{{__("frontend.Expertise Area")}}: {{ $user->expertise_area ?? ''  }}</span>
                                                </p>
                                            @endif
                                            <p class="invoice_grid"
                                            >
                                                <span
                                                    class="black_color">{{__('frontend.Social Links')}}: </span>
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
    </div>
</div>
