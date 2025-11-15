<div>
    <div class="primary_input planSelection" wire:ignore>
        <select class="primary_select studentPositionSelect width_200" wire:model="plan"
            {{--                wire:change="selectPlan"--}}
        >
            <option value="">{{__('org-subscription.Filter by Plan')}}</option>

            <option value="1">
                {{__('org-subscription.Class')}}
            </option>
            <option value="2">
                {{__('org-subscription.Learning Path')}}
            </option>

        </select>
    </div>

    @push('js')
        <script>
            $(document).ready(function () {
                $('.planSelection').on('change', function (e) {
                    console.log(e.target.value)
                @this.set('plan', e.target.value);
                @this.builder()
                });
            });
        </script>
    @endpush
</div>
