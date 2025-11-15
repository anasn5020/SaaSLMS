@foreach ($notifications as $notification)
    <a href="{{$notification->data['actionURL']??'#'}}"
       class="single_nofy unread_notification"
       title="Mark As Read" data-notification_id="{{$notification->id}}">
        <div class="notyfy_content">
            <h4>  {!! strip_tags($notification->data['body']) !!}</h4>
            <p>{{$notification->created_at->diffForHumans()}}</p>
        </div>
    </a>
@endforeach
@if($notifications->count()==0)
    <a href="#" class="single_nofy align-items-center justify-content-center">
        <div class="notyfy_content ">
            <h4> {{__('frontend.No unread notification')}}</h4>
        </div>

    </a>
@endif
