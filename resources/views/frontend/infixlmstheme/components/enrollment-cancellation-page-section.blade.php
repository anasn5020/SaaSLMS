<div>
    <style>
        .theme_select:after {
            top: 25px;
        }

        .purchase_history_wrapper {
            padding-bottom: 0 !important;
        }

    </style>
    @if(Settings('enable_refund_request'))
        <div class="main_content_iner main_content_padding">
            <div class="dashboard_lg_card">
                <div class="container-fluid g-0">

                    <div class="p-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('frontend.Refund Request')}}</h3>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <form action="{{route('enrollmentCancellationSubmit')}}" method="post">
                                    <div class="single_totl_warp col-lg-12 ps-0">
                                        @csrf


                                        <div class="input-group mb-3 input-group-lg">

                                            <select required class="theme_select w-100  mb_20"
                                                    name="course">
                                                <option
                                                    value="">{{__('common.Select')}} {{__('courses.Course')}}</option>
                                                @if(isset($courses))
                                                    @foreach ($courses as $course)
                                                        <option
                                                            value="{{$course->id}}"
                                                        >{{@$course->course->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                        </div>
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="single_input mb_25">
                                        <textarea required
                                                  placeholder="{{__('frontend.Reason') }}"
                                                  name="reason"
                                                  class="primary_textarea gray_input"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb_30">

                                                <button type="submit"
                                                        class="theme_btn height_50">
                                                    {{__('common.Submit') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="main_content_iner main_content_padding">
        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">

                <div class="p-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="section__title3 mb_40">
                                <h3 class="mb-0">{{__('frontend.Refund & Cancellation')}} {{__('common.History')}}</h3>
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
                                        <th scope="col">{{__('courses.Course')}}</th>
                                        <th scope="col">{{__('common.Price')}}</th>
                                        <th scope="col">{{__('courses.Request From')}}</th>
                                        <th scope="col">{{__('courses.Request')}} {{__('common.Date')}} </th>
                                        <th scope="col">{{__('common.Type')}} </th>
                                        <th scope="col">{{__('common.Status')}} </th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($records))
                                        @forelse ($records as $key=>$record)
                                            @php
                                                if (empty($record->course->id)){
                                                    continue;
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{@$key+1}}</td>
                                                <td>{{ $record->course->title }}</td>
                                                <td>{{getPriceFormat($record->purchase_price)}}   </td>
                                                <td>{{$record->request_from}}   </td>
                                                <td>{{ showDate($record->created_at) }}</td>
                                                <td>{{$record->refund == 1 ? trans('frontend.Refund') : trans('frontend.Cancel')}}</td>
                                                <td>
                                                    @if($record->status ==1)
                                                        {{__('common.Approved')}}
                                                    @elseif($record->status ==0)
                                                        {{__('common.Pending')}}
                                                    @else
                                                        {{__('common.Reject')}}
                                                    @endif

                                                </td>

                                                <td>

                                                    @if($record->status ==1)
                                                        <a class="theme_btn_mini"
                                                           href="{{route('addToCart',[$record->course->id])}}">
                                                            {{__('common.Add To Cart')}}
                                                        </a>
                                                    @endif
                                                    <a data-heading="{{$record->status == 2 ?'Reject Reason':"Refund/Cancellation Reason"}}"
                                                       data-reason="{{$record->status == 2 ?$record->cancel_reason:$record->reason}}"
                                                       class="theme_btn_mini show_reason">
                                                        {{__('frontend.Reason')}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">
                                                    {{__('common.No data available in the table')}}
                                                </td>
                                            </tr>
                                        @endforelse
                                    @endif
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                    {{ $records->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade leaderboard-boarder" id="reasonShowModal" tabindex="-1" role="dialog"
         aria-labelledby="myLeaderBoard"
         aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="reason_heading"></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="reason_body"></p>
                </div>
            </div>
        </div>
    </div>


</div>
