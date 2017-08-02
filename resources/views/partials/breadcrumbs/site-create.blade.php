<div class="row">
    <nav>
        <div class="nav-wrapper">
            <div class="col s12">
                @unless($howmanysites == 1)
                    <a href="{{url('/')}}/home" class="breadcrumb">Main Dashboard</a>
                @endunless
                <a href="{{url('/')}}/site/create" class="breadcrumb">Create Site</a>
            </div>
        </div>
    </nav>
</div>
