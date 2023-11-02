@foreach($conversation as $list)
    <div class="chat_list">
        <a class="message-view" data-id="{{$list->id}}" data-rec="{{$list->sender_id}}">
            <div class="chat_people">
                <div class="chat_img">
                    @if($list->findSender->image != null)
                        <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                    @else
                        <div class="incoming_msg_img notifiction-avatar avatar-online">
                            <p class="notifiction-user-first-alpha">{{ substr($list->findSender->name, 0, 1)}}</p>
                        </div>
                    @endif

                </div>
                <div class="chat_ib">
                    <h5>{{$list->findSender->name}}<span class="chat_date">
                            @if($list->messagesview->count() > 0)
                                @php $count = 0; @endphp
                                @foreach($list->messagesview as $viewcount)
                                    @if($viewcount->status == 0)
                                        @php $count++; @endphp
                                    @endif
                                @endforeach
                                @if($count > 0)
                                    <label class="badge badge-danger">{{$count}}</label>
                                @endif
                            @endif
                        </span></h5>
                </div>
            </div>
        </a>

            @if($list->status == 1)
                <a class="chat-block" data-id="{{$list->id}}" data-status="0">
                    Block<i class="fa fa-unlock block-unlock" aria-hidden="true"></i>
                </a>
            @else
                <a class="chat-block" data-id="{{$list->id}}" data-status="1">
                    Un-block<i class="fas fa-lock block-lock" aria-hidden="true"></i>
                </a>
            @endif


    </div>
@endforeach

