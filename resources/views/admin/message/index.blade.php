@extends('admin.master.master')
<!-- Content Wrapper. Contains page content -->

@section('title', 'Messanger')

@section('head')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('admin/adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/adminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <style type="text/css">

    </style>

@endsection

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="text-center">Messanger</h1>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" style="color: #6c757d"> <i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li class="breadcrumb-item active">Messanger</li>
                        </ol>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                        <!-- /.card-header -->
                            <div class="card-body messenger-card">
                                <div class="panel messages-panel">
                                    <div class="contacts-list">
                                        <div class="inbox-categories">
                                            <div data-toggle="tab" data-target="#inbox" class="active"> Inbox </div>
                                        </div>
                                        <div class="tab-content">
                                            <div id="inbox" class="contacts-outter-wrapper tab-pane active">
                                                <div class="contacts-outter">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="page-loader" style="display: none !important;">
                                        <div class="d-flex justify-content-center body-loader">
                                            <div class="spinner-border" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane message-body active" id="inbox-message-1">
                                            <div class="message-top">
                                                <span class="user-name"></span>
                                                <a class="btn new-message swalDefaultSuccess"></a>

                                                <div class="new-message-wrapper">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Send message to...">
                                                        <a class="btn btn-danger close-new-message" href="#"><i class="fa fa-times"></i></a>
                                                    </div>

                                                    <div class="chat-footer new-message-textarea">
                                                        <textarea class="send-message-text"></textarea>
                                                        <label class="upload-file">
                                                            <input type="file" required="">
                                                            <i class="fa fa-paperclip"></i>
                                                        </label>
                                                        <button type="button" class="send-message-button btn-info"> <i class="fa fa-send"></i> </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="message-chat">
                                                <div class="chat-body">
                                                    <div class="text-center">
                                                        <h4 class="empty-msg msg_history-empty"><i class="far fa-comments"></i></h4>
                                                    </div>
                                                </div>

                                                <div class="chat-footer">
                                                    <textarea class="send-message-text" id="message-text"></textarea>
                                                    <input type="hidden" name="receiverId" id="receiverId" value="0">
                                                    <input type="hidden" name="convId" id="convId" value="0">
                                                    <button type="button" class="send-message-button send-message" id="send-message"> <i class="fa fa-send"></i> </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>

        function convlist () {
            $.ajax({
                url     : '{{URL::to('get-conversation-list')}}',
                method  : 'get',
                success : function(data){
                    // console.log(data);
                    $('.contacts-outter').html(data.result);
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
            // $('.list-unstyled .contacts .active').children().removeClass('active');
            $(".list-unstyled>li").removeClass("active");
            $(this).addClass('active');
             conv_id  = $(this).attr('data-id');
             reciver_id = $(this).attr('data-rec');

            $('.chat-body').html($('.page-loader').html());

            setInterval(function (e) {
                mesview();
            },3000)
            setTimeout(function () {
                $('.chat-body').scrollTop($('.chat-body')[0].scrollHeight);
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
                    $('.chat-body').html(data.result);
                    $('.new-message').html($('.block-div'+conv_id).html());
                    $('.user-name').html($('.name-display'+conv_id).html());
                }
            });
        }

        $(document).on('keypress',function(e) {
            let txt = $('#message-text').val();
            if(txt !== ' ')
            {
                if(e.which == 13) {
                    sendMessage();
                }
            }

        });

        $(document).on('click','#send-message',function () {
            sendMessage();
        });

        function sendMessage(){
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
                            $('.chat-body').html(data.result);
                            $('#message-text').val('');
                            $('.chat-body').scrollTop($('.chat-body')[0].scrollHeight);
                        }
                    }
                });
            }else{

            }
        }
        $(document).on('click','.chat-block',function (e) {
            conv_id  = $(this).attr('data-id');
            status  = $(this).attr('data-status');
            $.ajax({
                url: '{{URL::to('conversation-block')}}',
                method: 'get',
                data: {"id": conv_id,'status':status},
                success: function (data) {
                    if(data.result == 0){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Blocked Successful',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }else{
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Un-blocke Successful',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }

                }
            });
        });
    </script>
@endsection
