<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body id="app-layout"
    @if($view_name == 'auth-login')
        class="yellow accent-4"
    @else
        class="blue-grey lighten-5"
    @endif
>
<div id="app">
    @include('partials.nav')

    @yield('content')
    @include('help.index')

    @include('partials.tutorial')

    @include('partials.jswarning')
</div>


@include('partials.nav-template')

@yield('vue-template')

@include('partials.scripts')
@yield('scripts')
@include('partials.flash')
</body>
</html>
