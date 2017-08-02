<!DOCTYPE html class="auth-pages">
<html lang="en">
<head>
    @include('partials.head')
</head>
<body id="auth-page"
  @if($view_name == 'auth-login')
  class="yellow accent-4"
  @else
  class="blue-grey lighten-5"
    @endif
>

{{--<head>--}}
    {{--<meta charset="utf-8">--}}
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}

    {{--<title>The Bee Hub</title>--}}

    {{--<!-- Fonts -->--}}
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>--}}

    {{--<!-- Styles -->--}}
    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">--}}
    {{--<link href="css/app.css" rel="stylesheet">--}}
    {{--<link href="css/style.css" rel="stylesheet">--}}
{{--</head>--}}
<body id="auth-page" >

    @yield('content')

    @include('partials.scripts')

    @yield('scripts')
    
    @include('partials.flash')
</body>
</html>
