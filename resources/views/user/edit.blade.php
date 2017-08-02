@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.user-edit')
        @if (count($errors) > 0)
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <ul class="collection with-header">
                    <li class="collection-header"><h4>We've encountered some errors:</h4></li>
                    @foreach ($errors->all() as $error)
                        <li class="collection-item red-text">{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row"  style="padding-left: 15px; padding-right: 15px; margin-bottom: 80px;">
            {{ Form::open(array('url' => '/user/update/', 'class' => 'col m12 card-panel white')) }}
                <h3>Edit Your User Details</h3>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name" name="name" type="text" class="validate" required value="{{$user->name}}">
                        <label for="name">Name</label>
                    </div>
                    <div class="col s12">
                        <div class="input-field">
                            <input id="email" name="email" type="email" class="validate"  value="{{$user->email}}">
                            <label for="email">E-Mail</label>
                        </div>
                    </div>
                </div>
                @include('partials.drawer', [
                    'drawerSubmit' => true,
                    'drawerPage' => 'user-edit'
                ])
            {{ Form::close() }}
        </div>
    </main>
@endsection

@section('scripts')



@endsection
