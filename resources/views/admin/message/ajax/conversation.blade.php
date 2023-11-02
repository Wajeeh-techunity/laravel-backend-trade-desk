@if($messages->count() > 0)
@foreach($messages as $message)
    @if(auth()->user()->role_id == 1 && auth()->user()->id == $message->sender_id)
        <div class="message my-message">
            <img alt="" class="img-circle medium-image" src="https://bootdey.com/img/Content/avatar/avatar1.png">

            <div class="message-body">
                <div class="message-body-inner">
                    <div class="message-info">
                        <h4>{{$message->findSender->name}} </h4>
                        <h5> <i class="fa fa-clock-o"></i> {{$message->created_at->diffForHumans()}} </h5>
                    </div>
                    <hr>
                    <div class="message-text">
                        {{$message->message}}
                    </div>
                </div>
            </div>
            <br>
        </div>
    @else

        <div class="message info">
            <img alt="" class="img-circle medium-image" src="https://bootdey.com/img/Content/avatar/avatar1.png">

            <div class="message-body">
                <div class="message-info">
                    <h4>{{$message->findSender->name}}</h4>
                    <h5> <i class="fa fa-clock-o"></i>{{$message->created_at->diffForHumans()}}</h5>
                </div>
                <hr>
                <div class="message-text">
                    {{$message->message}}
                </div>
            </div>
            <br>
        </div>
    @endif







@endforeach
@else

        <div class="text-center">
            <h4 class="empty-msg">Empty</h4>
        </div>

@endif


