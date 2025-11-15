
@if($user->userSkill && $user->userSkill->skills)
    @foreach(explode(',',$user->userSkill->skills) as $skill)
        <a href="javascript:void(0);" class="badge badge-custom">{{$skill}}</a>
    @endforeach

@else
    @include('backend.profile._empty_data_msg')
@endif
