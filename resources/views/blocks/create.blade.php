@extends('layouts.app2')

@section('content')
<style>
ul[dnd-list], ul[dnd-list] > li {
    position: relative;
}
</style>
<main>
    {{-- @include('partials.breadcrumbs.post-create') --}}
    @if (count($errors) > 0)
        <div class="row" style="padding-left: 15px; padding-right: 15px;">
            <ul class="collection with-header">
                <li class="collection-header"><h4>We've encountered some errors:</h4></li>
                @foreach ($errors->all() as $error)
                    <li class="collection-item red-text">{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row" style="padding-left: 15px; padding-right: 15px; margin-bottom: 150px;">
        <blocks-layout {{--:site-id.sync="{{$site->id}}"--}}></blocks-layout>
    </row>
</main>
<script type="text/x-template" id="blocks-layout">
    <div class="col s12">
        <div class="card-panel">
            <h4>Page Name</h4>
            <div class="row">
                <div v-for="row in layout">
                    <ul class="collection">
                        <blocks-row></blocks-row>
                        <!-- <list v-for="item in list" :item="item" :list="list" :index="$index" :selected.sync="selected" :disable.sync="disable"></list> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</script>

<script type="text/x-template" id="block-row">
    tet
</script>

<script type="text/x-template" id="list">
    <li v-if="item.type === 'row'" class="collection-item avatar teal lighten-5">
        <i class="material-icons circle drag-icon">open_with</i>
        <span class="title">Row</span>
        <p>12 layout</p>
        <div class="secondary-content">
            <a href="#!" class=""><i class="material-icons green-text">mode_edit</i></a>
            <a href="#!" class=""><i class="material-icons red-text">delete</i></a>
        </div>
    </li>
    <li v-if="item.type === 'item'" class="collection-item no-padding">
        <div class="row">
            <div v-if="item.layout === '1'" class="col s12 no-padding">
                <ul class="collection no-margin">
                    <li class="collection-item avatar">
                        <i class="material-icons circle drag-icon">open_with</i>
                        <span class="title">Text Block</span>
                        <p>Lorem Ipsum</p>
                        <div class="secondary-content">
                            <a href="#!" class=""><i class="material-icons green-text">mode_edit</i></a>
                            <a href="#!" class=""><i class="material-icons red-text">delete</i></a>
                        </div>
                    </li>
                </ul>
            </div>
            <div v-if="item.layout === '2'" class="col s6 no-padding">
                <ul class="collection no-margin">
                    <li class="collection-item avatar">
                        <i class="material-icons circle drag-icon">open_with</i>
                        <span class="title">Text Block</span>
                        <p>Lorem Ipsum</p>
                        <div class="secondary-content">
                            <a href="#!" class=""><i class="material-icons green-text">mode_edit</i></a>
                            <a href="#!" class=""><i class="material-icons red-text">delete</i></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </li>
    <list v-for="col in item.columns" :item="col" :list="item.columns" :index="$index" :selected.sync="selected" :disable.sync="disable"></list>
</script>

@endsection

@section('scripts')



@endsection
