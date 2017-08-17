@extends('layouts.app2')

@section('content')

    <categories :site-id="{{$site->id}}"></categories>

@endsection

@section('vue-template')


    <script type="text/x-template" id="dashboard-categories">
        <main>
            <div class="row">
                <nav class="nav-extended" style="background-color: #{{$site->hex_color}};">
                    @include('partials.breadcrumbs.dashboard-site')
                    <div class="nav-content">
                        <ul id="tutorial-categories" class="tabs tabs-transparent" style="display: flex;">
                            <li
                                v-for="category in categories"
                                class="tab"
                            >
                                <a @click="changeGroup(category.id)" :href="'#tab'+category.id" :class="'tab-link-tab'+category.id">
                                    @{{category.name}}
                                </a>
                            </li>
                            <li class="tab"><a href="#tab0" class="tab-link-tab0" @click="changeGroup(0)">Stats</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            @include('partials.preloader')
            <div v-else>
                <div class="row">
                    <div v-for="category in categories">
                        <div v-if="category.id == 6">
                            <div :id="'tab'+category.id" class="col s12 m12 l12" v-if="selectedCategory == category.id">
                                <div class="row">
                                    <div class="col s12 m6">
                                        <div id="tutorial-staff-actions" class="card-panel" style="overflow: hidden;">
                                            <h5 style="margin-top: 0;">Actions</h5>
                                            <a :href="'/staff/sort/'+site.id" class="btn fullwidth teal darken-1 hoverable waves-effect"><i class="material-icons right">swap_vert</i>Sort & Edit staff</a>
                                            <a :href="'/staff/create/'+site.id" class="btn-large fullwidth teal accent-4 hoverable waves-effect"><i class="material-icons right">person_add</i>Add staff member</a>
                                            <a :href="'/staff/group/'+site.id" class="btn fullwidth teal darken-1 hoverable waves-effect"><i class="material-icons right">group_add</i>Manage groups</a>
                                        </div>
                                    </div>
                                    <div class="col s12 m6">
                                        <ul id="tutorial-staff-groups" class="collection with-header z-depth-1">
                                            <li class="collection-header"><h4>Staff in groups</h4></li>
                                            <li class="collection-item"
                                                v-for="group in groups"
                                            >
                                                <span class="badge" data-badge-caption="staff members">
                                                    @{{group.staff.length}}
                                                </span>
                                                @{{group.name}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else-if="category.id == 9">
                            <div :id="'tab'+category.id" class="col s12 m12 l12" v-if="selectedCategory == category.id">
                                <div class="row">
                                    <div class="col s12 m6">
                                        <div id="tutorial-staff-actions" class="card-panel" style="overflow: hidden;">
                                            <h5 style="margin-top: 0;">Actions</h5>
                                            <a :href="'/vacancy/list/'+site.id" class="btn fullwidth teal darken-1 hoverable waves-effect"><i class="material-icons right">reorder</i>List Vacancies</a>
                                            <a :href="'/vacancy/create/'+site.id" class="btn-large fullwidth teal accent-4 hoverable waves-effect"><i class="material-icons right">add</i>Add Vacancy </a>
                                            <a :href="'/vacancy/role/'+site.id" class="btn fullwidth teal darken-1 hoverable waves-effect"><i class="material-icons right">playlist_add</i>Manage Vacancy Roles</a>
                                        </div>
                                    </div>
                                    <div class="col s12 m6">
                                        <ul id="tutorial-staff-groups" class="collection with-header z-depth-1">
                                            <li class="collection-header"><h4>Vacancies Live</h4></li>
                                            <li class="collection-item"
                                                v-for="categoryLatestUpdate in categoryLatestUpdates"
                                            >
                                                <a :href="'/vacancy/edit/'+categoryLatestUpdate.id+'/'+site.id">
                                                    <span class="badge">
                                                        @{{categoryLatestUpdate.updated_at | fromNow}}
                                                    </span>
                                                    @{{categoryLatestUpdate.title}}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div :id="'tab'+category.id" class="col s12 m12 l12" v-if="selectedCategory == category.id">
                                <div class="row">
                                    <div class="col s12 m6">
                                        <div id="tutorial-actions" class="card-panel" style="overflow: hidden;">
                                            <h5 style="margin-top: 0;">Actions</h5>
                                            <a :href="'/post/list/'+category.id+'/'+site.id" class="btn fullwidth teal darken-1 hoverable  waves-effect"><i class="material-icons right">reorder</i>List @{{category.name}}</a>
                                            <a :href="'/post/create/'+category.id+'/'+site.id" class="btn-large fullwidth teal hoverable accent-4 waves-effect"><i class="material-icons right">add</i>Create @{{category.name}}</a>
                                            <a :href="'/post/type/'+category.id+'/'+site.id" class="btn fullwidth teal darken-1 hoverable waves-effect"><i class="material-icons right">playlist_add</i>List @{{category.name}} by types</a>
                                        </div>
                                        <div id="tutorial-calendar" class="card-panel" v-if="category.id==2 &&categoryTypes.length">
                                            <div id='calendar'></div>
                                        </div>
                                        <div id="tutorial-quickpost" class="card-panel tutorial highlight" v-if="category.id!=2 && categoryTypes.length">
                                            <form method="POST" :action="'{{url('/')}}/post/store/'+category.id+'/'+site.id" accept-charset="UTF-8"  enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <h3>Quick Post</h3>
                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <input v-model="title" id="title" name="title" type="text" class="validate" required value="{{ old('title') }}">
                                                        <label for="title">Title (Required)</label>
                                                    </div>
                                                </div>

                                                <div class="row" v-if="category.id!=5">
                                                    <div class="col s12 input-field">
                                                        <label for="content"><h6>Content</h6></label>
                                                        <textarea name="content" :id="'material-editor'+category.id" class="materialize-textarea form-control" placeholder="Add content">{{ old('content') }}</textarea>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <select name="type" id="type" required>
                                                            <option value="" disabled :selected="categoryTypes.length!==1">Pick a @{{category.name}} type (Required)</option>
                                                            <option
                                                                v-for="type in categoryTypes"
                                                                :value="type.id"
                                                                :selected="categoryTypes.length==1"
                                                            >@{{type.name}}</option>
                                                        </select>
                                                        <label for="type">Where to Publish: (Required)</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="file-field input-field col s12">
                                                        <h6 class="grey-text">Attachments</h6>
                                                        <div class="btn">
                                                            <span>Upload</span>
                                                            <input
                                                                v-if="category.id==5"
                                                                type="file" name="files[]" multiple required accept="pdf"
                                                            >
                                                            <input
                                                                v-else
                                                                type="file" name="files[]" multiple
                                                            >
                                                        </div>
                                                        <div class="file-path-wrapper">
                                                            <input
                                                                v-if="category.id==5"
                                                                class="file-path validate" type="text" placeholder="Upload one max 10MB file. PDF files required." accept="pdf"
                    										>
                                                            <input
                                                                v-else
                                                                class="file-path validate" type="text"
                                                                placeholder="Upload one or more files. Maximum 50 files & max 10MB each file."
                    										>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col s12">
                                                        <button class="btn waves-effect waves-light right" type="submit" name="action">Submit
                                                           <i class="material-icons right">send</i>
                                                        </button>
                                                    </div>
                                                </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                    <div class="col s12 m6">
                                        <div>
                                            <ul id="tutorial-recent" class="collection with-header z-depth-1" v-if="categoryLatestUpdates.length">
                                                <li class="collection-header"><h4>Recent Updates</h4></li>
                                                <li class="collection-item"
                                                    v-for="categoryLatestUpdate in categoryLatestUpdates"
                                                >
                                                    <a :href="'/post/edit/'+categoryLatestUpdate.post_id+'/'+site.id">
                                                        <span class="badge">
                                                            @{{categoryLatestUpdate.updated_at | fromNow}}
                                                        </span>
                                                        @{{categoryLatestUpdate.title}}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class="col s12 m6">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab0" class="col s12 m12 l12" v-if="selectedCategory == 0">
                        <div class="row">
                            <div class="col s12 m6 l6">
                                <div class="card-panel">
                                    <h5>Stats</h5>
                                    <table class="striped">
                                        <tbody>
                                            <tr>
                                                <td>Users</td>
                                                <td>{{count($siteusers)}}</td>
                                            </tr>
                                            <tr>
                                                <td>Categories</td>
                                                <td>{{count($categories)}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col s12 m6 l6">
                                <ul class="collection with-header z-depth-1">
                                    <li class="collection-header"><h4>Users in this site</h4></li>
                                    @foreach($siteusers as $user)
                                        <li class="collection-item">
                                            @can('webteam')
                                                <span class="badge" data-badge-caption="updates">{{$user->posts_count}}</span>
                                            @endcan
                                            {{$user->name}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m12 l12">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </script>
    <script type="text/x-template" id="category-latest-updates">
        <li v-for="categoryLatestUpdate in CategoryLatestUpdates" class="collection-item"><span class="badge" data-badge-caption="id">@{{categoryLatestUpdate.post_id}}</span>@{{categoryLatestUpdate.title}}</li>
    </script>

@endsection

@section('scripts')

    <script>
    $(document).ready(function(){
        // $('ul.tabs').tabs({'swipeable': false});
    });
    </script>

@endsection
