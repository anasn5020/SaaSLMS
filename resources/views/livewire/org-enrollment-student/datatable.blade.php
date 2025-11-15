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
    <x-livewire-tables::wrapper :component="$this">
        @if ($this->hasConfigurableAreaFor('before-tools'))
            @include($this->getConfigurableAreaFor('before-tools'), $this->getParametersForConfigurableArea('before-tools'))
        @endif
        <div

            class="container-fluid p-0"
        >

            <div class="d-md-flex justify-content-between mb_15">
                <div class="d-md-flex">
                    <div>
                        @include('livewire.partials.org_position_select',compact('positions'))
                    </div>
                </div>


                <div class="d-md-flex">
                    <div>
                        <x-livewire-tables::tools.toolbar/>
                    </div>
                </div>
            </div>


            {{--            --}}
            {{--            @include('livewire-tables::bootstrap-4.includes.table')--}}
            {{--            @include('livewire-tables::bootstrap-4.includes.pagination')--}}

            {{--           --}}
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
        <input name="user_ids" type="hidden" x-model="selectedItems"/>

    </x-livewire-tables::wrapper>


    {{--    <input id="selectedRow" name="total_ids" type="hidden" x-model="selectedItems.length"/>--}}
</div>
