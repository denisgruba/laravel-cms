<div class="nav-wrapper">
    <div class="col s12">
        @unless($howmanysites == 1)
            <a href="{{url('/')}}/home" class="breadcrumb">Main Dashboard</a>
        @endunless
        <a href="{{url('/')}}/categories/{{$site->id}}" class="breadcrumb">{{ $site->name }} - Dashboard</a>
    </div>
</div>
