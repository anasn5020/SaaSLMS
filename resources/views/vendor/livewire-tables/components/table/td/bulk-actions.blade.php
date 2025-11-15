@aware(['component'])
@props(['row'])

@if ($component->bulkActionsAreEnabled() && $component->hasBulkActions())
    @php
        $theme = $component->getTheme();
        $table = $component->getTableName();
        $id =$row->{$this->getPrimaryKey()};
    @endphp

    <x-livewire-tables::table.td.plain>
        <div @class([
            "inline-flex rounded-md shadow-sm" => $theme === "tailwind",
            "form-check" => $theme === "bootstrap-5",
            ])
        >

            <label class="primary_checkbox d-flex ms-2"
                   for="{{$table.$id }}">
                <input
                    id="{{$table.$id }}"
                    class="common-checkbox  {{isset($this->selectedItems)?in_array($row->{$this->getPrimaryKey()},$this->selectedItems)?'actionSelect':'':''}} "
                    wire:loading.attr.delay="disabled"
                    value="{{$row->{$this->getPrimaryKey()} }}"
                    type="checkbox"
                    x-model="selectedItems"
                    {{isset($this->selectedItems)?in_array($row->{$this->getPrimaryKey()},$this->selectedItems)?'checked':'':''}}

                    @class([
                        "rounded border-gray-300 text-indigo-600 shadow-sm transition duration-150 ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:bg-gray-600" => $theme === "tailwind",
                        "form-check-input" => $theme === "bootstrap-5",
                        ])
                />
                <span class="checkmark"></span>
            </label>
        </div>
    </x-livewire-tables::table.td.plain>
    @if(isset($this->selectedItems) && count($this->selectedItems)>0)
        <script>
            setTimeout(function () {
                $('.actionSelect').trigger('click')

            }, 1000);
        </script>
    @endif
@endif

