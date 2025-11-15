@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('ticket.support_ticket')}}
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/support.css')}}{{assetVersion()}}">
@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/support.js')}}"></script>
@endsection

@section('mainContent')
    <div class="main_content_iner support_main main_content_padding">
        <div class="dashboard_lg_card">
            <div class="support_main_card_title">
                <h5>{{__('ticket.support_ticket')}}</h5>
                <a href="{{route('student.support-ticket.create')}}" class="theme_btn support_modfiy"><i
                        class="ti ti-plus"></i>{{__('common.Add New')}}</a>
            </div>
            <div class="support_main_card p-0">
                <form action="">
                    <div class="support_main_card_content">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="support_main_card_content_item">
                                    <label for="#" class='primary_label2'>{{__('common.Category')}}</label>
                                    <select name="category" id="" class="theme_select w-100">
                                        <option value="">{{__('common.Select')}}</option>
                                        @foreach($CategoryList as $category)
                                            <option
                                                {{request()->category==$category->id?'selected':''}} value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="support_main_card_content_item">
                                    <label for="#" class='primary_label2'>{{__('common.Priority')}}</label>
                                    <select name="priority" id="" class="theme_select w-100">
                                        <option value="">{{__('common.Select')}}</option>
                                        @foreach($PriorityList as $priority)
                                            <option
                                                {{request()->priority==$priority->id?'selected':''}} value="{{$priority->id}}">{{$priority->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="support_main_card_content_item">
                                    <label for="#" class='primary_label2'>{{__('common.Status')}}</label>
                                    <select name="status" id="" class="theme_select w-100">
                                        <option value="">{{__('common.Select')}}</option>
                                        @foreach($StatusList as $status)
                                            <option
                                                {{request()->status==$status->id?'selected':''}} value="{{$status->id}}">{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <div class="search_action">
                                    <button type="submit" class="theme_btn support_modfiy"><i
                                            class="ti ti-search"></i>{{__('common.Search')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="support_main_card_title mobile_wrap">
                <h5>Support List</h5>
                <div class="support_main_card_title_tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="active-tab" data-bs-toggle="tab"
                                    data-bs-target="#active"
                                    type="button" role="tab" aria-controls="active" aria-selected="false">Active
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="closed-tab" data-bs-toggle="tab" data-bs-target="#closed"
                                    type="button"
                                    role="tab" aria-controls="closed" aria-selected="false">Clsoed
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="all-tricket-tab" data-bs-toggle="tab"
                                    data-bs-target="#all-tricket"
                                    type="button" role="tab" aria-controls="all-tricket" aria-selected="true">All
                                Tricket
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="support_main_card p-0 m-0">
                <div class="support_main_ticket">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                            <table class='table'>
                                <thead>
                                <th>{{__('common.SL')}}</th>
                                <th>{{__('ticket.ticket')}} {{__('ticket.summery')}}</th>
                                <th>{{__('common.Date')}}</th>
                                <th>{{__('ticket.assigned')}}</th>
                                <th>{{__('common.Status')}}</th>
                                <th>{{__('ticket.last_update')}}</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @forelse ($activeTickets as $key=>$ticket)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>
                                            <a href="{{route('student.support-ticket.show',$ticket->id)}}"
                                               class='support_main_ticket_link {{$ticket->messages->count() < 1 ? "fw-bold":""}}'> {{$ticket->reference_no}}

                                            </a>
                                            <p>{{$ticket->subject}}</p>
                                            <span class="public_date">{{$ticket->created_at->diffForHumans()}}</span>
                                        </td>
                                        <td>{{showDate($ticket->created_at)}}</td>
                                        <td>{{!empty($ticket->refer_id)?$ticket->assignUser->name:''}}</td>
                                        <td>{{$ticket->status->name}}</td>
                                        <td>
                                            {{$ticket->created_at->diffForHumans()}}
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{route('student.support-ticket.show',$ticket->id)}}"
                                                   class='theme_btn'><i
                                                        class="ti ti-eye"></i></a>
                                                <a href="{{route('student.support-ticket.edit',$ticket->id)}}"
                                                   class='theme_btn'><i class="ti ti-pencil-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            {{__(trans('ticket.no_ticket_found'))}}
                                        </td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="closed" role="tabpanel" aria-labelledby="closed-tab">
                            <table class='table'>
                                <thead>
                                <th>{{__('common.SL')}}</th>
                                <th>{{__('ticket.ticket')}} {{__('ticket.summery')}}</th>
                                <th>{{__('common.Date')}}</th>
                                <th>{{__('ticket.assigned')}}</th>
                                <th>{{__('common.Status')}}</th>
                                <th>{{__('ticket.last_update')}}</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @forelse ($closedTickets as $key=>$ticket)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>
                                            <a href="{{route('student.support-ticket.show',$ticket->id)}}"
                                               class='support_main_ticket_link {{$ticket->seen==0?'fw-bold':''}}'> {{$ticket->reference_no}}

                                            </a>
                                            <p>{{$ticket->subject}}</p>
                                            <span class="public_date">{{$ticket->created_at->diffForHumans()}}</span>
                                        </td>
                                        <td>{{showDate($ticket->created_at)}}</td>
                                        <td>{{!empty($ticket->refer_id)?$ticket->assignUser->name:''}}</td>
                                        <td>{{$ticket->status->name}}</td>
                                        <td>
                                            {{$ticket->created_at->diffForHumans()}}
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{route('student.support-ticket.show',$ticket->id)}}"
                                                   class='theme_btn'><i
                                                        class="ti ti-eye"></i></a>
                                                <a href="{{route('student.support-ticket.edit',$ticket->id)}}"
                                                   class='theme_btn'><i class="ti ti-pencil-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">
                                            {{__(trans('ticket.no_ticket_found'))}}
                                        </td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="all-tricket" role="tabpanel" aria-labelledby="all-tricket-tab">
                            <table class='table'>
                                <thead>
                                <th>{{__('common.SL')}}</th>
                                <th>{{__('ticket.ticket')}} {{__('ticket.summery')}}</th>
                                <th>{{__('common.Date')}}</th>
                                <th>{{__('ticket.assigned')}}</th>
                                <th>{{__('common.Status')}}</th>
                                <th>{{__('ticket.last_update')}}</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @forelse ($userTickets as $key=>$ticket)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>
                                            <a href="{{route('student.support-ticket.show',$ticket->id)}}"
                                               class='support_main_ticket_link {{$ticket->seen==0?'fw-bold':''}}'> {{$ticket->reference_no}}

                                            </a>
                                            <p>{{$ticket->subject}}</p>
                                            <span class="public_date">{{$ticket->created_at->diffForHumans()}}</span>
                                        </td>
                                        <td>{{showDate($ticket->created_at)}}</td>
                                        <td>{{!empty($ticket->refer_id)?$ticket->assignUser->name:''}}</td>
                                        <td>{{$ticket->status->name}}</td>
                                        <td>
                                            {{$ticket->created_at->diffForHumans()}}
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{route('student.support-ticket.show',$ticket->id)}}"
                                                   class='theme_btn'><i
                                                        class="ti ti-eye"></i></a>
                                                <a href="{{route('student.support-ticket.edit',$ticket->id)}}"
                                                   class='theme_btn'><i class="ti ti-pencil-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">
                                            {{__(trans('ticket.no_ticket_found'))}}
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
@endsection
