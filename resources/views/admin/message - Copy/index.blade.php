@extends('admin.master.master')
<!-- Content Wrapper. Contains page content -->

@section('title', 'Users')

@section('head')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('admin/adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

    <style type="text/css">
        .container{max-width:1170px; margin:auto;}
        img{ max-width:100%;}
        .inbox_people {
            background: #f8f8f8 none repeat scroll 0 0;
            float: left;
            overflow: hidden;
            width: 40%; border-right:1px solid #c4c4c4;
        }
        .inbox_msg {
            border: 1px solid #c4c4c4;
            clear: both;
            overflow: hidden;
        }
        .top_spac{ margin: 20px 0 0;}


        .recent_heading {float: left; width:40%;}
        .srch_bar {
            display: inline-block;
            text-align: right;
            width: 60%; padding:
        }
        .headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;
            margin-left: -8px;
            background: radial-gradient(circle, rgb(5 114 143) 10%, rgb(2 82 103) 100%);}

        .recent_heading h4 {
            color: white;
            font-size: 21px;
            margin: auto;
        }
        .srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
        .srch_bar .input-group-addon button {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            padding: 0;
            color: #707070;
            font-size: 18px;
        }
        .srch_bar .input-group-addon { margin: 0 0 0 -27px;}

        .chat_ib h5{ font-size:15px; color:black; margin:0 0 8px 0;}
        .chat_ib h5 span{ font-size:13px; float:right;}
        .chat_ib p{ font-size:14px; color:black; margin:auto}
        .chat_img {
            float: left;
            width: 11%;
        }
        .chat_ib {
            position: relative;
            padding: 0 0 0 15px;
            top: 15px;
            left: 20px;
            width: 300px;
            text-transform: capitalize;
        }

        .chat_people{ overflow:inherit; clear:both;}
        .chat_list {
            border-bottom: 1px solid #c4c4c4;
            margin: 0;
            padding: 10px 16px 10px;
            cursor: pointer;
        }
        .chat_list.active {
            background: #6c757d91;
        }
        .inbox_chat { height: 550px; overflow-y: scroll;}

        .active_chat{ background:#ebebeb;}

        .incoming_msg_img {
            display: inline-block;
            width: 6%;
        }
        .received_msg {
            display: inline-block;
            padding: 0 0 0 10px;
            vertical-align: top;
            width: 92%;
        }
        .received_withd_msg p {
            background: #ebebeb none repeat scroll 0 0;
            border-radius: 3px;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }
        .time_date {
            color: #747474;
            display: block;
            font-size: 12px;
            margin: 8px 0 0;
        }
        .received_withd_msg { width: 57%;}
        .mesgs {
            float: left;
            padding: 30px 15px 0 25px;
            width: 60%;
        }

        .sent_msg p {
            background: #05728f none repeat scroll 0 0;
            border-radius: 3px;
            font-size: 14px;
            margin: 0; color:#fff;
            padding: 5px 10px 5px 12px;
            width:100%;
        }
        .outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
        .sent_msg {
            float: right;
            width: 46%;
        }
        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
            padding: 0px 53px 0px 18px;
        }

        .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
        .msg_send_btn {
            background: #05728f none repeat scroll 0 0;
            border: medium none;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            font-size: 17px;
            height: 33px;
            position: absolute;
            right: 0;
            top: 11px;
            width: 33px;
        }
        .messaging { padding: 0 0 50px 0;}
        .msg_history {
            height: 516px;
            overflow-y: auto;
        }
        .main-body{
            padding-top: 35px;
        }
        .chat_list:hover {
            border-bottom: 1px solid #c4c4c4;
            margin: 0;
            padding: 18px 16px 10px;
            background: #b5b5b5;
        }
        .empty-msg{
            color: gray;
            font-size: 30px;
        }
        .notifiction-avatar .avatar {
            position: relative;
            display: inline-block;
            width: 40px;
            white-space: nowrap;
            border-radius: 1000px;
            vertical-align: bottom;
            background: #0275d8;
            color: white;
        }
        .notifiction-user-first-alpha {
            text-align: center;
            line-height: 3;
            font-weight: bold;
        }
        .chat_img .notifiction-avatar.avatar-online{
            position: relative;
            background: radial-gradient(circle, rgba(3,104,130,1) 10%, rgba(0,34,43,1) 100%);
            color: white;
            border-radius: 30px;
            position: relative;
            display: inline-block;
            width: 50px;
            white-space: nowrap;
            border-radius: 1000px;
            vertical-align: sub;
            height: 50px;
        }
        .notifiction-avatar.avatar-online{
            position: relative;
            background-color: #ebebeb;
            border-radius: 30px;
            position: relative;
            display: inline-block;
            width: 50px;
            white-space: nowrap;
            border-radius: 1000px;
            vertical-align: sub;
            height: 50px;
        }
        .msg_history-empty i {
            font-size: 113px;
            opacity: 15%;
            padding: 26%;
            color: #05728f;
        }
        .loader {
            animation: loader 800ms step-end infinite;
            width: 40px;
            height: 100px;
            transform: rotate(
                0deg
            );
            margin-left: 45%;
            margin-top: 20%;
        }
        .loader path {
            fill: #24282c;
        }

        @keyframes loader {
            12.5% {
                transform: rotate(45deg);
            }
            25% {
                transform: rotate(90deg);
            }
            37.5% {
                transform: rotate(135deg);
            }
            50% {
                transform: rotate(180deg);
            }
            62.5% {
                transform: rotate(225deg);
            }
            75% {
                transform: rotate(270deg);
            }
            87.5% {
                transform: rotate(315deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        .chat-block{
            position: relative;
            left: 65%;
            bottom: 33px;
        }
        .block-lock{
            font-size: 13px;
            position: relative;
            left: 2%;
            color: red;
        }
        .block-unlock{
            font-size: 13px;
            position: relative;
            left: 2%;
            color: #01ff70;
        }
    </style>

@endsection

@section('content')
    <div class="content-wrapper">
    <div class="container main-body">
        <div class="messaging">
            <div class="inbox_msg row">
                <div class="inbox_people col-md-4">
                    <div class="headind_srch">
                        <div class="recent_heading">
                            <h4>Recent</h4>
                        </div>
                        <div class="srch_bar">
{{--                            <div class="stylish-input-group">--}}
{{--                                <input type="text" class="search-bar"  placeholder="Search" >--}}
{{--                                <span class="input-group-addon">--}}
{{--                                    <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>--}}
{{--                                </span>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    <div class="inbox_chat">
                        <svg class="loader" version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                            <path fill="#4468d6" d="M256.011 0c-12.852 0-23.273 10.42-23.273 23.273v93.091c0 12.854 10.421 23.274 23.273 23.274 12.853 0 23.272-10.421 23.272-23.274v-93.091c0-12.853-10.419-23.273-23.272-23.273z"></path>
                            <path fill="#4468d6" opacity="0.4" d="M256.011 372.363c-12.852 0-23.273 10.421-23.273 23.272v93.091c0 12.853 10.421 23.274 23.273 23.274 12.853 0 23.272-10.421 23.272-23.274v-93.091c0-12.853-10.419-23.272-23.272-23.272z"></path>
                            <path fill="#4468d6" opacity="0.8" d="M173.725 140.809l-65.826-65.828c-9.086-9.089-23.822-9.089-32.912 0-9.089 9.089-9.089 23.824 0 32.912l65.826 65.828c4.544 4.544 10.5 6.816 16.455 6.816s11.912-2.273 16.455-6.816c9.090-9.089 9.090-23.823 0.001-32.912z"></path>
                            <path fill="#4468d6" opacity="0.1" d="M459.806 232.727h-46.546c-12.853 0-23.272 10.421-23.272 23.273 0 12.853 10.419 23.272 23.272 23.272h46.546c12.853 0 23.272-10.419 23.272-23.273 0-12.852-10.421-23.273-23.272-23.273z"></path>
                            <path fill="#4468d6" opacity="0.3" d="M365.557 338.281c-9.087-9.089-23.823-9.087-32.913 0-9.088 9.089-9.087 23.823 0 32.913l65.828 65.825c4.544 4.544 10.502 6.817 16.457 6.817 5.957 0 11.913-2.274 16.455-6.817 9.089-9.089 9.089-23.825 0-32.913l-65.828-65.825z"></path>
                            <path fill="#4468d6" opacity="0.6" d="M139.637 256c0-12.852-10.421-23.273-23.273-23.273h-93.091c-12.853 0-23.273 10.421-23.273 23.273 0 12.853 10.42 23.272 23.273 23.272h93.091c12.852 0 23.273-10.419 23.273-23.273z"></path>
                            <path fill="#4468d6" opacity="0.5" d="M173.735 338.283c-9.087-9.089-23.825-9.089-32.912 0l-65.825 65.825c-9.089 9.087-9.089 23.825 0 32.913 4.544 4.544 10.501 6.815 16.457 6.815s11.913-2.271 16.455-6.815l65.825-65.825c9.089-9.087 9.089-23.822 0-32.911z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mesgs col-md-8">
                    <div class="headind_srch">
                        <div class="recent_heading">
                            <h4>Recent</h4>
                        </div>
                    </div>
                    <div class="msg_history">
                        <div class="text-center">
                            <h4 class="empty-msg msg_history-empty"><i class="far fa-comments"></i></h4>
                        </div>
                    </div>
                    <div class="type_msg">
                        <div class="input_msg_write">

                                <input type="text" class="write_msg" id="message-text" placeholder="Type a message" />
                                <input type="hidden" id="convId" name="convId" value="">
                                <input type="hidden" id="receiverId" name="receiverId" value="">
                                <button id="send-message" class="msg_send_btn" type="button"><i class="fas fa-paper-plane"></i>
                                </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <div class="load" style="display: none">
        <svg class="loader" version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
            <path fill="#4468d6" d="M256.011 0c-12.852 0-23.273 10.42-23.273 23.273v93.091c0 12.854 10.421 23.274 23.273 23.274 12.853 0 23.272-10.421 23.272-23.274v-93.091c0-12.853-10.419-23.273-23.272-23.273z"></path>
            <path fill="#4468d6" opacity="0.4" d="M256.011 372.363c-12.852 0-23.273 10.421-23.273 23.272v93.091c0 12.853 10.421 23.274 23.273 23.274 12.853 0 23.272-10.421 23.272-23.274v-93.091c0-12.853-10.419-23.272-23.272-23.272z"></path>
            <path fill="#4468d6" opacity="0.8" d="M173.725 140.809l-65.826-65.828c-9.086-9.089-23.822-9.089-32.912 0-9.089 9.089-9.089 23.824 0 32.912l65.826 65.828c4.544 4.544 10.5 6.816 16.455 6.816s11.912-2.273 16.455-6.816c9.090-9.089 9.090-23.823 0.001-32.912z"></path>
            <path fill="#4468d6" opacity="0.1" d="M459.806 232.727h-46.546c-12.853 0-23.272 10.421-23.272 23.273 0 12.853 10.419 23.272 23.272 23.272h46.546c12.853 0 23.272-10.419 23.272-23.273 0-12.852-10.421-23.273-23.272-23.273z"></path>
            <path fill="#4468d6" opacity="0.3" d="M365.557 338.281c-9.087-9.089-23.823-9.087-32.913 0-9.088 9.089-9.087 23.823 0 32.913l65.828 65.825c4.544 4.544 10.502 6.817 16.457 6.817 5.957 0 11.913-2.274 16.455-6.817 9.089-9.089 9.089-23.825 0-32.913l-65.828-65.825z"></path>
            <path fill="#4468d6" opacity="0.6" d="M139.637 256c0-12.852-10.421-23.273-23.273-23.273h-93.091c-12.853 0-23.273 10.421-23.273 23.273 0 12.853 10.42 23.272 23.273 23.272h93.091c12.852 0 23.273-10.419 23.273-23.273z"></path>
            <path fill="#4468d6" opacity="0.5" d="M173.735 338.283c-9.087-9.089-23.825-9.089-32.912 0l-65.825 65.825c-9.089 9.087-9.089 23.825 0 32.913 4.544 4.544 10.501 6.815 16.457 6.815s11.913-2.271 16.455-6.815l65.825-65.825c9.089-9.087 9.089-23.822 0-32.911z"></path>
        </svg>
    </div>

@endsection
@section('js')
    <script>

        function convlist () {
            $.ajax({
                url     : '{{URL::to('get-conversation-list')}}',
                method  : 'get',
                success : function(data){
                    // console.log(data);
                    $('.inbox_chat').html(data.result);
                }
            });
        }
        // convlist();
        setInterval(function (e) {
            convlist();
        },3000)

        var conv_id = 0;
        var reciver_id = 0;

        $(document).on('click','.message-view',function (e) {
            $('.chat_list.active').removeClass('active')
            $(this).parent().addClass('active');
             conv_id  = $(this).attr('data-id');
             reciver_id = $(this).attr('data-rec');

            $('.msg_history').html($('.load').html());

            setInterval(function (e) {
                mesview();
            },3000)
            setTimeout(function () {
                $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
            },3500)
        })

        function mesview() {

            $.ajax({
                url: '{{URL::to('get-conversation')}}',
                method: 'get',
                data: {"id": conv_id},
                success: function (data) {
                    // alert(data.result);
                    $('#convId').val(conv_id);
                    $('#receiverId').val(reciver_id);
                    $('.msg_history').html(data.result);

                }
            });
        }

        $(document).on('click','#send-message',function () {
            let txt = $('#message-text').val();
            let conid = $('#convId').val();
            let recId = $('#receiverId').val();
            if(conid)
            {
                $.ajax({
                    url     : '{{route('post-message')}}',
                    method  : 'post',
                    data: {"text": txt,'conid':conid,'recId':recId,'_token':'{{csrf_token()}}'},
                    success : function(data){
                        console.log(data);
                        if(data.status == 200)
                        {
                            $('.msg_history').html(data.result);
                            $('#message-text').val('');
                            $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
                        }
                    }
                });
            }else{

            }
        });
        $(document).on('click','.chat-block',function (e) {
            conv_id  = $(this).attr('data-id');
            status  = $(this).attr('data-status');
            $.ajax({
                url: '{{URL::to('conversation-block')}}',
                method: 'get',
                data: {"id": conv_id,'status':status},
                success: function (data) {
                }
            });
        });
    </script>
@endsection
