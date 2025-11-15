<div>
    <div>
        <div>

            {{--     <td>

                     <label class="primary_checkbox d-flex " for="plan{{$row->id}}">
                         <input type="checkbox"
                                id="plan{{$row->id}}"
                                data-student="{{$row->id}}"
                                value="{{$row->id}}" name="plans[]"
                                class=" singlePlan common-checkbox plan{{$row->id}}"
                         >
                         <span class="checkmark"></span>
                     </label>

                 </td>--}}
            @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('title')))
                <x-livewire-tables::bs4.table.cell>
                    {{$row->title}}
                </x-livewire-tables::bs4.table.cell>
            @endif

            {{--      <x-livewire-tables::bs4.table.cell>
                      {{getPriceFormat($row->price)}}
                  </x-livewire-tables::bs4.table.cell>

                  <x-livewire-tables::bs4.table.cell>
                      {{$row->about}}
                  </x-livewire-tables::bs4.table.cell>
      --}}
            @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('join_date')))

                <x-livewire-tables::bs4.table.cell>
                    {{showDate($row->join_date)}}
                    {{$row->join_time}}
                </x-livewire-tables::bs4.table.cell>
            @endif

            @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('end_date')))

                <x-livewire-tables::bs4.table.cell>
                    {{showDate($row->end_date)}}
                    {{$row->end_time}}
                </x-livewire-tables::bs4.table.cell>
            @endif
            @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('days')))

                <x-livewire-tables::bs4.table.cell>
                    {{$row->days!=0?$row->days.' Days':''}}
                </x-livewire-tables::bs4.table.cell>
            @endif

            @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('type')))

                <x-livewire-tables::bs4.table.cell>
                    {{$row->type==1?'Class':'Leaning Path'}}
                </x-livewire-tables::bs4.table.cell>
            @endif

        </div>

    </div>

</div>
