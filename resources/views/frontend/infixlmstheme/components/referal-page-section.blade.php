<div class="main_content_iner main_content_padding">
    <div class="dashboard_lg_card  mb-4 mb-lg-5">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12">
                    <div>
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('communication.Your referral link')}}</h3>
                                    <p>{{__('communication.Share the referral link with your friends.')}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="col-12">
                                    <div class="referral_copy_link mb_30">
                                        <div class="referral_copy_inner">
                                            <div class="single_input">
                                                <input type="text" id="referral_link"
                                                       placeholder="-"
                                                       readonly
                                                       value="{{route('referralCode',Auth::user()->referral)}}"
                                                       class="primary_input white_input">
                                            </div>
                                            <button onclick="copyCurrentUrl()"
                                                    class="theme_btn mt-3 height_50">{{__('communication.Copy Link')}}</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(count($referrals)!=0)
        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="row">
                    <div class="col-12">
                        <div class="p-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section__title3 mb_40">
                                        <h3 class="mb-0">{{__('communication.Your referral list')}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table custom_table3 mb-0">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('common.SL')}}</th>
                                                <th scope="col">{{__('common.User')}}</th>
                                                <th scope="col">{{__('common.Date')}}</th>
                                                <th scope="col">{{__('payment.Discount Amount')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($referrals))
                                                @foreach ($referrals as $key=> $referral)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>
                                                            <div
                                                                class="CourseMeta d-flex align-items-center">
                                                                <div class="profile_info">
                                                                    <img class=""
                                                                         src="{{getProfileImage(@$referral->image,$referral->name)}}"
                                                                         alt="">
                                                                </div>
                                                                <div class="reffer_meta">
                                                                    <a href="#"><h4
                                                                            class="font_16 f_w_400 mb-0 d-inline-block">{{@$referral->name}}</h4>
                                                                    </a>
                                                                    {{--                                                                    <a href="#"><p--}}
                                                                    {{--                                                                            class="font_14">{{@$referral->email}}</p>--}}
                                                                    {{--                                                                    </a>--}}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ showDate($referral->created_at) }}</td>
                                                        <td>{{Settings('currency_symbol') ??'৳'}}  {{@$referral->bonus_amount}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
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
    @endif

</div>
