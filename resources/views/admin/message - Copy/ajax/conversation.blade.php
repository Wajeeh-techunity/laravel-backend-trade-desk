<div>
    <h5>Name</h5>
</div>
@if($messages->count() > 0)
@foreach($messages as $message)
    @if(auth()->user()->role_id == 1 && auth()->user()->id == $message->sender_id)
        <div class="outgoing_msg">
            <div class="sent_msg">
                <p>{{$message->message}}</p>
                <span class="time_date"> {{$message->created_at->diffForHumans()}}</span> </div>
        </div>
    @else
        <div class="incoming_msg">
            <div class="incoming_msg_img notifiction-avatar avatar-online">
                <p class="notifiction-user-first-alpha">{{ substr($message->findSender->name, 0, 1)}}</p>
            </div>
            <div class="received_msg">
                <div class="received_withd_msg">
                    <p>{{$message->message}}</p>
                    <span class="time_date"> {{$message->created_at->diffForHumans()}}</span></div>
            </div>
        </div>
    @endif

@endforeach
@else

        <div class="text-center">
            <h4 class="empty-msg">Empty</h4>
        </div>

@endif


