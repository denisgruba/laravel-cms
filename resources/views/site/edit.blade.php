@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.site-edit')
        <div class="row">
            <div class="col s10 offset-s1 white">
                <div class="card-panel" style="background-color: #{{$site->hex_color}};">
                    <h5 class="white-text">{{ $site->name }} - Site Info</h5>
                </div>
                {{ Form::open(array('url' => '/site/update/'.$site->id, 'files' => true)) }}
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="name" name="name" type="text" class="validate" value="{{$site->name}}">
                            <label for="name">Site Name</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="slug" name="slug" type="text" class="validate" value="{{$site->slug}}">
                            <label for="slug">Site Slug</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="hexcolor" name="hexcolor" type="text" class="validate" value="{{$site->hex_color}}">
                            <label for="hexcolor">Site Color</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="url" name="url" type="text" class="validate" value="{{$site->url}}">
                            <label for="url">Site Url</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="logo" name="logo" type="text" class="validate" value="{{$site->logo}}">
                            <label for="logo">Site Logo</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="trust" name="trust" type="text" class="validate" value="{{$site->trust}}">
                            <label for="trust">Site Trust</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="dfe" name="dfe" type="text" class="validate" value="{{ $site->dfe }}">
                            <label for="dfe">DfE</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="ofsted_grade" name="ofsted_grade" type="text" class="validate" value="{{ $site->ofsted_grade }}">
                            <label for="ofsted_grade">Ofsted Grade</label>
                        </div>
                        <div class="input-field col s12">
                            <div class=""><label for=""><h6>Joined Date</h6></label></div>
                            <div id="joined_date" class="input-field">
                                <input id="datepicker1" name="joined" type="text" class="" placeholder="Date" value="{{ isset($site->joined) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $site->joined)->format('Y/m/d') : '' }}" data-value="{!! isset($site->joined) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $site->joined)->format('Y/m/d') : '' !!}">
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <input id="principal" name="principal" type="text" class="validate" value="{{ $site->principal }}">
                            <label for="principal">Principal</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="email" name="email" type="text" class="validate" value="{{ $site->email }}">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="telephone" name="telephone" type="text" class="validate" value="{{ $site->telephone }}">
                            <label for="telephone">Telephone</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="postal" name="postal" type="text" class="validate" value="{{ $site->postal }}">
                            <label for="postal">Postal</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="map" name="map" type="text" class="validate" value="{{ $site->map }}">
                            <label for="map">Map</label>
                        </div>
                        <div class="input-field col s12">
                            <label for="">Available Categories</label>
                            <br />
                            @foreach($categories as $category)
                                <p>
                                    <input type="checkbox" name="checked[{{$category->id}}]" id="category-{{$category->id}}"
                                        @foreach ($category_site as $cs)
                                            @if($category->id == $cs->category_id) checked @endif
                                        @endforeach
                                    />
                                    <label for="category-{{$category->id}}">{{$category->name}}</label>
                                </p>
                            @endforeach
                        </div>
                        <div class="input-field col s12">
                            <br />
                            <button type="submit" class="btn btn-info btn-block">Update</button>
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
