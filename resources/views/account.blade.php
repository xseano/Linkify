<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dashboard</title>

        <!-- Styles -->
        <link href="{{ asset('resources/css/bulma.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/css/app.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="{{ asset('resources/js/app.js') }}"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
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
                    Account Information
                </div>

                <div class="subtitle m-b-md">
                    <div class="tabs is-centered">
                        <ul>
                            <li class="is-active" id="infoTab">
                                <a>Information</a>
                            </li>
                            <li id="linksTab">
                                <a>Links</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="subtitle m-b-md">

                    <div class="content" id="information">
                        <h1 class="title">{{ Auth::user()->name }}</h1>
                        <p>Email: {{ Auth::user()->email }}</p>
                        <p>Account created on: {{ date('F d, Y', strtotime(date('d-m-Y', strtotime(Auth::user()->created_at)))) }}</p>
                    </div>

                    <div class="content tableContent" id="links" style="display: none;">
                        @if(count($links) != 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Ref ID</th>
                                    <th>Uses</th>
                                    <th>Original Link</th>
                                    <th>Shortened Link</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($links as $link)
                               <tr>
                                 <td>{{ 100000 + $link->id }}</td>
                                 <td>{{ $link->count }}</td>
                                 <td>{{ $link->link }}</td>
                                 <td>{{ $link->hash }}</td>
                                 <td>{{ date('F d, Y', strtotime(date('d-m-Y', strtotime($link->date)))) }}</td>
                               </tr>
                               @endforeach
                            </tbody>
                            @else
                            <p>There doesn't seem to be any documented links tied to your account. If you believe this is an issue, please <a href="{{ url('/mail/account') }}">contact</a> our account support team!</p>
                            @endif
                        </table>
                    </div>

                </div>

                <br>
                <br>

                <div class="links">
                    <a href="https://github.com/xseano/">Author</a>
                    <a href="https://github.com/xseano/Linkify">Source Code</a>
                    <a href="{{ url('/about') }}">About</a>
                </div>
            </div>
        </div>
    </body>
</html>
