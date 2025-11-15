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
        <a target="_blank" class="dropdown-item" href="{{route('invoice',$row->id)}}">{{__('common.View')}}</a>
        @if (isModuleActive('Store'))
            @php
                $is_store = 0;
                $is_virtual = 0;
                foreach (@$row->courses as $key => $value) {
                    $is_store += $value->course->product_type==2?1:0;
                    $is_virtual += $value->course->product_type==1?1:0;
                }
            @endphp
            @if ($is_store > 0)
                <a href="{{ route('users.my_store_purchase_order_detail', $row->id) }}"
                   class="dropdown-item">{{__('product.Tracking Details')}}</a>
            @endif
            @if ($is_virtual > 0)
                <a href="{{ route('users.my_virtual_file_download', $row->id) }}"
                   class="dropdown-item">{{__('product.Virtual Files')}}</a>
            @endif
        @endif


    </div>
</div>
