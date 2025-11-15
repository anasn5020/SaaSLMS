<table id="lms_table" class="table Crm_table_active3">
    <thead>
    <tr>
        <th scope="col">{{ __('common.SL') }}</th>
        <th scope="col">{{ __('common.Logo') }}</th>
        <th scope="col">{{ __('setting.Title') }}</th>
        <th scope="col">{{ __('setting.Specifications') }}</th>
        <th scope="col">{{ __('common.Action') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($payout_accounts as $key=>$row)
        <tr>
            <th>{{ translatedNumber($key+1 )}}</th>
            <td>
                <img class="image_td" src="{{showImage($row->logo)}}" alt="logo">
            </td>
            <td>{{ $row->title }}</td>
            <td>{{ translatedNumber($row->specifications_count )}}</td>
            <td>
                <!-- shortby  -->
                <div class="dropdown CRM_dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenu2" data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                        {{ __('common.Select') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right"
                         aria-labelledby="dropdownMenu2">

                        <a data-id="{{$row->id}}" href="javascript:void(0);" class="dropdown-item show_payout_item"
                        >{{__('common.View')}}</a>
                        @if (permissionCheck('admin.payout_accounts.update'))
                            <a data-id="{{$row->id}}" href="javascript:void(0);" class="dropdown-item edit_payout_item"
                            >{{__('common.Edit')}}</a>
                        @endif


                        @if (permissionCheck('admin.payout_accounts.destroy'))
                            <a onclick="confirm_modal('{{route('admin.payout_accounts.destroy', $row->id)}}');"
                               class="dropdown-item">{{__('common.Delete')}}</a>
                        @endif
                    </div>
                </div>
                <!-- shortby  -->
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
