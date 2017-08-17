@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.vacancy-role')
        <div class="row">
            <div class="col m12">
                @if(count($roles))
                    <div class="row">
                        <table class="highlight white z-depth-1 col m12">
                            <thead>
                            <tr>
                                @can('webteam')
                                    <th data-field="ID">Type ID</th>
                                @endcan
                                <th data-field="Title">Role name</th>
                                <th data-field="Options"></th>
                            </tr>
                            </thead>
                            @foreach($roles as $role)
                                <tr>
                                    @can('webteam')
                                        <td>{{$role->type_id}}</td>
                                    @endcan
                                    <td><a href="{{ url('/vacancy/role_list/')}}/{{$role->type_id}}/{{$site->id}}">{{$role->name}}</a></td>
                                    <td><a href="{{ url('/vacancy/role_list/')}}/{{$role->type_id}}/{{$site->id}}" class="waves-effect waves-light btn right"><i class="material-icons left">list</i>List items</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
                @can('webteam')
                    <div class="row">
                        {{ Form::open(array('url' => '/vacancy/storerole/', 'class' => 'col m12 card-panel white')) }}
                        <div class="input-field col s8">
                            <input id="title" name="title" type="text" class="validate" required value="{{ old('title') }}">
                            <label for="title">Add new type</label>
                        </div>
                        <div class="input-field col s4">
                            <button class="btn-large waves-effect waves-light right" type="submit" name="action">
                                <i class="material-icons left">add</i> New Role
                            </button>
                        </div>
                        {{ Form::close() }}
                    </div>
                @endcan
                <div class="row white z-depth-1" style="margin-bottom: 160px; padding-top:20px;">
                    <div class="col m12">
                        @include('partials.drawer', [
                            'drawerSubmit' => false,
                            'drawerPage' => 'vacancy-role'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
