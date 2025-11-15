<div class="tab-pane fade" id="skills_tab">
    <div class="row">
        <div class="col-12">

           <div class="d-flex justify-content-between align-items-center">
               <h3>{{__('profile.skills')}}</h3>
               <a href="javascript:void(0)" class="link_value theme_btn small_btn4 add_skills_btn">{{__('profile.add_or_update_skills')}}</a>
           </div>
            <hr>
            <div class="skills_list">
                @include(theme('profile.skills.list'))
            </div>

        </div>
    </div>
</div>
