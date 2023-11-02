<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            /*chatbox*/
            *,
            *::after,
            *::before {
                box-sizing: border-box;
            }

            body {
                font-family: "Raleway", sans-serif;
            }

            .u-btn {
                all: unset;
                cursor: pointer;
            }

            .chatbox {
                box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.25);
                bottom: 0;
                position: fixed;
                right: 1em;
                transform: translatey(23.5em);
                transition: all 300ms ease;
                width: 18.5em;
            }
            .chatbox--is-visible {
                transform: translatey(0);
            }
            .chatbox__header {
                background: #4e4e4e;
                border-top-right-radius: 0.5em;
                border-top-left-radius: 0.5em;
                display: flex;
                justify-content: space-between;
                padding: 0 0.75em;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            .chatbox__header-cta-text {
                color: #fff;
                font-weight: 300;
                font-size: 1.025rem;
            }
            .chatbox__header-cta-icon {
                color: #fff;
                margin-right: 0.75em;
            }
            .chatbox__header-cta-btn {
                background: none;
                border: none;
                color: #aaa;
                padding: 0.5em;
                transition: all 300ms ease;
            }
            .chatbox__header-cta-btn:hover {
                color: #fff;
            }
            .chatbox__display {
                background: #ededed;
                height: 20em;
                overflow: auto;
                padding: 0.75em;
            }
            .chatbox__display-chat {
                background: #fff;
                border-radius: 0.5em;
                color: #666;
                font-weight: 300;
                font-size: 0.9rem;
                line-height: 1.5;
                padding: 0.75em;
                text-align: justify;
                overflow-wrap: anywhere;
            }
            .chatbox__form {
                display: flex;
            }
            .chatbox__form-input {
                border: none;
                color: #222222;
                font-size: 0.9rem;
                font-weight: 300;
                padding: 1.25em 1em;
                width: 100%;
            }
            .chatbox__form-input:required {
                box-shadow: none;
            }
            .chatbox__form-submit {
                background: none;
                border: none;
                color: #aaa;
                padding: 1em;
            }

            .chat-admin{
                background-color: #4e4e4e;
                color: white;
            }
            .need-login a {
                text-decoration: none;
                color: black;
                font-size: 20px;
                font-family: -webkit-body;
            }
            .need-login {
                text-align: center;
                margin-top: 50%;
            }
        </style>

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>

            </div>
        </div>
        @if($site_settings->messenger == 1)
 <!-- chatbox -->
        <section class="chatbox js-chatbox">
            <div class="chatbox__header">
                <h3 class="chatbox__header-cta-text"><span class="chatbox__header-cta-icon"><i
                            class="fa fa-comments"></i></span>Let's chat</h3>
                <button class="js-chatbox-toggle chatbox__header-cta-btn u-btn"><i class="fa fa-chevron-up"></i></button>
            </div>
            <!-- End of .chatbox__header -->
            <div class="js-chatbox-display chatbox__display">

            </div>
            <!-- End of .chatbox__display -->
            <form class="js-chatbox-form chatbox__form">
                <input type="text" class="js-chatbox-input chatbox__form-input" id="message-text" placeholder="Type your message..." required>
                <button class="chatbox__form-submit u-btn" id="message-button"><i class="fa fa-paper-plane"></i></button>
            </form>
            <!-- End of .chatbox__form -->
        </section>
        <!-- End of .chatbox -->
        @endif
    </body>
    @if($site_settings->messenger == 1)
    <!-- .chatbox -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        const toggleChatboxBtn = document.querySelector(".js-chatbox-toggle");
        const chatbox = document.querySelector(".js-chatbox");
        const chatboxMsgDisplay = document.querySelector(".js-chatbox-display");
        const chatboxForm = document.querySelector(".js-chatbox-form");

        // Use to create chat bubble when user submits text
        // Appends to display
        const createChatBubble = input => {
            // const chatSection = document.createElement("p");
            // chatSection.textContent = input;
            // chatSection.classList.add("chatbox__display-chat");
            //
            // chatboxMsgDisplay.appendChild(chatSection);
            let txt = $('#message-text').val();

            $.ajax({
                url     : '{{route('post-chat')}}',
                method  : 'post',
                data: {"text": txt,'_token':'{{csrf_token()}}'},
                success : function(data){
                    // console.log(data);
                    if(data.status == 200)
                    {
                        console.log(data);
                        // $('.msg_history').html(data.result);
                        $('.chatbox__display').html(data.result);
                        $('.js-chatbox-display').scrollTop($('.js-chatbox-display')[0].scrollHeight);
                    }
                }
            });
        };

        // Toggle the visibility of the chatbox element when clicked
        // And change the icon depending on visibility
        toggleChatboxBtn.addEventListener("click", () => {
            chatbox.classList.toggle("chatbox--is-visible");

            if (chatbox.classList.contains("chatbox--is-visible")) {
                toggleChatboxBtn.innerHTML = '<i class="fa fa-chevron-down"></i>';
            } else {
                toggleChatboxBtn.innerHTML = '<i class="fa fa-chevron-up"></i>';
            }
        });

        // Form input using method createChatBubble
        // To append any user message to display
        chatboxForm.addEventListener("submit", e => {
            const chatInput = document.querySelector(".js-chatbox-input").value;

            createChatBubble(chatInput);

            e.preventDefault();
            chatboxForm.reset();
        });

        function getChat () {
            $.ajax({
                url     : '{{URL::to('get-chat')}}',
                method  : 'get',
                success : function(data){
                    console.log(data);
                    $('.chatbox__display').html(data.result);
                    $('.js-chatbox-display').scrollTop($('.js-chatbox-display')[0].scrollHeight);
                    if(data.status == 0)
                    {
                        $("#message-text").attr('disabled','disabled');
                        $("#message-button").attr('disabled','disabled');
                        $("#message-text").val('Conversation Blocked');
                    }else{

                        if ($('#message-text').prop('disabled')){
                            $("#message-text").removeAttr('disabled');
                            $("#message-button").removeAttr('disabled');
                            $("#message-text").val('');
                        }

                    }
                }
            });
        }

        setInterval(function (e) {
            getChat();
        },3000)

    </script>
    @endif
    <!-- End of .chatbox -->
</html>
