<div class="modal-dialog modal_800px modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{__('virtual-class.Record')}} {{__('common.List')}} </h4>
            <button type="button" class="close " data-bs-dismiss="modal">
                <i class="ti-close "></i>
            </button>
        </div>

        <div class="modal-body">

            <div class="row">
                <div class="col-md-12  ">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <table id="lms_table" class="table Crm_table_active3">
                                <thead>
                                <tr>
                                    <th class="p-3">{{__('common.SL')}}</th>
                                    <th class="p-3">{{__('common.Title')}}</th>
                                    <th class="p-3">{{__('common.Link')}}</th>
                                    <th class="p-3">{{__('common.Action')}}</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($records as $key => $record)
                                    <tr>
                                        <td class="p-3">{{++$key}}</td>
                                        <td class="p-3">{{$record->title}}</td>
                                        <td class="p-3 text-center  ">
                                            <a class="primary-btn small fix-gr-bg text-nowrap text-white btn-fit"
                                               target="_blank"
                                               href="{{$record->remote==1?$record->url:asset($record->url)}}">
                                                {{__('common.Link')}}
                                            </a>
                                        </td>


                                        <td class="p-3">
                                            <div class="dropdown CRM_dropdown">
                                                <button class="btn btn-secondary dropdown-toggle"
                                                        type="button"
                                                        id="dropdownMenu2" data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false">
                                                    {{__('common.Action')}}
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                     aria-labelledby="dropdownMenu2">
                                                    <a target="_blank"

                                                    @if (permissionCheck('virtual-class.index'))
                                                        <button
                                                            class="  dropdown-item"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#recordDelete{{$record->id}}"
                                                            type="button">{{__('common.Delete')}}</button>

                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                    <div class="modal fade admin-query" id="recordDelete{{$record->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">{{__('common.Delete')}} {{__('virtual-class.Record')}}</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                        &times;
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <h4>{{__('common.Are you sure to delete ?')}}</h4>
                                                    </div>

                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg"
                                                                data-bs-dismiss="modal">{{__('jitsi.Cancel')}}</button>
                                                        <form class=""
                                                              action="{{ route('virtual-class.records.delete',$record->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="primary-btn fix-gr-bg"
                                                                    type="submit">{{__('common.Delete')}}</button>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
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
