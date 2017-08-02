@extends('layouts.app2')

@section('content')

    <main>
        @include('partials.breadcrumbs.dashboard-sites')
        <div class="row">
            <site></site>
        </div>
    </main>

@endsection

@section('vue-template')

    <script type="text/x-template" id="dashboard-site">
        @include('partials.preloader')
        <div v-else>
            <div class="col s12 m6 l3" v-for="site in sites">
                <a :href="'{{url('/')}}/site/'+site.id">
                    <div class="card small" style="overflow: hidden;">
                        <div class="card-image waves-effect waves-block waves-light ">
                            <img class="activator card-school-logo" :src="site.logo">
                        </div>
                        <div class="card-action" >
                            @can('webteam')
                                <span class="badge" style="top: -0px; position: relative;" data-badge-caption="">School ID: @{{site.id}}</span>
                            @endcan
                            <div class="card-content row no-padding activator" style="width: 100%;">
                                <span class="card-title truncate grey-text no-padding text-darken-4 activator">@{{site.name }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </script>

@endsection
