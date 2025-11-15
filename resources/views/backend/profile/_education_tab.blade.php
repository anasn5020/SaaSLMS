<div class="tab-pane fade" id="education_tab">
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center justify-content-between flex-grow-1">

                    <h3>{{__('profile.education')}}</h3>
                    <label data-bs-toggle="tooltip" data-placement="top" title="{{$show_education_tooltip}}"
                           for="autoNext"
                           class="switch_toggle me-2">
                        <input value="{{$show_education?0:1}}" class="hide_show_tab" data-filed="show_education"
                               type="checkbox" id="autoNext" {{$show_education?'checked':""}}>
                        <i class="slider round"></i>
                    </label>
                </div>
                <div class="d-flex align-items-center">

                    <a href="javascript:void(0)"
                       class="primary-btn fix-gr-bg add_education_btn">{{__('profile.add_education')}}</a>
                </div>

            </div>
            <hr>
            <div id="education_list">
                @include('backend.profile.education.list')
            </div>

        </div>
    </div>
</div>
