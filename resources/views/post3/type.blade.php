@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.post-type')
        <div class="row">
            <div class="col m12">
                @if(count($types))
                    <div class="row">
                        <table class="highlight white z-depth-1 col m12">
                            <thead>
                            <tr>
                                @can('webteam')
                                    <th data-field="ID">Type ID</th>
                                @endcan
                                <th data-field="Title">Type name</th>
                                <th data-field="Options"></th>
                            </tr>
                            </thead>
                            @foreach($types as $type)
                                <tr>
                                    @can('webteam')
                                        <td>{{$type->type_id}}</td>
                                    @endcan
                                    <td><a href="{{ url('/post/type_list/').'/'.$category->id.'/'.$type->type_id}}/{{$site->id}}">{{$type->name}}</a></td>
                                    <td><a href="{{ url('/post/type_list/').'/'.$category->id.'/'.$type->type_id}}/{{$site->id}}" class="waves-effect waves-light btn right"><i class="material-icons left">list</i>List items</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
                @can('webteam')
                    <div class="row">
                        {{ Form::open(array('url' => '/post/storetype/'.$category->id, 'class' => 'col m12 card-panel white')) }}
                        <div class="input-field col s8">
                            <input id="title" name="title" type="text" class="validate" required value="{{ old('title') }}">
                            <label for="title">Add new type</label>
                        </div>
                        <div class="input-field col s4">
                            <button class="btn-large waves-effect waves-light right" type="submit" name="action">
                                <i class="material-icons left">add</i> New Type
                            </button>
                        </div>
                        {{ Form::close() }}
                    </div>
                @endcan
                <div class="row white z-depth-1" style="margin-bottom: 160px; padding-top:20px;">
                    <div class="col m12">
                        @include('partials.drawer', [
                            'drawerSubmit' => false,
                            'drawerPage' => 'post-type'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
