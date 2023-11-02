<ul class="list-unstyled contacts">
@foreach($conversation as $list)
        <li data-toggle="tab" data-target="#inbox-message-" class="message-view" data-id="{{$list->id}}" data-rec="{{$list->sender_id}}">

            <img alt="" class="img-circle medium-image list-img" src="https://bootdey.com/img/Content/avatar/avatar1.png">

            <div class="vcentered info-combo">
                <h3 class="no-margin-bottom name name-display{{$list->id}}"> {{$list->findSender->name}} </h3>
                <h5> {{!empty($list->latestMeasure()->latest()->first()->message)?$list->latestMeasure()->latest()->first()->message:''}}</h5>
            </div>
            <div class="contacts-add">
                <span class="message-time">{{!empty($list->latestMeasure()->latest()->first()->findSender->created_at)?$list->latestMeasure()->latest()->first()->created_at->diffForHumans():''}}</span>
                @if($list->messagesview->count() > 0)
                    @php $count = 0; @endphp
                    @foreach($list->messagesview as $viewcount)
                        @if($viewcount->status == 0)
                            @php $count++; @endphp
                        @endif
                    @endforeach
                    @if($count > 0)
                        <div class="message-count">{{$count}}</div>
                    @endif
                @endif
            </div>
        </li>
        <div style="display: none" class="block-div{{$list->id}}" data-block="{{$list->id}}">
            @if($list->status == 1)
                <a class="chat-block" data-id="{{$list->id}}" data-status="0" style="color: red">
                   Click to Block  <i class="fa fa-lock block-unlock" aria-hidden="true"></i>
                </a>
            @else
                <a class="chat-block" data-id="{{$list->id}}" data-status="1" style="color: #008000">
                    Click to Un-block  <i class="fa fa-unlock block-lock" aria-hidden="true"></i>
                </a>
            @endif
        </div>


@endforeach
    </ul>

