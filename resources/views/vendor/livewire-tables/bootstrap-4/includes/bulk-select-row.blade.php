@if (
    $bulkActionsEnabled &&
    count($this->bulkActions) &&
    (
        (
            $paginationEnabled && (
                ($selectPage && $rows->total() > $rows->count()) ||
                count($selected)
            )
        ) ||
        count($selected)
    )
)
    <x-livewire-tables::bs4.table.row wire:key="row-message">
        <x-livewire-tables::bs4.table.cell colspan="{{ $colspan }}">
            @if ((!$paginationEnabled && $selectPage) || (count($selected) && $paginationEnabled && !$selectAll && !$selectPage))
                <div>
                    <span>
                        @lang('common.You have selected')
                        <strong>{{ count($selected) }}</strong>
                        @lang(count($selected) === 1 ? 'row' : 'rows').
                    </span>

                    <button
                        wire:click="resetBulk"
                        wire:loading.attr="disabled"
                        type="button"
                        class="primary-btn small fix-gr-bg btn-sm"
                    >
                        @lang('common.Unselect All')
                    </button>
                </div>
            @elseif ($selectAll)
                <div>
                    <span>
                        @lang('common.You are currently selecting all')
                        <strong>{{ number_format($rows->total()) }}</strong>
                        @lang('rows').
                    </span>

                    <button
                        wire:click="resetBulk"
                        wire:loading.attr="disabled"
                        type="button"
                        class="primary-btn small fix-gr-bg btn-sm"
                    >
                        @lang('common.Unselect All')
                    </button>
                </div>
            @else
                @if ($rows->total() === count($selected))
                    <div>
                        <span>
                            @lang('common.You have selected')
                            <strong>{{ count($selected) }}</strong>
                            @lang(count($selected) === 1 ? 'row' : 'rows').
                        </span>

                        <button
                            wire:click="resetBulk"
                            wire:loading.attr="disabled"
                            type="button"
                            class="primary-btn small fix-gr-bg btn-sm"
                        >
                            @lang('common.Unselect All')
                        </button>
                    </div>
                @else
                    <div>
                        <span>
                        @lang('common.You have selected')
                            <strong>{{ $rows->count() }}</strong>
                            @lang('common.rows, do you want to select all')
                            <strong>{{ number_format($rows->total()) }}</strong>?
                        </span>

                        <button
                            wire:click="selectAll"
                            wire:loading.attr="disabled"
                            type="button"
                            class="primary-btn small fix-gr-bg btn-sm"
                        >
                            @lang('common.Select All')
                        </button>

                        <button
                            wire:click="resetBulk"
                            wire:loading.attr="disabled"
                            type="button"
                            class="primary-btn small fix-gr-bg btn-sm"
                        >
                            @lang('common.Unselect All')
                        </button>
                    </div>
                @endif
            @endif
        </x-livewire-tables::bs4.table.cell>
    </x-livewire-tables::bs4.table.row>
@endif
