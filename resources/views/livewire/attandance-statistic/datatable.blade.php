<div :wire:key="student-list">
    <style>
        .QA_section.check_box_table .QA_table .table thead tr th:first-child, .QA_table .table tbody td:first-child {
            padding-left: 25px !important;
        }

        .QA_section.check_box_table .QA_table .table thead tr th {
            padding-left: 12px !important;
        }

        .QA_section .QA_table .table thead th {
            vertical-align: middle !important;
        }

    </style>
    <div>
        <x-livewire-tables::wrapper :component="$this">
            @if ($this->hasConfigurableAreaFor('before-tools'))
                @include($this->getConfigurableAreaFor('before-tools'), $this->getParametersForConfigurableArea('before-tools'))
            @endif
            <div

                class="container-fluid p-0"
            >
                @include('livewire.partials.org_attendance_class_filter',compact('categories'))

                <div class="d-md-flex justify-content-between mb_15">

                    <div class="d-md-flex">
                        <div>
                            @include('livewire.partials.org_position_select',compact('positions'))
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div>
                            @include('livewire.partials.org_student_status_select',compact('positions'))
                        </div>
                    </div>


                    <div class="d-md-flex">
                        <div class=" btn-group">
                            <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 ps-3 pe-3 pt_10 line-height-14Modules/Org/Resources/views/material/index.blade.php"
                               href="#" wire:click="export()"><i
                                    class="ti-download"></i>{{__('org.Export')}}</a>
                            <div class="mr-10 fix-gr-bg mt-10  pe-3 ">


                            </div>

                        </div>
                    </div>
                </div>

                <div class="row justify-content-center" wire:ignore>
                    <div class="col-xl-4  col-lg-5 col-md-6 mb_25">
                        <div class="white_box chart_box mt-20">
                            <h4>{{__('org-subscription.Attendance Rate')}}</h4>
                            <div class="">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                            </div>
                            <canvas id="course_overview2" width="250" height="250"></canvas>
                        </div>

                    </div>
                    <div class="col-xl-4  col-lg-5 col-md-6 mb_25">

                        <div class="white_box chart_box mt-20">
                            <h4>{{__('org-subscription.Pass Rate')}}</h4>
                            <div class="">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                            </div>
                            <canvas id="course_overview" width="250" height="250"></canvas>
                        </div>
                    </div>

                </div>

                {{--            @include('livewire-tables::bootstrap-4.includes.table')--}}
                {{--            @include('livewire-tables::bootstrap-4.includes.pagination')--}}

                <input type="hidden" id="showAddBtn" value=" {{$showAddBtn?'1':'0'}}">
                <input type="hidden" id="org_chart" value=" {{$org_chart}}">
                {{--                <input type="hidden" id="selectedRow" value=" {{$this->selectedRowsQuery->count()}}">--}}
                {{--            @if($this->selectedRowsQuery->count()!=0)--}}

                {{--                @foreach($this->selectedRowsQuery->get() as $row)--}}
                {{--                    <input type="hidden" name="selectedRowsId[]" value="{{$row->id}}">--}}
                {{--                @endforeach--}}
                {{--            @endif--}}

            </div>


            <input type="hidden" id="passRate" value="{{$pass_rate['pass']}}">
            <input type="hidden" id="failRate" value="{{$pass_rate['fail']}}">
            <input type="hidden" id="absenceRate" value="{{$attendance_rate['absence']}}">
            <input type="hidden" id="lateRate" value="{{$attendance_rate['late']}}">
            <input type="hidden" id="onTimeRate" value="{{$attendance_rate['on_time']}}">

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
        </x-livewire-tables::wrapper>
    </div>
    <script src="{{asset('public/backend/vendors/chartlist/Chart.min.js')}}"></script>
    <script>

        let attendance_rate_chart = new Chart(document.getElementById('course_overview2').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['{{__('org-subscription.Absence')}}', '{{__('org-subscription.Late')}}', '{{__('org-subscription.On Time')}}'],
                datasets: [{
                    label: '{{__('org-subscription.Pass Rate')}}',
                    data: [$('#absenceRate').val(), $('#lateRate').val(), $('#onTimeRate').val()],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 159, 64, 0.2)'

                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }], yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            display: false,
                        },
                        gridLines: {
                            display: false
                        }
                    }],

                },

            }
        });

        let pass_rate_chart = new Chart(document.getElementById('course_overview').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['{{__('org-subscription.Pass')}}', '{{__('org-subscription.Fail')}}'],
                datasets: [{
                    label: '{{__('org-subscription.Attendance Rate')}}',
                    data: [$('#passRate').val(), $('#failRate').val()],
                    // data: [10, 110],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)'

                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }], yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            display: false,
                        }, gridLines: {
                            display: false
                        }
                    }],
                }
            }
        });

        function attendance_rate() {
            attendance_rate_chart.data.datasets[0].data[2] = $('#onTimeRate').val();
            attendance_rate_chart.data.datasets[0].data[1] = $('#lateRate').val();
            attendance_rate_chart.data.datasets[0].data[0] = $('#absenceRate').val();
            attendance_rate_chart.update();
        }

        function pass_rate() {
            pass_rate_chart.data.datasets[0].data[1] = $('#failRate').val();
            pass_rate_chart.data.datasets[0].data[0] = $('#passRate').val();
            pass_rate_chart.update();
        }


        window.addEventListener('contentChanged', () => {
            attendance_rate();
            pass_rate();
        });
        document.addEventListener('livewire:load', () => {
            // attendance_rate();
            // pass_rate();
            @this.
            updateChart();
        });

        $('select').on('change', function (e) {
            @this.
            updateChart();
        });


    </script>

</div>
