<div>
    <div class="primary_input studentSelection" wire:ignore>
        <select class="primary_select studentPositionSelect width_200" wire:model="pos" wire:change="selectPosition">
            <option value="">{{__('org.Filter by Position')}}</option>
            @foreach ($positions as $key => $position)
                <option value="{{ $position->code }}"
                >{{ $position->name }}</option>
            @endforeach
        </select>
    </div>

    @push('js')
        <script>
            $(document).ready(function () {
                $('.studentSelection').on('change', function (e) {
                @this.set('pos', e.target.value);
                @this.selectPosition()
                });
            });
        </script>
    @endpush
</div>
