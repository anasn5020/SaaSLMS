<div class="tab-pane fade" id="experience_tab">
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center justify-content-between flex-grow-1">
                    <h3>{{__('profile.experience')}}</h3>
                    <label data-bs-toggle="tooltip" data-placement="top" title="{{$show_experience_tooltip}}"
                           for="autoNext1" class="switch_toggle me-2">
                        <input value="{{$show_experience?0:1}}" class="hide_show_tab" data-filed="show_experience"
                               type="checkbox" id="autoNext1" {{$show_experience?'checked':""}}>
                        <i class="slider round"></i>
                    </label>
                </div>

                <div class="d-flex align-items-center">


                    <a href="javascript:void(0)"
                       class="primary-btn fix-gr-bg add_experience_btn">{{__('profile.add_experience')}}</a>
                </div>

            </div>
            <hr>
            <div id="experience_list">
                @include('backend.profile.experience.list')
            </div>

        </div>
    </div>
</div>
