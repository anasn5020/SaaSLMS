<div>
    <div class="row mb_20 mt_20">
        <div class="col-md-4">
            <div class="primary_input" wire:ignore>

                <select class="primary_select" wire:model="type" wire:change="selectType">
                    <option value="">{{__('org.Filter By Type')}}</option>
                    <option value="Video">Video</option>
                    <option value="Excel">Excel</option>
                    <option value="PPT">PPT</option>
                    <option value="Doc">Doc</option>
                    <option value="PDF">PDF</option>
                    <option value="SCORM">SCORM</option>
                </select>


            </div>
        </div>

        <div class="col-md-6">
            @if(permissionCheck('org.material.store'))
                <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10"
                   id="add_material_btn" href="#"><i
                        class="ti-plus"></i>{{__('org.Add Material')}}</a>
            @endif
            <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 "
               href="{{route('org.material-source-export')}}"><i
                    class="ti-download"></i>{{__('org.Export Material')}}</a>
        </div>

        <div class="col-md-2">
            <div class="dropdown CRM_dropdown mt-10 float-end">

            </div>
        </div>

    </div>

    <input type="hidden" id="showAddBtn" value=" {{$showAddBtn?'1':'0'}}">
    <input type="hidden" id="org_chart" value=" {{$org_chart}}">
    @push('js')
        <script>
            $(document).ready(function () {
                $('.primary_select').on('change', function (e) {
                    @this.
                    set('type', e.target.value);
                    @this.
                    selectType()
                });


                $('#add_material_btn').on('click', function (e) {
                    var showAddBtn = $('#showAddBtn').val();

                    if (showAddBtn == 1) {
                        var org_chart = $('#org_chart').val();
                        $('#addCategory').val(org_chart)
                        $('#add_material').modal('toggle');

                    } else {
                        toastr.error('Please Select a Category', 'Failed');
                    }
                });

            });
        </script>
    @endpush
</div>
