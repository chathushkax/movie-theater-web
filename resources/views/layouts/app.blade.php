<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'SAVOY' }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        

    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm"
            style="min-height: 100px;background-color:rgb(32, 30, 30) !important;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ 'SAVOY' }}
                </a>

                {{-- search bar --}}
                <form style="width: 500px;" id="search-form">
                    <div class="input-group" style="width: 100%">
                        <input type="text" style="width: 100%" id="search" placeholder="Search Movies..." autocomplete="off">
                        <label for="search" class="search_label"><i class="fas fa-search"></i></label>
                    </div>
                
                    <div class="suggestion-list hidden" id="suggestion-list">
                        <!-- Suggestions will be inserted here -->
                    </div>
                </form>                

                {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> --}}

                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="max-width: 300px">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link log-btn" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link reg-btn" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle user_name" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
        {{-- slider --}}

        <main class="py-4">
            @yield('content')
        </main>

        {{-- chat --}}
        <!-- Chat Icon -->
        <div id="chat-icon" class="chat-icon">
            {{-- <i class="fas fa-comments"></i> --}}
            <img class="chat_icon" src="/images/chat.png" alt="">
        </div>

        <!-- Chat Box -->
        <div id="chat-box" class="chat-box hidden">
            <div class="chat-header">
                <h4 class="live_chat">Live Chat</h4>
                <button id="close-chat" class="close-chat">&times;</button>
            </div>
            <div class="chat-body">
                <p>How can we help you?</p>
                <div id="messages" class="messages">
                    <!-- Messages will be appended here -->
                </div>
                <form id="chat-form">
                    <textarea id="chat-input" placeholder="Type your message..." required></textarea>
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            let query = $(this).val();
            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('search') }}",
                    type: "GET",
                    data: { 'query': query },
                    success: function(data) {
                        $('#suggestion-list').html(data);
                        $('#suggestion-list').removeClass('hidden');
                    }
                });
            } else {
                $('#suggestion-list').html('');
                $('#suggestion-list').addClass('hidden');
            }
        });
    
        $(document).on('click', function(event) {
            if (!$(event.target).closest('#search-form').length) {
                $('#suggestion-list').addClass('hidden');
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const chatIcon = document.getElementById('chat-icon');
    const chatBox = document.getElementById('chat-box');
    const closeChat = document.getElementById('close-chat');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const messagesDiv = document.getElementById('messages');

    chatIcon.addEventListener('click', function () {
        chatBox.classList.toggle('hidden');
        loadMessages();
    });

    closeChat.addEventListener('click', function () {
        chatBox.classList.add('hidden');
    });

    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        sendMessage(chatInput.value);
        chatInput.value = '';
    });

    function loadMessages() {
        fetch('/chat/messages')
            .then(response => response.json())
            .then(data => {
                messagesDiv.innerHTML = '';
                data.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('message');
                    messageElement.innerHTML = `<strong>${message.user.name}:</strong> ${message.message}`;
                    messagesDiv.appendChild(messageElement);
                });
            });
    }

    function sendMessage(message) {
        fetch('/chat/messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            const messageElement = document.createElement('div');
            messageElement.classList.add('message');
            messageElement.innerHTML = `<strong>${data.user.name}:</strong> ${data.message}`;
            messagesDiv.appendChild(messageElement);
        });
    }
});

</script>
    