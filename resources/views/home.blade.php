<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Home</title>

        <!-- Styles -->
        <link href="{{ asset('resources/css/bulma.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/css/app.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/account') }}">{{ Auth::user()->name }}</a>
                        <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Shorten a Link &#128279;
                </div>

                <div class="subtitle m-b-md">
                    <form method="POST" action="{{ url('/home') }}">
                        @csrf

                        @if ($errors->has('link_success'))
                        <div class="link_success">{{ $errors->first('link_success') }}</div>
                        @endif

                        @if ($errors->has('link_error'))
                        <div class="link_error">{{ $errors->first('link_error') }}</div>
                        @endif

                        <input id="link" type="url" class="input" name="link" required>
                        <br>
                        <br>
                        <div style="text-align: center;" class="control">
                          <button class="button is-link">Shorten</button>
                        </div>
                    </form>
                </div>

                <div class="links">
                    <a href="https://github.com/xseano/">Author</a>
                    <a href="https://github.com/xseano/Linkify">Source Code</a>
                    <a href="{{ url('/about') }}">About</a>
                </div>
            </div>
        </div>
    </body>
</html>
