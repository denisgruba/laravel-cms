@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.activity-log')
        <activity-log></activity-log>
        <div class="row white z-depth-1" style="margin-bottom: 160px; padding-top:20px; padding-left: 15px; padding-right: 15px;">
            <div class="col m12">
                @include('partials.drawer', [
                    'drawerSubmit' => false,
                    'drawerPage' => 'activity-log'
                ])
            </div>
        </div>
    </main>
    <script type="text/x-template" id="activity-log">
        @include('partials.preloader')
        <div class="row" v-else>
            <div class="col m12">
                <table class="highlight bordered white z-depth-1">
                    <thead>
                        <tr>
                            <th data-field="User">User Name</th>
                            <th data-field="Description">Description</th>
                            <th data-field="IP">IP</th>
                            <th data-field="Time">Time</th>
                        </tr>
                    </thead>
                    <tr v-for="activity in activities">
                        <td>
                            <a href="{{url('/')}}">@{{activity.user.name}}</a>
                        </td>
                        <td>
                            @{{activity.text}}
                        </td>
                        <td>
                            @{{activity.ip_address}}
                        </td>
                        <td>
                            @{{activity.created_at}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </script>
@endsection
