@extends('layouts.auth2')

@section('content')
    <div class="container loginbox">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                @if (session('status'))
                    <div class="row">
                        <div class="col s10 offset-s1 red-text ">
                            {{ session('status') }}
                        </div>
                    </div>
                @endif
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
                {{ Form::open(array('url' => '/password/reset', 'class' => 'card white')) }}
                <div class="row" style="margin-left: 2rem; margin-right: 2rem;">
                    <p><br></p>
                    <h4>Reset Password</h4>
                </div>
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="row">
                    <div class="input-field col s10 offset-s1">
                        <i class="material-icons prefix">email</i>
                        <input id="icon_prefix" type="email" name="email" value="{{ old('email') }}" class="validate  {{ $errors->has('email') ? 'invalid' : '' }}"
                               placeholder="E-Mail Address" data-error="@if ($errors->has('email')) {{ $errors->first('email') }} @endif">
                        <label for="icon_prefix">E-Mail Address</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s10 offset-s1">
                        <i class="material-icons prefix">lock</i>
                        <input id="icon_prefix" type="password" name="password" value="{{ old('password') }}"
                               class="validate {{ $errors->has('password') ? 'invalid' : '' }}" placeholder="Password" data-error="@if ($errors->has('password')) {{ $errors->first('password') }} @endif">
                        <label for="icon_prefix">Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s10 offset-s1">
                        <i class="material-icons prefix">lock</i>
                        <input id="icon_prefix" type="password" name="password_confirmation"
                               value="{{ old('password_confirmation') }}" class="validate {{ $errors->has('password_confirmation') ? 'invalid' : '' }}"
                               placeholder="Confirm Password" data-error="@if ($errors->has('password_confirmation')) {{ $errors->first('password') }} @endif">
                        <label for="icon_prefix">Confirm Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s10 offset-s1">
                        <button type="submit" class="btn-large fullwidth">
                            <i class="material-icons left">loop</i>Reset Password
                        </button>
                        <p></p>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
