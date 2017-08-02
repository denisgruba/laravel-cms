@extends('layouts.app2')

@section('content')

    <main>
        @include('partials.breadcrumbs.media-list')
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
        {{ Form::open(array('url' => '/media/update/'.$site->id, 'files' => true, 'class' => '')) }}
            <div class="row" style="padding-left: 15px; padding-right: 15px; margin-bottom: 80px;">
                <div class="col s12 card-panel white">
                    <div class="row">
                        <h3>Upload Media</h3>
                        <div class="file-field input-field col s12">
                            <div class="btn">
                                <span>Upload</span>
                                <input type="file" name="files[]" multiple>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload one or more files. Maximum 50 files & max 10MB each file.">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($media as $resource)
                            <div class="col s12 m6 l3">
                                <div class="card large">
                                    @if(isImage($resource->extension))
                                        <div class="card-image">
                                            <img class="materialboxed"
                                                 src="{{ url('/img/') }}/default/{{($site->id)}}/{{($resource->filename)}}">
                                        </div>
                                    @endif
                                    <div class="card-content black-text">
                                        <span class="card-title truncate"><a
                                                    href="{{ url('/img/') }}/default/{{($site->id)}}/{{($resource->filename)}}"
                                                    target="_blank">{{$resource->filename}}</a></span>
                                    </div>
                                    <div class="card-action">
                                        <p>
                                            <input name="delete[]" type="checkbox" id="delete{{$resource->id}}" value="{{$resource->id}}"/>
                                            <label for="delete{{$resource->id}}" class="red-text">Delete File</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @include('partials.drawer', [
                        'drawerSubmit' => true,
                        'drawerPage' => 'empty'
                    ])
                </div>
            </div>
        {{ Form::close() }}

    </main>

@endsection
