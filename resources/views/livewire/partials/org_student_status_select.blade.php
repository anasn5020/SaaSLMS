<div>
    <div class="primary_input studentStatusSelection" wire:ignore>
        <select class="primary_select studentPositionSelect width_200" wire:model="pos"
                wire:change="selectStudentStatus">
            <option value="1">{{__('student.Student')}} {{__('common.Status')}}</option>
            <option value="1">{{__('common.Active')}}</option>
            <option value="0">{{__('common.Inactive')}}</option>

        </select>
    </div>

    @push('js')
        <script>
            $(document).ready(function () {
                $('.studentStatusSelection').on('change', function (e) {
                @this.set('student_status', e.target.value);
                @this.selectStudentStatus(e.target.value)
                });
            });
        </script>
    @endpush
</div>
