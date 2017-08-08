@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.vacancy-list')
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
                        <th data-field="Type">Role</th>
                        <th data-field="Site">Site</th>
                        <th data-field="From">From</th>
                        <th data-field="To">To</th>
                        <th data-field="Views">Views</th>
                        <th data-field="Options" class="right-align">Edit / Remove</th>
                    </tr>
                    </thead>
                    @foreach($posts as $post)
                        <tr>
                            @can('webteam')
                                <td>{{$post->id}}</td>
                            @endcan
                            <td>
                                <a href="{{ url('/vacancy/edit/') }}/{{$post->id}}/{{$site->id}}">{{$post->title}}</a>
                            </td>
                            <td>
                                {{$post->name}}
                            </td>
                            <td>
                                <a href="{{url('/')}}/vacancy/type_list/{{$post->type_id}}/{{$site->id}}">{{$post->label}}</a>
                            </td>
                            <td>
                                {{-- <a href="{{url('/')}}/post/type_list/{{$post->site_id}}/{{$site->id}}"> --}}
                                    {{$post->site_name}}
                                {{-- </a> --}}
                            </td>
                            <td>
                                {{$post->start}}
                            </td>
                            <td>
                                {{$post->end}}
                            </td>

                            <td>
                                {{$post->viewed}}
                            </td>
                            <td>
                                <a href="{{ url('/vacancy/delete/') }}/{{$site->id}}/{{$post->id}}" class="waves-effect btn red right"><i class="material-icons">delete</i></a>
                                <a href="{{ url('/vacancy/edit/') }}/{{$post->id}}/{{$site->id}}" class="waves-effect btn green right"><i class="material-icons">mode_edit</i></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="row white z-depth-1" style="margin-bottom: 160px; padding-top:20px;">
                    <div class="col m12">
                        @include('partials.drawer', [
                            'drawerSubmit' => false,
                            'drawerPage' => 'vacancy-list'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
