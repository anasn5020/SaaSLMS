@if ($showSearch)
    <div class="mb-3 mb-md-0  pt-2">
        <input wire:model{{ $component->getSearchOptions() }}="{{ $component->getTableName() }}.search"
               placeholder="{{ __('common.Search') }}"
               type="text"
               class="primary_input_field height_px_35"
        >
    </div>
@endif
