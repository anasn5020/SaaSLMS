<div>
    <div>
        <div>

            @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('title')))
                <x-livewire-tables::bs4.table.cell>
                    {{$row->title}}
                </x-livewire-tables::bs4.table.cell>
            @endif



            @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('days')))

                <x-livewire-tables::bs4.table.cell>
                    {{$row->days!=0?$row->days.' Days':''}}
                </x-livewire-tables::bs4.table.cell>
            @endif

            @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('created_by')))

                <x-livewire-tables::bs4.table.cell>
                    {{$row->createdBy->name}}
                </x-livewire-tables::bs4.table.cell>
            @endif

            @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('created_at')))

                <x-livewire-tables::bs4.table.cell>
                    {{showDate($row->created_at)}}
                </x-livewire-tables::bs4.table.cell>
            @endif

        </div>

    </div>

</div>
