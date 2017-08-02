<div class="fixed-action-btn hide-on-med-and-down" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large red waves-effect">
        <i class="large material-icons">add</i>
    </a>
    <ul>
        <li><a href="{{$site->url}}" target="_blank" class="btn-floating blue tooltipped" data-position="left" data-delay="10" data-tooltip="Jump to school website."><i class="material-icons">language</i></a></li>
        <li><a href="{{ url('/post') }}/list/{{$category->id}}/{{$site->id}}" class="btn-floating yellow darken-1 tooltipped" data-position="left" data-delay="10" data-tooltip="Jump to {{$category->name}} list."><i class="material-icons">reorder</i></a></li>
        <li><a href="{{ url('/post') }}/type/{{$category->id}}/{{$site->id}}" class="btn-floating green tooltipped" data-position="left" data-delay="10" data-tooltip="Jump to {{$category->name}} types list."><i class="material-icons">playlist_add</i></a></li>
        <li><a href="{{url('/')}}/post/create/{{$category->id}}/{{$site->id}}" class="btn-floating red tooltipped" data-position="left" data-delay="10" data-tooltip="Create another {{$category->name}} item."><i class="material-icons">add</i></a></li>
    </ul>
</div>
<div class="fixed-action-btn hide-on-large-only" style="bottom: 150px; right: 24px;">
    <a class="btn-floating btn-large red waves-effect">
        <i class="large material-icons">add</i>
    </a>
    <ul>
        <li><a href="{{$site->url}}" target="_blank" class="btn-floating blue tooltipped" data-position="left" data-delay="10" data-tooltip="Jump to school website."><i class="material-icons">language</i></a></li>
        <li><a href="{{ url('/post') }}/list/{{$category->id}}/{{$site->id}}" class="btn-floating yellow darken-1 tooltipped" data-position="left" data-delay="10" data-tooltip="Jump to {{$category->name}} list."><i class="material-icons">reorder</i></a></li>
        <li><a href="{{ url('/post') }}/type/{{$category->id}}/{{$site->id}}" class="btn-floating green tooltipped" data-position="left" data-delay="10" data-tooltip="Jump to {{$category->name}} types list."><i class="material-icons">playlist_add</i></a></li>
        <li><a href="{{url('/')}}/post/create/{{$category->id}}/{{$site->id}}" class="btn-floating red tooltipped" data-position="left" data-delay="10" data-tooltip="Create another {{$category->name}} item."><i class="material-icons">add</i></a></li>
    </ul>
</div>
