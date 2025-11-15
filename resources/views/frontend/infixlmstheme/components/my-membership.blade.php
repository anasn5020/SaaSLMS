<div class="main_content_iner main_content_padding">

    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">

            <div class="row">
                <div class="col-12">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{ __('membership.My Membership') }}</h3>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table custom_table3 mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            {{--                                            <th scope="col">{{ __('membership.Membership Number') }}</th>--}}
                                            <th scope="col">{{ __('membership.Plan') }}</th>
                                            <th scope="col">{{ __('common.Start Date') }}</th>
                                            <th scope="col">{{ __('membership.End Date') }}</th>
                                            <th scope="col">{{ __('certificate.Certificate') }}</th>
                                            <th>{{ __('membership.Update Level') }} <br></th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($checkouts as $key => $checkout)
                                            <tr>
                                                <td class="m-2">{{ $key+1 }}</td>
                                                {{--                                                <td>{{ $checkout->user->membership_number }}</td>--}}
                                                <td>{{ @$checkout->plan->title }}
                                                    [{{ $checkout->plan->level->title }}]
                                                </td>
                                                <td> {{ showDate($checkout->start_date) }}</td>
                                                <td> {{ showDate($checkout->end_date) }}</td>
                                                <td>
                                                    @if($checkout->hasCertificate)
                                                        <a href="{{route('membership.certificateDownload',$checkout->hasCertificate->certificate_id)}}"
                                                           class="link_value theme_btn small_btn4">{{__('common.Download')}}</a>
                                                        <a href="{{route('membership.certificateCheck',$checkout->hasCertificate->certificate_id)}}"
                                                           class="link_value theme_btn small_btn4">{{__('common.View')}}</a>
                                                    @else
                                                        <a href="{{route('membership.getCertificate',[$checkout->plan_id])}}"
                                                           class="link_value theme_btn small_btn4">
                                                            {{__('frontend.Get Certificate')}}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('membership.upgrade', [$checkout->plan_id]) }}"
                                                       class="link_value theme_btn small_btn4">{{__('common.Click')}}</a>
                                                </td>
                                                <td>
                                                    @php
                                                        $renewStart = null;
                                                        $today = Carbon\Carbon::now()->format('Y-m-d');

                                                        if ($settings->renew_before > 0) {
                                                            $renewStart = Carbon\Carbon::parse($checkout->end_date)->subDays($settings->renew_before);
                                                        }
                                                    @endphp
                                                    @if($renewStart)
                                                        @if($today > $renewStart)
                                                            <a href="{{ route('membership.myMembershipRenew', [$checkout->plan_id, $checkout->id]) }}"
                                                               class="link_value theme_btn small_btn4">{{__('membership.Renew')}}</a>
                                                        @endif
                                                    @else
                                                        <a href="{{ route('membership.myMembershipRenew', [$checkout->plan_id, $checkout->id]) }}"
                                                           class="link_value theme_btn small_btn4">{{__('membership.Renew')}}</a>
                                                    @endif

                                                    <a href="{{ route('membership.myMembershipCourseEbook', [$checkout->plan_id]) }}"
                                                       class="link_value theme_btn small_btn4">{{__('common.View')}}</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="8">
                                                    {{__('common.No data available in the table')}}
                                                </td>
                                            </tr>
                                        @endforelse
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
</div>
