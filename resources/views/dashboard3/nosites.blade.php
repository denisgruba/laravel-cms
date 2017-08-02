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
                <h4>Almost there!</h4>
                <p>Webteam needs to approve you, before you can continue. We've received the notification. There's nothing more you need to do. You will get an email when you get an access.</p>
                <a href="mailto:webteam@hasla.org.uk" class="waves-effect waves-light btn"><i class="material-icons right">send</i>Contact</a>
                <a href="{{url('/')}}/logout" class="waves-effect waves-light btn red right"><i class="material-icons right">input</i>Logout</a>
            </div>
        </div>
    </div>
@endsection
