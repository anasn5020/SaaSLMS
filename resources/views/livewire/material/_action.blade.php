<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{__('common.Action')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">
        @php
            $link =asset($row->default->link);
            if ($row->type=="SCORM"){
                if (isModuleActive('SCORM') && !empty($row->scorm_version) && !empty($row->default->link)){
                $link =route('scorm.viewer',[$row->scorm_version,base64_encode($row->default->link)]);                                                             }
            }elseif (isModuleActive('XAPI') && $row->type=='XAPI' && !empty($row->default->link)){
                  $link =route('xapi.viewer',base64_encode($row->default->link));
            }
        @endphp
        <a class="dropdown-item" target="_blank"
           href="{{$link}}">{{__('common.View')}}</a>
        @if (permissionCheck('org.material.update'))
            <button
                data-id="{{$row->id}}"
                data-title="{{$row->title}}"
                data-type="{{$row->type}}"
                class="editMaterial dropdown-item"
                type="button">{{__('common.Edit')}}</button>
        @endif
        @if (permissionCheck('org.material.version'))
            <a href="{{route('org.material.files',$row->id)}}"
               type="button"
               class="dropdown-item show-modal ">{{__('org.Version Management')}}</a>
        @endif
        @if (permissionCheck('org.material.delete'))
            <button data-id="{{$row->id}}"
                    data-url="{{route('org.material')}}"
                    class="deleteMaterial dropdown-item"
                    data-lessons="{{count($row->lessons)}}"
                    data-files="{{count($row->files)}}"
                    type="button">{{__('common.Delete')}}</button>
        @endif
    </div>
</div>
