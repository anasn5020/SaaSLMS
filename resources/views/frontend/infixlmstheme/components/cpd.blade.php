<div class="main_content_iner main_content_padding">
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('cpd.My CPD List')}}</h3>
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
                                            <th scope="col">{{__('common.SL')}}</th>
                                            <th scope="col">{{__('common.Title')}}</th>
                                            <th scope="col">{{__('cpd.Created Date')}}</th>
                                            <th scope="col">{{__('cpd.End Date')}}</th>
                                            <th scope="col">{{ __('cpd.Total Course') }}</th>
                                            <th scope="col">{{ __('cpd.Completed') }}(%)</th>
                                            <th scope="col">{{ __('cpd.Certificate') }}</th>
                                            <th scope="col">{{__('common.Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if(isset($cpds))
                                            @forelse ($cpds as $key=> $cpd)
                                                <tr>
                                                    <td scope="row">{{$key+1}}</td>
                                                    <td>{{ $cpd->title }}</td>
                                                    <td>{{ showDate($cpd->created_at) }}</td>
                                                    <td>{{ $cpd->end_date }}</td>
                                                    <td>
                                                        {{ $cpd->studentCpdCourses->count() }}
                                                    </td>
                                                    <td>
                                                        {{ $cpd->completePercentage() }}

                                                    </td>
                                                    <td>
                                                        @if($cpd->completePercentage()==100)

                                                            <a href="{{route('cpd.getCertificate',[$cpd->id])}}"
                                                               class="link_value theme_btn small_btn4">
                                                                {{__('frontend.Get Certificate')}}
                                                            </a>

                                                        @else
                                                            {{__('cpd.Not Completed Yet')}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('myCpdCourse',[$cpd->id]) }}"
                                                           class="link_value theme_btn small_btn4">{{__('common.View')}}</a>
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center"
                                                        colspan="9">{{__('common.No data available in the table')}} </td>
                                                </tr>
                                            @endforelse
                                        @endif
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
