<!-- education -->
<input type="hidden" value="{{route('users.educations.create')}}" id="education_create_route">
<input type="hidden" value="{{route('users.educations.store')}}" id="education_store_route">
<input type="hidden" value="{{route('users.educations.edit',':id')}}" id="education_edit_route">
<input type="hidden" value="{{route('users.educations.update',':id')}}" id="education_update_route">

<!-- experience -->
<input type="hidden" value="{{route('users.experiences.create')}}" id="experience_create_route">
<input type="hidden" value="{{route('users.experiences.store')}}" id="experience_store_route">
<input type="hidden" value="{{route('users.experiences.edit',':id')}}" id="experience_edit_route">
<input type="hidden" value="{{route('users.experiences.update',':id')}}" id="experience_update_route">
<!-- skill -->
<input type="hidden" value="{{route('users.skills.create')}}" id="skill_create_route">

<!-- financial -->
<input type="hidden" value="{{route('users.payout_account_type',":id")}}" id="payout_account_type_change_route">

<!-- profile data hide show url -->
<input type="hidden" value="{{route('users.profile_data_toggle')}}" id="profile_data_toggle_route">

<!-- offline status url -->
<input type="hidden" value="{{route('users.offline_status_change')}}" id="profile_offline_status_change_route">
<input type="hidden" value="{{route('users.offline_status.submit')}}" id="profile_offline_status_message_route">
