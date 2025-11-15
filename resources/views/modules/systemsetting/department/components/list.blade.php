<div class="">
    <!-- table-responsive -->
    <table class="table Crm_table_active3">
        <thead>
        <tr>

            <th scope="col">{{ __('common.ID') }}</th>
            <th scope="col">{{ __('common.Name') }}</th>
            <th scope="col">{{ __('leave.Department Head') }}</th>
            <th scope="col">{{ __('common.Details') }}</th>
            <th scope="col">{{ __('common.Action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($departments as $key => $item)
            <tr>

                <th>{{ $key + 1 }}</th>
                <td>{{ $item->name }}</td>
                <td>{{ $item->staff->user->name ?? '' }}</td>
                <td>{{ $item->details }}</td>
                <td>
                    <!-- shortby  -->
                    <div class="dropdown CRM_dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                id="dropdownMenu2" data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                            {{ __('common.Select') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                            <a href="#" class="dropdown-item edit_brand"
                               onclick="editItem({{ $item }})">{{__('common.Edit')}}</a>
                            <a href="#" class="dropdown-item edit_brand"
                               onclick="showDeleteModal({{ $item->id }})">{{__('common.Delete')}}</a>
                        </div>
                    </div>
                    <!-- shortby  -->
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
