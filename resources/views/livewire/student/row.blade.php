<div>
    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('sl')))
        <x-livewire-tables::bs4.table.cell>
            {{ ++$this->serial }}
        </x-livewire-tables::bs4.table.cell>
    @endif
    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('username')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->username}}
        </x-livewire-tables::bs4.table.cell>
    @endif
    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('name')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->name}}
        </x-livewire-tables::bs4.table.cell>
    @endif


    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('org_chart_code')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->branch->fullTextPath}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('org_position_code')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->position->name}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('employee_id')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->employee_id}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('email')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->email}}
        </x-livewire-tables::bs4.table.cell>
    @endif


    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('dob')))
        <x-livewire-tables::bs4.table.cell>
            {{showDate($row->dob)}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('gender')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->gender}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('start_working_date')))
        <x-livewire-tables::bs4.table.cell>
            {{showDate($row->start_working_date)}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('phone')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->phone}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('status')))
        <x-livewire-tables::bs4.table.cell>
            @if($row->status==1)
                {{__('common.Active')}}
            @else
                <span class="text-danger">{{__('common.Deactivate')}}</span>
            @endif
        </x-livewire-tables::bs4.table.cell>
    @endif

</div>
