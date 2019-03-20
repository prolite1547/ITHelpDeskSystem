<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - Helpdesk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('images/tab-logo.png')}}" type="image/png">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ mix('/css/app.css') }}"/>
</head>
<body>
    @include('includes.modal')

    <div class="container">
        @yield('inside_container')
    </div>

    <script>
        window.authUserID = {{ (Auth::id()) }}
    </script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/dcsDatatable.js')}}"></script>
</body>
</html>

