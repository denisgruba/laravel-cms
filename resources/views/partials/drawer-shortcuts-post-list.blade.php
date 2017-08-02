<li><a href="{{$site->url}}" target="_blank"><i class="material-icons left">language</i> Jump to school website</a></li>
<li><a href="{{ url('/post') }}/list/{{$category->id}}/{{$site->id}}"><i class="material-icons left">reorder</i> Jump to {{$category->name}} list</a></li>
<li><a href="{{ url('/post') }}/type/{{$category->id}}/{{$site->id}}"><i class="material-icons left">playlist_add</i> Jump to {{$category->name}} types list</a></li>
{{-- <li><a href="{{url('/')}}/post/create/{{$category->id}}/{{$site->id}}"><i class="material-icons left">add</i> Create another {{$category->name}} item</a></li> --}}
