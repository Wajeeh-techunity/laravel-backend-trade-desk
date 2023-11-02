
@foreach($data as $message)
    @if($message->latestMeasure()->latest()->first())
        @if($message->latestMeasure()->latest()->first()->sender_id != auth()->id())
            @if(date_format(date_create($message->latestMeasure()->latest()->first()->created_at),"Y-m-d") > Date('Y-m-d', strtotime('-7 days')))
                <a class="dropdown-item message-view" data-id="{{$message->id}}" data-rec="{{$message->sender_id}}">
                    <!-- Message Start -->
                    <div class="media">
{{--                        <img src="{{asset('admin/adminLTE/dist/img/user1-128x128.jpg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">--}}
                        <div class="incoming_msg_img notifiction-avatar avatar-online" style="right: 10px;">
                            <p class="notifiction-user-first-alpha">{{ substr($message->latestMeasure()->latest()->first()->findSender->name, 0, 1)}}</p>
                        </div>
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                {{$message->latestMeasure()->latest()->first()->findSender->name}}
{{--                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>--}}
                            </h3>
                            <p class="text-sm">{{$message->latestMeasure()->latest()->first()->message}}</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{$message->latestMeasure()->latest()->first()->findSender->created_at->diffForHumans()}}</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
            @endif
        @endif
    @endif
@endforeach
<a class="dropdown-item dropdown-footer" href="{{URL::to('/admin/message')}}">See All Messages</a>
