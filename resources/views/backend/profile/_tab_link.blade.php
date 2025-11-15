<ul class="nav nav-tabs ms-0 mb-3 border-0">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab"
           href="#basic_information_tab">{{__('profile.basic_information')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#change_password_tab">{{__('profile.change_password')}}</a>
    </li>
    @if(isModuleActive('TwoFA') && Settings('enable_two_fa'))

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#fa_tab">{{__('profile.2FA')}}</a>
        </li>
    @endif
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#images_tab">{{__('profile.images')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#about_tab">{{__('common.About')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#education_tab">{{__('profile.education')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#experience_tab">{{__('profile.experience')}}</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#skills_tab">{{__('profile.skills')}}</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#financial_tab">{{__('profile.financial')}}</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#api_tab">{{__('profile.api')}}</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#extra_info_tab">{{__('profile.extra_information')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#identity_tab">{{__('profile.identity_and_documents')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#social_tab">{{__('profile.social_and_contact')}}</a>
    </li>
    @if(auth()->user()->id !== 1)
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#delete_account_tab">{{__('profile.delete_account')}}</a>
        </li>
    @endif
</ul>
