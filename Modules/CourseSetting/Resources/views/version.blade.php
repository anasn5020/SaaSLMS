<div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"> {{__('org.Version Management')}} ({{$lesson->name}})</h4>
            <button type="button" class="close " data-bs-dismiss="modal">
                <i class="ti-close "></i>
            </button>
        </div>

        <div class="modal-body">

            <div class="row">

                <div class="col-xl-12">
                    <div class="  QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">

                            <table id="lms_table3" class="table Crm_table_active3">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('org.Version') }}</th>
                                    <th scope="col">{{ __('common.Title') }}</th>
                                    <th scope="col">{{ __('org.Modified Date') }}</th>
                                    <th scope="col">{{ __('org.Modified By') }}</th>
                                    <th scope="col">{{ __('org.Size') }}</th>
                                    <th scope="col">{{ __('common.Status') }}</th>
                                    <th scope="col">{{ __('common.Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($files as $key => $file)
                                    <tr>
                                        <td>
                                            {{$file->version}}.0
                                        </td>
                                        <td>{{$file->title}}</td>
                                        <td>
                                            {{showDate($file->updated_at)}}  {{$file->updated_at->format('h:i A') }}
                                        </td>
                                        <td>
                                            {{$file->user->name}}
                                        </td>
                                        <td>
                                            {{formatBytes($file->size)}}
                                        </td>
                                        <th>
                                            {{$file->id==$lesson->file_id?trans('org.In Use'):''}}
                                        </th>
                                        <td>
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
                                                        $link =asset($file->link);
                                                        if ($file->type=="SCORM"){
                                                            if (isModuleActive('SCORM') && !empty($file->scorm_version) && !empty($file->link)){
                                                            $link =route('scorm.viewer',[$file->scorm_version,base64_encode($file->link)]);                                                             }
                                                        }elseif (isModuleActive('XAPI') && $file->type=='XAPI' && !empty($file->link)){
                                                              $link =route('xapi.viewer',base64_encode($file->link));
                                                        }
                                                    @endphp
                                                    <a class="dropdown-item" target="_blank"
                                                       href="{{$link}}">{{__('common.View')}}</a>
                                                    @if($file->id!=$lesson->file_id)
                                                        <a href="{{route('lesson.file-restore',$file->id)}}"

                                                           class="dropdown-item ">{{__('org.Restore')}}</a>

                                                        <button data-id="{{$file->id}}"
                                                                data-url="{{route('org.material.file-delete')}}"
                                                                class="deleteMaterial dropdown-item"
                                                                data-lessons="0"
                                                                data-files="0"
                                                                type="button">{{__('common.Delete')}}</button>

                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<script>

    $('#lms_table3').DataTable(
        {
            bLengthChange: false,
            "bDestroy": true,
            "ordering": false,
            language: {
                paginate: {
                    next: "<i class='ti-arrow-right'></i>",
                    previous: "<i class='ti-arrow-left'></i>"
                }
            },
            columnDefs: [{
                visible: false
            }],
            responsive: true,
        });

</script>
