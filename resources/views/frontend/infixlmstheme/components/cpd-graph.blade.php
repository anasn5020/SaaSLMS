@if(isModuleActive('CPD'))
    <div class="col-lg-12">
        <div class="white_box chart_box mt-20">
            <h4>{{__('cpd.CPD')}} {{date('Y')}}</h4>
            <div class="">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <canvas id="myChartCPD" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
@endif
@section('js')
    <script src="{{asset('public/backend/vendors/chartlist/Chart.min.js')}}"></script>
    <script src="{{asset('public/backend/js/daterangepicker.min.js')}}"></script>
    <script>
        var course_title = [];
        var complete_percentage = [];
        @isset($courses)

        @foreach($courses as $key => $val)
        course_title.push('{{$val->title}}');
        complete_percentage.push('{{ round($val->loginUserTotalPercentage) }}');
        @endforeach
        @endisset

        var ctx = document.getElementById('myChartCPD').getContext('2d');
        var myChartCPD = new Chart(ctx, {
            type: 'bar',
            data: {

                labels: course_title,
                datasets: [{
                    label: '{{__('cpd.Student Course Statistic')}}',
                    data: complete_percentage,
                    backgroundColor: 'rgba(124, 50, 255, 0.5)',
                    borderColor: 'rgba(124, 50, 255, 0.5)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                maintainAspectRatio: false,
            }
        });
    </script>
@endsection
