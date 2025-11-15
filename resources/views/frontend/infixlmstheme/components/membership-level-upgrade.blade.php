<div class="main_content_iner main_content_padding">
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12">
                    <div class=" ">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{ __('membership.Membership Plan') }} [{{ $plan->title }}]</h3>
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
                                            <th scope="col">{{ __('membership.Level') }}</th>
                                            <th scope="col">{{ __('common.Price') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($planLevels as $key => $level)
                                            <tr>
                                                <td class="m-2">{{ $key+1 }}</td>
                                                <td>{{ $level->level->title }}
                                                    @if($level->membership_level_id == $checkout->current_level)
                                                        [{{ __('membership.Ongoing Level') }}]
                                                    @endif
                                                </td>
                                                <td> {{ $level->price ?? __('common.Free') }}</td>
                                                <td>
                                                    @if(upgradeLevelPayment($checkout->id, $level->membership_level_id)==false && $level->price)

                                                        <a class="link_value theme_btn small_btn4" href="{{ route('membership.upgradeCheckout', [$level->membership_level_id, $checkout->id]) }}">{{ __('membership.Payment') }}</a>
                                                    @elseif(upgradeLevelPayment($checkout->id, $level->membership_level_id)==false && !$level->price)

                                                        <button type="button" class="link_value theme_btn small_btn4"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#upModal_{{ $level->id }}">
                                                            Upgrade
                                                        </button>
                                                    @elseif(upgradeLevelPayment($checkout->id, $level->membership_level_id) && $level->membership_level_id != $checkout->current_level)
                                                        <button type="button" class="link_value theme_btn small_btn4"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#onModal_{{ $level->id }}">
                                                            {{ __('membership.Make it Ongoing') }}
                                                        </button>

                                                        {{-- <button type="button" class="link_value theme_btn small_btn4" data-bs-toggle="modal" data-bs-target="#doModal_{{ $level->id }}">
                                                            DownGrade
                                                          </button> --}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="upModal_{{ $level->id }}" tabindex="-1"
                                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="exampleModalLabel">{{ __('membership.Upgrade') }} </h5>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close">

                                                                <span aria-hidden="true"><i class="ti-close"></i></span>
                                                            </button>
                                                        </div>

                                                        <form method="POST"
                                                              action="{{ route('membership.upgrade-level') }}">
                                                            @csrf
                                                            <input type="hidden" name="level_id"
                                                                   value="{{ $level->id }}">
                                                            <input type="hidden" name="checkout_id"
                                                                   value="{{ $checkout->id }}">

                                                            <div class="modal-body">
                                                                <h4>{{ __('membership.Upgrade You Membership Plan Level') }}</h4>
                                                            </div>
                                                            <div class="modal-footer mntop">
                                                                <button type="button"
                                                                        class="theme_btn small_btn bg-transparent"
                                                                        data-bs-dismiss="modal">{{ __('common.Cancel') }}</button>
                                                                <button type="submit"
                                                                        class="theme_btn small_btn ">{{ __('common.Submit') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="onModal_{{ $level->id }}" tabindex="-1"
                                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="exampleModalLabel">{{ __('membership.Ongoing') }} </h5>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true"><i class="ti-close"></i></span>
                                                            </button>
                                                        </div>

                                                        <form method="POST"
                                                              action="{{ route('membership.upgrade-or-default-level') }}">
                                                            @csrf
                                                            <input type="hidden" name="level_id"
                                                                   value="{{ $level->id }}">
                                                            <input type="hidden" name="checkout_id"
                                                                   value="{{ $checkout->id }}">

                                                            <div class="modal-body">
                                                                <h4>{{ __('membership.Make it Ongoing') }}</h4>
                                                            </div>
                                                            <div class="modal-footer mntop">
                                                                <button type="button"
                                                                        class="theme_btn small_btn bg-transparent"
                                                                        data-bs-dismiss="modal">{{ __('common.Cancel') }}</button>
                                                                <button type="submit"
                                                                        class="theme_btn small_btn ">{{ __('common.Submit') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="doModal_{{ $level->id }}" tabindex="-1"
                                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="exampleModalLabel">{{ __('membership.Upgrade') }} </h5>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true"><i class="ti-close"></i></span>
                                                            </button>
                                                        </div>

                                                        <form method="POST"
                                                              action="{{ route('membership.upgrade-or-default-level') }}">
                                                            @csrf
                                                            <input type="hidden" name="level_id"
                                                                   value="{{ $level->id }}">
                                                            <input type="hidden" name="checkout_id"
                                                                   value="{{ $checkout->id }}">

                                                            <div class="modal-body">
                                                                <h2>{{ __('membership.Upgrade You Membership Plan Level') }}</h2>
                                                            </div>
                                                            <div class="modal-footer mntop">
                                                                <button type="button"
                                                                        class="theme_btn small_btn bg-transparent"
                                                                        data-bs-dismiss="modal">{{ __('common.Cancel') }}</button>
                                                                <button type="button"
                                                                        class="theme_btn small_btn ">{{ __('common.Submit') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    {{ __('common.No Data Found') }}
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



