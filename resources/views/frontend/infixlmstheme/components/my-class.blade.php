<div class="main_content_iner main_content_padding">
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{ __('class.My Class') }}</h3>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table custom_table3 mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            <th scope="col">{{ __('class.Class') }}</th>
                                            <th scope="col">{{ __('common.Course') }}</th>
                                            <th scope="col">{{ __('cpd.Completed') }}(%)</th>
                                            <th scope="col">{{ __('class.Transcript') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
$i=0; @endphp
                                        @forelse ($classes as $key => $class)
                                            @foreach ($class->courses->where('status',1) as $key => $studentCourse)
                                                @php
                                                    $percentage = round($studentCourse->course->userTotalClassPercentage(auth()->id(),$class->course_id)) ?? 0;
                                                @endphp
                                                <tr>
                                                    <td class="m-2">
                                                        {{++$i}}
                                                    </td>
                                                    <td>{{ @$class->name }}</td>
                                                    <td>{{ @$studentCourse->course->title }}</td>
                                                    <td> {{ $percentage }}
                                                        % {{ __('student.Complete') }}
                                                    </td>
                                                    <td>
                                                        @if ($percentage == 100)
                                                            <a href="{{ route('get-transcript', [$studentCourse->course_id, auth()->user()->id]) }}"
                                                               class="link_value theme_btn small_btn4"
                                                               target="__blank">{{ __('common.View') }}</a>
                                                            <a href="{{ route('get-transcript', [$studentCourse->course_id, auth()->user()->id, 'download']) }}"
                                                               class="link_value theme_btn small_btn4">{{ __('common.Download') }}</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a target="_blank"
                                                           href="{{ route('continueCourse', [$studentCourse->course->slug]) }}"
                                                           class="link_value theme_btn small_btn4">
                                                            {{ __('common.View') }}
                                                        </a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="6">
                                                    {{__('common.No data available in the table')}}
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
