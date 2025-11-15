
@if($user->userSkill && $user->userSkill->skills)
    @foreach(explode(',',$user->userSkill->skills) as $skill)
        <button>{{$skill}}</button>
    @endforeach

@else
    @include(theme('profile._empty_data_msg'))
@endif
