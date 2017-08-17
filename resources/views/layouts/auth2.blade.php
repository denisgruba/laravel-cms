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

<body id="auth-page" >

    @yield('content')

    @include('partials.scripts')

    @yield('scripts')

    @include('partials.flash')
</body>
</html>
