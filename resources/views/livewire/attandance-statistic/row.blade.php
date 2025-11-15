
<div>

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('class')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->title}}
        </x-livewire-tables::bs4.table.cell>
    @endif
    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('title')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->assign[0]->course->title}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('total_enrolled')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->assign[0]->course->total_enrolled}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('absence')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->assign[0]->course->attendanceData()['absence']}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('late')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->assign[0]->course->attendanceData()['late']}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('on_time')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->assign[0]->course->attendanceData()['on_time']}}
        </x-livewire-tables::bs4.table.cell>
    @endif


    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('fail')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->assign[0]->course->attendanceData()['fail']}}
        </x-livewire-tables::bs4.table.cell>
    @endif

    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('pass')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->assign[0]->course->attendanceData()['pass']}}
        </x-livewire-tables::bs4.table.cell>
    @endif


    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('attend_rate')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->assign[0]->course->attendanceData()['attend_rate']}}
        </x-livewire-tables::bs4.table.cell>
    @endif


    @if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('pass_rate')))
        <x-livewire-tables::bs4.table.cell>
            {{$row->assign[0]->course->attendanceData()['pass_rate']}}
        </x-livewire-tables::bs4.table.cell>
    @endif


</div>


