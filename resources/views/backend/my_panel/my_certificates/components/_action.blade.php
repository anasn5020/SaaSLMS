<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu1"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{ __('common.Select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu1">
        <a class="dropdown-item"
           href="{{route('certificateDownload',$certificate->certificate_id)}}">{{__('common.Download')}}</a>
        <a class="dropdown-item"
           href="{{route('certificateCheck',$certificate->certificate_id)}}">{{__('common.View')}}</a>
    </div>
</div>
