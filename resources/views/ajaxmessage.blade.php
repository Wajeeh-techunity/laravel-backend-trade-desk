@if(auth()->check())
    @if($messages)
        @foreach($messages as $message)
            @if(auth()->user()->id == $message->sender_id)
                <p class="chatbox__display-chat">{{$message->message}}</p>
            @else
                <p class="chatbox__display-chat chat-admin">{{$message->message}}</p>
            @endif
        @endforeach
    @elseif($conversation == null)
        <p>null</p>
    @endif
@else
    <div class="need-login">
        <a href="#">Login</a>
    </div>

@endif



