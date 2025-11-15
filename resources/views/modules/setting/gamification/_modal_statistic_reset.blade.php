<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ __('setting.Reset statistics') }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal">
                <i class="ti-close "></i>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{route('gamification.reset.statistic')}}" method="post">
                @csrf


                <div class="row">
                    <div class="col-xl-12 mb_25">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('common.Reset') }} <strong
                                    class="text-danger">*</strong></label>
                            <select class="primary_select" name="type" id="type">
                                <option data-display="{{__('common.All')}} {{__('setting.Statistic')}}"
                                        value="">{{__('common.All')}} {{__('setting.Statistic')}}</option>
                                <option value="points">{{__('setting.points')}}</option>
                                <option value="badges">{{__('setting.badges')}}</option>
                                <option value="level">{{__('setting.levels')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('common.Users') }} <strong
                                    class="text-danger">*</strong></label>
                            <select class="primary_select" name="user" id="user">
                                <option data-display="{{__('common.All')}} {{__('common.Users')}}"
                                        value="">{{__('common.All')}} {{__('common.Users')}}</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 text-center">
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg"
                                data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                        <button type="submit" id=""
                                class="primary-btn semi_large2 fix-gr-bg">{{__('common.Reset')}}</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('.primary_select').niceSelect();
</script>
