@aware(['component'])

@if ($component->bulkActionsAreEnabled() && $component->hasBulkActions())
    @php
        $theme = $component->getTheme();
    @endphp
    <style>
        .QA_section.check_box_table .QA_table .table thead tr th:first-child {
            padding-left: 10px;
        }
    </style>

    <x-livewire-tables::table.th.plain>
        <div
            class=""
            x-data="{ newSelectCount: 0, indeterminateCheckbox: false, bulkActionHeaderChecked: false}"
            x-init="$watch('selectedItems', value => indeterminateCheckbox = (value.length > 0 && value.length < paginationTotalItemCount))"

            @class([
                'inline-flex rounded-md shadow-sm' => $theme === 'tailwind',
                'form-check' => $theme === 'bootstrap-5',
                ])
        >
            <label class="primary_checkbox d-flex" for="all{{$this->tableName}}">
                <input
                    id="all{{$this->tableName}}"
                    class="common-checkbox "
                    :checked="selectedItems.length == paginationTotalItemCount"
                    x-on:click="if(selectedItems.length == paginationTotalItemCount) { $el.indeterminate = false; $wire.clearSelected(); bulkActionHeaderChecked = false; } else { bulkActionHeaderChecked = true; $el.indeterminate = false; $wire.setAllSelected(); }"
                    type="checkbox"
                    x-init="$watch('indeterminateCheckbox', value => $el.indeterminate = value); $watch('selectedItems', value => newSelectCount = value.length);"

                    @class([
                        'rounded border-gray-300 text-indigo-600 shadow-sm transition duration-150 ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:bg-gray-600' => $theme === 'tailwind',
                        'form-check-input' => $theme === 'bootstrap-5',
                    ])
                />
                <span class="checkmark"></span>
            </label>
        </div>
    </x-livewire-tables::table.th.plain>
@endif
