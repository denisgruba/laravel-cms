@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.site-create')
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
        <div class="row" style="padding-left: 15px; padding-right: 15px;">
            <div class="col s12 card-panel">
                {{ Form::open(array('url' => '/site/store/', 'files' => true)) }}
                    <div class="row">
                        <h3>Create new site</h3>
                        <div class="input-field col s12">
                            <input id="name" name="name" type="text" class="validate" value="{{ old('name') }}">
                            <label for="name">Name</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="slug" name="slug" type="text" class="validate" value="{{ old('slug') }}">
                            <label for="slug">Slug</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="hexcolor" name="hexcolor" type="text" class="validate" value="{{ old('hexcolor') }}">
                            <label for="hexcolor">Hex Color</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="url" name="url" type="text" class="validate" value="{{ old('url') }}">
                            <label for="url">Url</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="logo" name="logo" type="text" class="validate" value="{{ old('logo') }}">
                            <label for="logo">Logo</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="trust" name="trust" type="text" class="validate" value="{{ old('trust') }}">
                            <label for="trust">Trust</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="dfe" name="dfe" type="text" class="validate" value="{{ old('dfe') }}">
                            <label for="dfe">DfE</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="ofsted_grade" name="ofsted_grade" type="text" class="validate" value="{{ old('ofsted_grade') }}">
                            <label for="ofsted_grade">Ofsted Grade</label>
                        </div>
                        <div class="input-field col s12">
                            <div class=""><label for=""><h6>Joined Date</h6></label></div>
                            <div id="joined_date" class="input-field">
                                <input id="datepicker1" name="joined" type="text" class="" placeholder="Date" value="{{ old('joined') }}">
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <input id="principal" name="principal" type="text" class="validate" value="{{ old('principal') }}">
                            <label for="principal">Principal</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="email" name="email" type="text" class="validate" value="{{ old('email') }}">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="telephone" name="telephone" type="text" class="validate" value="{{ old('telephone') }}">
                            <label for="telephone">Telephone</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="postal" name="postal" type="text" class="validate" value="{{ old('postal') }}">
                            <label for="postal">Postal</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="map" name="map" type="text" class="validate" value="{{ old('map') }}">
                            <label for="map">Map</label>
                        </div>
                        <div class="input-field col s12">
                            <label for="">Available Categories</label>
                            <br />
                            @foreach($categories as $category)
                                <p>
                                    <input type="checkbox" name="checked[{{$category->id}}]" id="category-{{$category->id}}"/>
                                    <label for="category-{{$category->id}}">{{$category->name}}</label>
                                </p>
                            @endforeach
                        </div>
                        <div class="input-field col s12">
                            <br />
                            <button type="submit" class="btn btn-info btn-block">Create</button>
                        </div>

                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')

<script>
    $(document).ready(function(){
        $('#datepicker1').pickadate({
            formatSubmit: 'yyyy/mm/dd',
            hiddenName: true,
            selectMonths: true,
            selectYears: 5
        });
    });
</script>

@endsection
