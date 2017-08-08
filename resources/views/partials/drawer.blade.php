@php $drawerTypes=['fixed', 'static']; @endphp

@foreach($drawerTypes as $drawerType)
    @if($drawerType=='static')
        <div class="row" id="drawer-location">
            <div id="drawer-static">
    @else
        <div class="row" id="drawer-fixed" style="z-index: 2">
            <div class="white z-depth-4" >
    @endif
            @if($drawerSubmit)
                <button class="btn-large teal white-text waves-effect waves-light right" type="submit" name="action"><i class="material-icons right">send</i>Submit
                </button>
            @endif
            @if($drawerPage == 'post')
                <a href="#publish_settings" class="waves-effect btn-flat"><i class="material-icons right">settings</i>Publish Settings</a>
                @if($category->id==1)
                    <a href="#thumbnail_settings" class="waves-effect btn-flat"><i class="material-icons right">insert_photo</i>Thumbnail Settings</a>
                @endif
                <a href="#" data-activates="shortcuts-dropdown-{{$drawerType}}" data-constrainWidth="false" class="waves-effect dropdown-button btn-flat"><i class="material-icons right">list</i>Shortcuts</a>
                <a href="{{url('/')}}/post/create/{{$category->id}}/{{$site->id}}" class="waves-effect btn-flat"><i class="material-icons right">add</i>Add another item</a>
                @if($view_name == 'post3-edit')
                    <a href="#confirm-delete" class="waves-effect btn-flat"><i class="material-icons right">delete</i>Delete this Item</a>
                @endif
                <ul id="shortcuts-dropdown-{{$drawerType}}" class="dropdown-content">
                    @include('partials.drawer-shortcuts-post')
                </ul>
            @elseif($drawerPage == 'staff')
                <a href="#" data-activates="shortcuts-dropdown-{{$drawerType}}" data-constrainWidth="false"  class="waves-effect  dropdown-button btn-flat"><i class="material-icons right">list</i>Shortcuts</a>
                <a href="{{url('/')}}/staff/create/{{$site->id}}" class="waves-effect btn-flat"><i class="material-icons right">add</i>Add new staff</a>
                <ul id="shortcuts-dropdown-{{$drawerType}}" class="dropdown-content">
                    @include('partials.drawer-shortcuts-staff')
                </ul>
            @elseif($drawerPage == 'post-list')
                <div class="row" style="margin-bottom: 0px;">
                    <div class="col s12">
                        <span class="center-align">{{ $posts->links() }}</span>
                    </div>
                </div>
                <a href="{{ url('/post/create/') }}/{{$category->id}}/{{$site->id}}" class="waves-effect green right btn-large"><i class="material-icons right">add</i>Add new item</a>
                <a href="#" data-activates="shortcuts-dropdown-{{$drawerType}}" data-constrainWidth="false"  class="waves-effect  dropdown-button btn-flat"><i class="material-icons right">list</i>Shortcuts</a>
                <ul id="shortcuts-dropdown-{{$drawerType}}" class="dropdown-content">
                    @include('partials.drawer-shortcuts-post-list')
                </ul>
            @elseif($drawerPage == 'post-type-list')
                <div class="row" style="margin-bottom: 0px;">
                    <div class="col s12">
                        <span class="center-align">{{ $posts->links() }}</span>
                    </div>
                </div>
                <a href="{{ url('/post/create/') }}/{{$category->id}}/{{$site->id}}/{{$type->id}}" class="waves-effect green right btn-large"><i class="material-icons right">add</i>Add new item</a>
                <a href="#" data-activates="shortcuts-dropdown-{{$drawerType}}" data-constrainWidth="false"  class="waves-effect dropdown-button btn-flat"><i class="material-icons right">list</i>Shortcuts</a>
                <ul id="shortcuts-dropdown-{{$drawerType}}" class="dropdown-content">
                    @include('partials.drawer-shortcuts-post-list')
                </ul>
            @elseif($drawerPage == 'post-type')
                <a href="{{ url('/post/create/') }}/{{$category->id}}/{{$site->id}}" class="waves-effect green right btn-large"><i class="material-icons right">add</i>Add new item</a>
                <a href="#" data-activates="shortcuts-dropdown-{{$drawerType}}" data-constrainWidth="false"  class="waves-effect dropdown-button btn-flat"><i class="material-icons right">list</i>Shortcuts</a>
                <ul id="shortcuts-dropdown-{{$drawerType}}" class="dropdown-content">
                    @include('partials.drawer-shortcuts-post-list')
                </ul>
            @elseif($drawerPage == 'vacancy-role')
                <a href="{{ url('/vacancy/create/') }}/{{$site->id}}" class="waves-effect green right btn-large"><i class="material-icons right">add</i>Add new item</a>
                <a href="#" data-activates="shortcuts-dropdown-{{$drawerType}}" data-constrainWidth="false"  class="waves-effect dropdown-button btn-flat"><i class="material-icons right">list</i>Shortcuts</a>
                <ul id="shortcuts-dropdown-{{$drawerType}}" class="dropdown-content">
                    @include('partials.drawer-shortcuts-vacancy-list')
                </ul>
            @elseif($drawerPage == 'vacancy')
                <a href="#publish_settings" class="waves-effect btn-flat"><i class="material-icons right">settings</i>Publish Settings</a>
                <a href="#" data-activates="shortcuts-dropdown-{{$drawerType}}" data-constrainWidth="false" class="waves-effect dropdown-button btn-flat"><i class="material-icons right">list</i>Shortcuts</a>
                <a href="{{url('/')}}/vacancy/create/{{$site->id}}" class="waves-effect btn-flat"><i class="material-icons right">add</i>Add another item</a>
                @if($view_name == 'vacancy-edit')
                    <a href="#confirm-delete" class="waves-effect btn-flat"><i class="material-icons right">delete</i>Delete this Item</a>
                @endif
                <ul id="shortcuts-dropdown-{{$drawerType}}" class="dropdown-content">
                    @include('partials.drawer-shortcuts-vacancy')
                </ul>
            @elseif($drawerPage == 'vacancy-list')
                <div class="row" style="margin-bottom: 0px;">
                    <div class="col s12">
                        <span class="center-align">{{ $posts->links() }}</span>
                    </div>
                </div>
                <a href="{{ url('/vacancy/create/') }}/{{$site->id}}" class="waves-effect green right btn-large"><i class="material-icons right">add</i>Add new item</a>
                <a href="#" data-activates="shortcuts-dropdown-{{$drawerType}}" data-constrainWidth="false"  class="waves-effect  dropdown-button btn-flat"><i class="material-icons right">list</i>Shortcuts</a>
                <ul id="shortcuts-dropdown-{{$drawerType}}" class="dropdown-content">
                    @include('partials.drawer-shortcuts-vacancy-list')
                </ul>
            @elseif($drawerPage == 'user-edit')
                <a href="{{ url('/user/password/reset') }}" class="waves-effect btn-flat"><i class="material-icons right">lock</i>Change Password</a>
            @elseif($drawerPage == 'converter')
                <a href="{{ url('/convertclear') }}" class="waves-effect btn-flat"><i class="material-icons right">cancel</i>Clear Files</a>
            @elseif($drawerPage == 'activity-log')
                <a href="{{ url('/user/log/clear') }}" class="waves-effect btn-flat"><i class="material-icons right">lock</i>Clear log</a>
            @elseif($drawerPage == 'empty')

            @endif
            <div class="clearfix"></div>
        </div>
    </div>
@endforeach

@section('drawer-check')

<script>
    var drawerEnabled = true;
</script>

@endsection
