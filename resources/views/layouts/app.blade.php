<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'SAVOY 3D' }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .log-btn {
            /* border:1px solid #b2f918; */
            color: #b2f918;
            border-radius: 7px;
            margin: 5px;
            Font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
        }

        #navbarDropdown,
        .reg-btn {
            /* border:  1px solid #b2f918; */
            color: #b2f918;
            border-radius: 7px;
            margin: 5px;
            Font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
        }

        .navbar-brand {
            Font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
            font-size: xx-large;
            font-weight: 700;
            color: #b2f918 !important;
        }

        .log-btn:hover {
            color: #b2f918 !important;
            text-shadow: #b2f918 !important;
        }

        .reg-btn:hover {
            color: #b2f918 !important;
            text-shadow: #b2f918 !important;
        }

        .py-4 {
            background-color: #000 !important;
            min-height: 100vh;
        }

        .container .section-title {
            Font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif !important;
            font-size: x-large !important;
            color: #fff !important;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .container a {
            text-decoration: none !important;
        }

        .container h2 {
            color: #fff;
        }

        .container .image-container {
            margin-bottom: 15px;
        }

        .card-img-top {
            /* width: 200px !important; */
            height: auto;
        }

        form {
            max-width: 80%;
            margin: 0 auto;
            position: relative;
        }

        .input-group {
            position: relative;
        }

        label {
            position: absolute;
            right: 2%;
            top: 50%;
            transform: translatey(-50%);
            color: rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease;
        }

        input {
            width: 100%;
            padding: 8px 30px 8px 12px;
            border: 2px solid rgba(0, 0, 0, 0.08);
            outline: none;
            font-size: 16px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.06);
            color: #F27121;
            font-weight: bold;
            letter-spacing: 1px;
            border-radius: 1px;
            transition: all 0.2s ease;
        }

        input:focus {
            border-color: #F27121;
        }

        input:focus+label {
            transform: scale(1.05) translatey(-50%);
            color: #F27121;
        }

        #apps {
            margin-top: 42px;
        }

        .app {
            display: inline-block;
            width: 20%;
            margin: 0 2.2% 24px;
            padding: 12px 6px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            transition: all 0.2s ease;
        }

        .app:hover {
            border-color: rgba(255, 255, 255, 0.5);
        }

        .app i {
            font-size: 2.4em;
            color: #fff;
        }

        .app p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
            margin-top: 6px;
            transition: 0.2s all ease;
        }

        .app:hover p {
            color: rgba(255, 255, 255, 0.8);
        }

        .suggestion-list {
            background-color: #fff;
            padding: 18px 24px 6px 12px;
            border-radius: 0 0 6px 6px;
            position: absolute;
            width: 100%;
            margin-top: 0px;
            border: 2px solid #F27121;
            border-top: none;
            z-index: 1000;
        }

        .suggestion-list.hidden {
            display: none;
        }

        .suggestion-list p {
            margin-bottom: 12px;
        }

        .suggestion-list i {
            margin-right: 12px;
            color: #F27121;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm"
            style="min-height: 100px;background-color:rgb(32, 30, 30) !important;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ 'SAVOY 3D' }}
                </a>

                {{-- search bar --}}
                <form style="width: 500px;" id="search-form">
                    <div class="input-group" style="width: 100%">
                        <input type="text" style="width: 100%" id="search" placeholder="Search..." autocomplete="off">
                        <label for="search"><i class="fas fa-search"></i></label>
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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
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

        <main class="py-4">
            @yield('content')
        </main>
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
    