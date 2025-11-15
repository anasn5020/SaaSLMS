<div>
    <div class="row mb_20 mt_20">
        <div class="col-md-3">
            <div class="primary_input" wire:ignore>

                <select class="primary_select studentPositionSelect" wire:model="pos" wire:change="selectPosition">
                    <option value="">{{__('org.Filter by Position')}}</option>
                    @foreach ($positions as $key => $position)
                        <option value="{{ $position->code }}"
                        >{{ $position->name }}</option>
                    @endforeach
                </select>


            </div>
        </div>


        <div class="col-md-8   ps-0 pe-0 btn-group">
            <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 ps-3 pe-3 pt_10"
               id="add_student_btn" href="#"><i
                    class="ti-plus"></i>{{__('student.Add Student')}}</a>

            <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 ps-3 pe-3 pt_10" data-bs-toggle="modal"
               id="import_student_btn"
               data-target="#import_student" href="#"><i
                    class="ti-plus"></i>{{__('org.Import')}}</a>

            <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 ps-3 pe-3 pt_10"
               href="{{route('org.student.export')}}"><i
                    class="ti-download"></i>{{__('org.Export')}}</a>
            <div class="mr-10 fix-gr-bg mt-10  pe-3 ">


            </div>

        </div>


        <div class="col-md-1 " wire:ignore>

            <div class="dropdown CRM_dropdown mt-10 float-end">
                <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenu2" data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                    {{trans('common.Action')}}
                </button>
                <div class="dropdown-menu dropdown-menu-right"
                     aria-labelledby="dropdownMenu2">
                    <a class="dropdown-item " id="editStudent"
                       type="button">
                        {{trans('common.Edit')}}
                    </a>

                    <a class="dropdown-item " id="deleteStudent"
                       type="button">
                        {{trans('common.Delete')}}
                    </a>

                    <a class="dropdown-item " id="moveTo"
                       type="button">
                        {{trans('common.Move to')}}
                    </a>

                    <a class="dropdown-item " id="changeStatus"
                       type="button">
                        {{trans('common.Change Status')}}
                    </a>
                </div>
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
                    set('pos', e.target.value);
                    @this.
                    selectPosition()
                });


                $('#add_student_btn').on('click', function (e) {
                    var showAddBtn = $('#showAddBtn').val();

                    if (showAddBtn == 1) {
                        var org_chart = $('#org_chart').val();
                        $('#addBranch').val(org_chart)
                        $('#add_student').modal('toggle');

                    } else {
                        toastr.error('Please Select a org chart', 'Failed');
                    }
                });

            });
        </script>

    @endpush

    <script>

        window.onload = function () {
            Livewire.on('checkOrgChart', () => {
                $('.preloader').fadeOut();
            })
        }

    </script>
</div>
