<div class="row">
    <nav style="background-color: #{{$site->hex_color}};">
        <div class="nav-wrapper">
            <div class="col s12">
                @unless($howmanysites == 1)
                    <a href="{{url('/')}}" class="breadcrumb">Main Dashboard</a>
                @endunless
                <a href="{{url('/')}}/site/{{$site->id}}" class="breadcrumb">{{ $site->name }} - Dashboard</a>
                <a href="{{url('/')}}/vacancy/role/{{$site->id}}" class="breadcrumb">Manage Roles</a>
                <a href="{{url('/')}}/vacancy/role_list/{{$role->type_id}}/{{$site->id}}" class="breadcrumb">{{$role->name}}</a>
            </div>
        </div>
    </nav>
</div>
