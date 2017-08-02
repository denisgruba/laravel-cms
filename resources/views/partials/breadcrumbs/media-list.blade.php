<div class="row">
    <nav style="background-color: #{{$site->hex_color}}; line-height: 56px;">
        <div class="nav-wrapper">
            <div class="col s12">
                @unless($howmanysites == 1)
                    <a href="{{url('/')}}" class="breadcrumb">Main Dashboard</a>
                @endunless
                <a href="{{url('/')}}/site/{{$site->id}}" class="breadcrumb">{{ $site->name }} - Dashboard</a>
                <a href="{{url('/')}}/media/list/{{$site->id}}" class="breadcrumb">List Media</a>
            </div>
        </div>
    </nav>
</div>
