<x-livewire-tables::wrapper :component="$this">
    @if ($this->hasConfigurableAreaFor('before-tools'))
        @include($this->getConfigurableAreaFor('before-tools'), $this->getParametersForConfigurableArea('before-tools'))
    @endif
    {{--  <div class="d-md-flex justify-content-between mb_15">

          <div class="d-md-flex">
              <div class=" btn-group">
                  @if (permissionCheck('student.store'))
                      <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 ps-3 pe-3 pt_10 line-height-14"
                         id="add_student_btn" href="#"><i
                              class="ti-plus"></i>{{__('student.Add Student')}}</a>

                      <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 ps-3 pe-3 pt_10 line-height-14"
                        data-bs-toggle="modal"
                         id="import_student_btn"
                         data-target="#import_student" href="#"><i
                              class="ti-plus"></i>{{__('org.Import')}}</a>
                  @endif


                  <div class="mr-10 fix-gr-bg mt-10  pe-3 ">


                  </div>

              </div>
          </div>


          <div class="d-md-flex">
              <div>

                  @include('livewire.partials.search')
              </div>
          </div>
          <div class="d-md-flex">
              <div>
                  --}}{{-- @include('livewire-tables::bootstrap-4.includes.column-select') --}}{{--
              </div>
          </div>
          <div class="d-md-flex">
              <div class="">

                  <div class="dropdown CRM_dropdown mt-10 float-end">
                      <button class="btn bg-primary text-white dropdown-toggle" type="button"
                              id="dropdownMenu2"data-bs-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false">
                          {{trans('common.Action')}}
                      </button>
                      <div class="dropdown-menu dropdown-menu-right"
                           aria-labelledby="dropdownMenu2">
                          @if (permissionCheck('lmskids.user.edit'))
                              <a class="dropdown-item " id="editStudent" type="button">{{trans('common.Edit')}}</a>
                          @endif
                          @if (permissionCheck('lmskids.user.destroy'))
                              <a class="dropdown-item " id="deleteStudent"
                                 type="button">
                                  {{trans('common.Delete')}}
                              </a>
                          @endif
                          @if(permissionCheck('lmskids.user.kid-history'))
                              <a class="dropdown-item " id="studentHistory"
                                 type="button">
                                  {{trans('common.History')}}
                              </a>
                          @endif
                          @if (permissionCheck('lmskids.history.store'))
                              <a class="dropdown-item " id="moveTo"
                                 type="button">
                                  {{trans('common.Move to')}}
                              </a>
                          @endif
                          @if (permissionCheck('lmskids.user.kid-status'))
                              <a class="dropdown-item " id="changeStatus"
                                 type="button">
                                  {{trans('common.Change Status')}}
                              </a>
                          @endif
                      </div>
                  </div>
              </div>
          </div>
      </div>

  --}}
    <div class="d-md-flex justify-content-between mb_15">
        <div class="d-md-flex">
            <div>
                @include('livewire.partials.org_position_select',compact('positions'))
            </div>
        </div>

        <div class="d-md-flex">
            <div class=" btn-group">
                @if (permissionCheck('student.store'))
                    <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 ps-3 pe-3 pt_10 line-height-14"
                       id="add_student_btn" href="#"><i
                            class="ti-plus"></i>{{__('student.Add Student')}}</a>

                    <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 ps-3 pe-3 pt_10 line-height-14"
                       data-bs-toggle="modal"
                       id="import_student_btn"
                       data-target="#import_student" href="#"><i
                            class="ti-plus"></i>{{__('org.Import')}}</a>
                @endif

                <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 ps-3 pe-3 pt_10 line-height-14Modules/Org/Resources/views/material/index.blade.php"
                   href="{{route('org.student.export')}}"><i
                        class="ti-download"></i>{{__('org.Export')}}</a>
                <div class="mr-10 fix-gr-bg mt-10  pe-3 ">


                </div>

            </div>
        </div>


        {{--        <div class="d-md-flex">--}}
        {{--            <div>--}}
        {{--                @include('livewire.partials.search',compact('component'))--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="d-md-flex">
            <div>
                <x-livewire-tables::tools.toolbar/>
            </div>
        </div>
        <div class="d-md-flex">
            <div class="">
                <input type="hidden" id="showAddBtn" value="{{$showAddBtn?'1':'0'}}">
                <input type="hidden" id="org_chart" value="{{$org_chart}}">


                {{--                <input type="hidden" id="selectedRow" value=" {{count($this->getSelected())}}">--}}
                {{--                @if(count($this->getSelected())!=0)--}}
                {{--                    @foreach($this->getSelected() as $row)--}}
                {{--                        <input type="hidden" name="selectedRowsId[]" value="{{$row}}">--}}
                {{--                    @endforeach--}}
                {{--                @endif--}}

                <div class="dropdown CRM_dropdown mt-10 float-end">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenu2" data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                        {{trans('common.Action')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right"
                         aria-labelledby="dropdownMenu2">
                        @if (permissionCheck('student.edit'))
                            <a class="dropdown-item " id="editStudent"
                               type="button">
                                {{trans('common.Edit')}}
                            </a>
                        @endif
                        @if (permissionCheck('student.delete'))
                            <a class="dropdown-item " id="deleteStudent"
                               type="button">
                                {{trans('common.Delete')}}
                            </a>
                        @endif
                        @if (permissionCheck('student.move_to'))
                            <a class="dropdown-item " id="moveTo"
                               type="button">
                                {{trans('common.Move to')}}
                            </a>
                        @endif
                        @if (permissionCheck('student.change_status'))
                            <a class="dropdown-item " id="changeStatus"
                               type="button">
                                {{trans('common.Change Status')}}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    <x-livewire-tables::tools>--}}
    {{--        <x-livewire-tables::tools.sorting-pills/>--}}
    {{--        <x-livewire-tables::tools.filter-pills/>--}}
    {{--        <x-livewire-tables::tools.toolbar/>--}}
    {{--    </x-livewire-tables::tools>--}}

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

    <input id="selectedRow" name="total_ids" type="hidden" x-model="selectedItems.length"/>
    <input name="user_ids" type="hidden" x-model="selectedItems"/>

</x-livewire-tables::wrapper>

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

                    var position = $(".studentPositionSelect option:selected").val();
                    $("#addPositionOption").val(position);
                    $("#addPositionOption").niceSelect('update')
                    $('#add_student').modal('toggle');

                } else {
                    toastr.error('Please Select a org chart', 'Failed');
                }
            });

        });
    </script>
@endpush
