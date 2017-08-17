@extends('layouts.auth2')

@section('content')
    <div class="container loginbox">
        <div class="row">
            <div class="col s12 m12">
                <div class="row">
                    <div class="col s12 m6">
                        <img src="{{url('/')}}/img/logo.png" class="responsive-img right">
                    </div>
                    <div class="col s12 m6">
                        <h1 class="left">The Bee Hub</h1>
                    </div>
                </div>


            </div>
        </div>
        <div class="row">
            <div class="col m8 offset-m2">
                @if(count($errors)>0)
                    <div class="row">
                        <div class="col s10 offset-s1">
                            <ul class="red-text collection">
                                @foreach ($errors->all() as $error)
                                    <li class="collection-item">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <form class="card white" method="POST" action="{{ route('login') }}" class="">
                    {{ csrf_field() }}
                    <div class="row ">
                        <p><br></p>
                        <div class="input-field col s10 offset-s1">
                            <i class="material-icons prefix">email</i>
                            <input id="icon_prefix" type="email" name="email" value="{{ old('email') }}" class="validate  {{ $errors->has('email') ? 'invalid' : '' }}" autofocus required placeholder="E-Mail Address" data-error="@if ($errors->has('email')) {{ $errors->first('email') }} @endif">
                            <label for="icon_prefix">E-Mail Address</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s10 offset-s1">

                            <i class="material-icons prefix">lock</i>
                            <input id="icon_prefix" type="password" name="password" value="{{ old('password') }}" class="validate {{ $errors->has('password') ? 'invalid' : '' }}" required placeholder="Password" data-error="@if ($errors->has('password')) {{ $errors->first('password') }} @endif">
                            <label for="icon_prefix">Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col s10 offset-s1">
                            <i class="material-icons prefix"></i>
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                            <label for="remember">Remember Me</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s10 offset-s1">
                            <button type="submit" class="btn-large fullwidth">
                                <i class="material-icons left">input</i>Login
                            </button>

                            <a class="right-align" href="{{ route('password.request') }}">Forgot Your Password?</a>
                            <p></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
