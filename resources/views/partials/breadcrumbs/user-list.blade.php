<div class="row">
    <nav style="">
        <div class="nav-wrapper">
            <div class="col s12">
                @unless($howmanysites == 1)
                    <a href="{{url('/')}}" class="breadcrumb">Main Dashboard</a>
                @endunless
                <a href="{{url('/')}}/user/list" class="breadcrumb">User List</a>
            </div>
        </div>
    </nav>
</div>
