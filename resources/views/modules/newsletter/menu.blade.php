@if(permissionCheck('newsletter'))
    <li>
        <a href="#" class="has-arrow" aria-expanded="false">
            <div class="nav_icon_small"><span class="fas fa-gift"></span></div>
            <div class="nav_title"><span>{{__('newsletter.Newsletter') }}</span></div>
        </a>
        <ul>
            @if(permissionCheck('newsletter.setting'))
                <li>
                    <a href="{{ route('newsletter.setting') }}">
                        {{__('newsletter.Setting') }}
                    </a>
                </li>
            @endif
            @if (permissionCheck('newsletter.mailchimp.setting'))
                <li>
                    <a href="{{ route('newsletter.mailchimp.setting') }}">
                        {{__('newsletter.Mailchimp') }}
                    </a>
                </li>
            @endif
            @if (permissionCheck('newsletter.getresponse.setting'))
                <li>
                    <a href="{{ route('newsletter.getresponse.setting') }}">
                        {{__('newsletter.GetResponse') }}
                    </a>
                </li>
            @endif
            @if(permissionCheck('newsletter.acelle.setting'))
                <li>
                    <a href="{{ route('newsletter.acelle.setting') }}">
                        {{__('newsletter.Acelle') }}
                    </a>
                </li>
            @endif
            @if (permissionCheck('newsletter.subscriber'))
                <li><a href="{{ route('newsletter.subscriber') }}"> {{ __('frontendmanage.Subscriber') }}</a></li>
            @endif
        </ul>
    </li>
@endif
