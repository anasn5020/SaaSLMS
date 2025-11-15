<div>
    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('sl')))
        <x-livewire-tables::bs4.table.cell>
            {{ ++$this->serial }}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('user.name')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->user->name}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('user.org_chart_code')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->user->branch->fullTextPath}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('user.org_position_code')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->user->position->name}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('user.employee_id')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->user->employee_id}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('created_at')))
        <x-livewire-tables::bs4.table.cell>
            {{showDate($row->created_at)}}
        </x-livewire-tables::bs4.table.cell>
    @endif
    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('class_type')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->class_type==3?trans('org.Virtual Class'):trans('org.Offline Class')}}
        </x-livewire-tables::bs4.table.cell>
    @endif
    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('course')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->course->title}}
        </x-livewire-tables::bs4.table.cell>
    @endif
    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('class')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->class->title}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('attend')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->attend}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('total_score')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->total_score}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('pass_rate')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->pass_rate}}
        </x-livewire-tables::bs4.table.cell>
    @endif
    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('actual_score')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->actual_score}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('status')))
        <x-livewire-tables::bs4.table.cell>
            @if(!empty($row->total_score) && !empty($row->pass_rate) && !empty($row->actual_score))
                @php
                    $actual_rate =getPercentage($row->actual_score,$row->total_score);
                    if ($actual_rate>=$row->pass_rate){
                        echo trans('org.Pass');
                    }else{
                        echo trans('org.Fail');
                    }
                @endphp
            @else
                {{__('org.Fail')}}
            @endif
        </x-livewire-tables::bs4.table.cell>
    @endif


</div>
