<div class="row" id="drawer-location">
    <div id="drawer-static">
        <button style="" class="btn-large teal white-text waves-effect waves-light right" type="submit" name="action"><i class="material-icons right">send</i>Submit
        </button>
        <a href="#publish_settings" style="" class="waves-effect  btn-large transparent z-depth-0 black-text"><i class="material-icons right">settings</i>Publish Settings</a>
        <a href="#" data-activates="shortcuts-dropdown2" data-constrainWidth="false"  class="waves-effect  dropdown-button btn-large transparent z-depth-0 black-text"><i class="material-icons right">list</i>Shortcuts</a>
        <a href="{{url('/')}}/post/create/{{$category->id}}/{{$site->id}}" class="waves-effect  dropdown-button btn-large transparent z-depth-0 black-text"><i class="material-icons right">add</i>Add new item</a>
        <ul id="shortcuts-dropdown2" class="dropdown-content">
            @include('partials.drawer-shortcuts')
        </ul>
    </div>
</div>
