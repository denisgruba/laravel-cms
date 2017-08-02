<div class="row">
    <nav style="background-color: #{{$site->hex_color}}; line-height: 56px;">
        <div class="nav-wrapper">
            <div class="col s12">
                @unless($howmanysites == 1)
                    <a href="{{url('/')}}" class="breadcrumb">Main Dashboard</a>
                @endunless
                <a href="{{url('/')}}/site/{{$site->id}}" class="breadcrumb">{{ $site->name }} - Dashboard</a>
                <a href="{{url('/')}}/post/edit/{{$post->post_id}}/{{$site->id}}"
                   class="breadcrumb">Edit "{{$post->title}}"</a>
            </div>
        </div>
    </nav>
</div>
