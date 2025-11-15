<div :wire:key="student-list">
    <style>
        .QA_section.check_box_table .QA_table .table thead tr th:first-child, .QA_table .table tbody td:first-child {
            padding-left: 25px !important;
        }

        .QA_section.check_box_table .QA_table .table thead tr th {
            padding-left: 12px !important;
        }

        .QA_section .QA_table .table thead th {
            vertical-align: middle !important;
        }

    </style>
    <div>
        <x-livewire-tables::wrapper :component="$this">
            @if ($this->hasConfigurableAreaFor('before-tools'))
                @include($this->getConfigurableAreaFor('before-tools'), $this->getParametersForConfigurableArea('before-tools'))
            @endif
            <div

                class="container-fluid p-0"
            >
                @include('livewire.partials.org_attendance_class_filter',compact('categories'))

                <div class="d-md-flex justify-content-between mb_15">

                    <div class="d-md-flex">
                        <div>
                            @include('livewire.partials.org_position_select',compact('positions'))
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div>
                            @include('livewire.partials.org_student_status_select',compact('positions'))
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div>
                            <x-livewire-tables::tools.toolbar/>
                        </div>
                    </div>

                    <div class="d-md-flex">
                        <div class=" btn-group">

                            <a x-show="selectedItems.length>0" x-clock
                               class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 ps-3 pe-3 pt_10 line-height-14"
                               href="#" id="deleteStudent"><i
                                    class="ti-trash"></i>{{__('common.Delete')}}</a>

                            <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 ps-3 pe-3 pt_10 line-height-14Modules/Org/Resources/views/material/index.blade.php"
                               href="#" wire:click="export()"><i
                                    class="ti-download"></i>{{__('org.Export')}}</a>
                            <div class="mr-10 fix-gr-bg mt-10  pe-3 ">


                            </div>

                        </div>
                    </div>
                </div>

                {{--            @include('livewire-tables::bootstrap-4.includes.table')--}}
                {{--            @include('livewire-tables::bootstrap-4.includes.pagination')--}}

                <input type="hidden" id="showAddBtn" value=" {{$showAddBtn?'1':'0'}}">
                <input type="hidden" id="org_chart" value=" {{$org_chart}}">
                {{--                <input type="hidden" id="selectedRow" value=" {{$this->selectedRowsQuery->count()}}">--}}
                {{--                @if($this->selectedRowsQuery->count()!=0)--}}

                {{--                    @foreach($this->selectedRowsQuery->get() as $row)--}}
                {{--                        <input type="hidden" name="selectedRowsId[]" value="{{$row->id}}">--}}
                {{--                    @endforeach--}}
                {{--                @endif--}}

            </div>

            <x-livewire-tables::table>
                <x-slot name="thead">
                    <x-livewire-tables::table.th.reorder/>
                    <x-livewire-tables::table.th.bulk-actions/>
                    <x-livewire-tables::table.th.row-contents/>
                    @foreach($columns as $index => $column)
                        @continue($column->isHidden())
                        @continue($this->columnSelectIsEnabled() && ! $this->columnSelectIsEnabledForColumn($column))
                        @continue($this->currentlyReorderingIsDisabled() && $column->isReorderColumn() && $this->hideReorderColumnUnlessReorderingIsEnabled())

                        <x-livewire-tables::table.th :column="$column" :index="$index"/>
                    @endforeach
                </x-slot>

                @if($this->secondaryHeaderIsEnabled() && $this->hasColumnsWithSecondaryHeader())
                    <x-livewire-tables::table.tr.secondary-header :rows="$rows"/>
                @endif

                <x-livewire-tables::table.tr.bulk-actions :rows="$rows"/>

                @forelse ($rows as $rowIndex => $row)
                    <x-livewire-tables::table.tr :row="$row" :rowIndex="$rowIndex">
                        <x-livewire-tables::table.td.reorder/>
                        <x-livewire-tables::table.td.bulk-actions :row="$row"/>
                        <x-livewire-tables::table.td.row-contents :rowIndex="$rowIndex"/>

                        @foreach($columns as $colIndex => $column)
                            @continue($column->isHidden())
                            @continue($this->columnSelectIsEnabled() && ! $this->columnSelectIsEnabledForColumn($column))
                            @continue($this->currentlyReorderingIsDisabled() && $column->isReorderColumn() && $this->hideReorderColumnUnlessReorderingIsEnabled())

                            <x-livewire-tables::table.td :column="$column" :colIndex="$colIndex">
                                {{ $column->renderContents($row) }}
                            </x-livewire-tables::table.td>
                        @endforeach
                    </x-livewire-tables::table.tr>

                    <x-livewire-tables::table.row-contents :row="$row" :rowIndex="$rowIndex"/>
                @empty
                    <x-livewire-tables::table.empty/>
                @endforelse

                @if ($this->footerIsEnabled() && $this->hasColumnsWithFooter())
                    <x-slot name="tfoot">
                        @if ($this->useHeaderAsFooterIsEnabled())
                            <x-livewire-tables::table.tr.secondary-header :rows="$rows"/>
                        @else
                            <x-livewire-tables::table.tr.footer :rows="$rows"/>
                        @endif
                    </x-slot>
                @endif
            </x-livewire-tables::table>

            <x-livewire-tables::pagination :rows="$rows"/>

            @isset($customView)
                @include($customView)
            @endisset
        </x-livewire-tables::wrapper>


    </div>
    @push('js')
        <script>

        </script>
    @endpush

    <script>


    </script>
</div>
