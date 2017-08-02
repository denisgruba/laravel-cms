@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.post-type-list')
        <div class="row">
            <div class="col m12">
                <table class="highlight white z-depth-1">
                    <thead>
                    <tr>
                        @can('webteam')
                            <th data-field="ID">Post ID</th>
                        @endcan
                        <th data-field="Title">Title</th>
                        <th data-field="Author">Author</th>
                        <th data-field="Type">Type</th>
                        <th data-field="From">From</th>
                        <th data-field="To">To</th>
                        @if($category->id=='2')<th data-field="Publish">Publish From</th>@endif
                        <th data-field="Views">Views</th>
                        <th data-field="Options" class="right-align">Pin / Edit / Remove</th>
                    </tr>
                    </thead>
                    @foreach($posts as $post)
                        <tr>
                            @can('webteam')
                                <td>{{$post->id}}</td>
                            @endcan
                            <td>
                                <a href="{{ url('/post/edit/') }}/{{$post->id}}/{{$site->id}}">{{$post->title}}</a>
                            </td>
                            <td>
                                {{$post->name}}
                            </td>
                            <td>
                                {{$post->label}}
                            </td>
                            <td>
                                {{$post->start}}
                            </td>
                            <td>
                                {{$post->end}}
                            </td>
                            @if($category->id=='2')
                                <td>
                                    {{$post->publish_at}}
                                </td>
                            @endif
                            <td>
                                {{$post->viewed}}
                            </td>
                            <td>
                                <a href="{{ url('/post/delete/') }}/{{$post->id}}" class="waves-effect btn red right"><i class="material-icons">delete</i></a>
                                <a href="{{ url('/post/edit/') }}/{{$post->id}}/{{$site->id}}" class="waves-effect btn green right"><i class="material-icons">mode_edit</i></a>
                                @if($post->pinned == '1')
                                    <a href="{{ url('/post/unpin/') }}/{{$post->id}}" class="waves-effect btn blue right"><i class="mdi mdi-pin"></i></a>
                                @else
                                    <a href="{{ url('/post/pin/') }}/{{$post->id}}" class="waves-effect btn blue lighten-3 right"><i class="mdi mdi-pin-off"></i></a>
                                @endif
                                @if( Gate::check('webteam') || Gate::check('trust_admin') )
                                    @if($post->pinned_trust == '1')
                                        <a href="{{ url('/post/unpin-trust/') }}/{{$post->id}}" class="waves-effect btn orange right"><i class="mdi mdi-checkbox-multiple-marked"></i></a>
                                    @else
                                        <a href="{{ url('/post/pin-trust/') }}/{{$post->id}}" class="waves-effect btn orange lighten-3 lighten-3 right"><i class="mdi mdi-checkbox-multiple-blank-outline"></i></a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="row white z-depth-1" style="margin-bottom: 160px; padding-top:20px;">
                    <div class="col m12">
                        @include('partials.drawer', [
                            'drawerSubmit' => false,
                            'drawerPage' => 'post-type-list'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
