<div id="thumbnail_settings" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4>Current Thumbnail</h4>
        <div class="row">
            <div class="col s6 m3 l2">
                @if(isset($post->default_resource_id))
                    <div class="card">
                        <div class="card-image">
                            <img class="materialboxed"
                            src="{{ url('/img/') }}/default/{{$site->id}}/{{$media->where('id', $post->default_resource_id)->first()->filename}}">
                        </div>
                        <div class="card-content black-text">
                            <span class="card-title truncate">
                                <a
                                href="{{ url('/img/') }}/default/{{$site->id}}/{{$media->where('id', $post->default_resource_id)->first()->filename}}"
                                target="_blank">{{$media->where('id', $post->default_resource_id)->first()->filename}}</a>
                            </span>
                        </div>
                    </div>
                @elseif(count($resources->where('featured', 1)->first()))
                    @foreach($resources as $resource)
                        @if($resource->featured === 1 && isImage($resource->extension))
                            <div class="card">
                                <div class="card-image">
                                    <img class="materialboxed"
                                    src="{{ url('/img/') }}/{{($post->post_id)}}/{{($resource->filename)}}">
                                </div>
                                <div class="card-content black-text">
                                    <span class="card-title truncate"><a href="{{ url('/img/') }}/{{($post->post_id)}}/{{($resource->filename)}}" target="_blank">{{$resource->filename}}</a></span>
                                </div>
                            </div>
                            @break
                        @endif
                    @endforeach
                @elseif(isset($resources))
                    @php $hasImageResource = false; @endphp
                    @foreach($resources as $resource)
                        @if(isImage($resource->extension))
                            <div class="card">
                                <div class="card-image">
                                    <img class="materialboxed"
                                    src="{{ url('/img/') }}/{{($post->post_id)}}/{{($resource->filename)}}">
                                </div>
                                <div class="card-content black-text">
                                    <span class="card-title truncate"><a href="{{ url('/img/') }}/{{($post->post_id)}}/{{($resource->filename)}}" target="_blank">{{$resource->filename}}</a></span>
                                </div>
                            </div>
                            @php $hasImageResource = true; @endphp
                            @break
                        @endif
                    @endforeach
                    @if(!$hasImageResource)
                        <h6>Post does not have any image uploaded and there is no thumbnail selected. Random image will be used.</h6>
                    @endif
                @else
                    <h6>Post does not have any image uploaded and there is no thumbnail selected. Random image will be used.</h6>
                @endif
            </div>
        </div>
        <h4>Change Thumbnail</h4>
        @if(count($resources))
            <div class="row">
                <h5>Attached images</h5>
                @foreach($resources as $resource)
                    @if(isImage($resource->extension))
                        <div class="col s6 m4 l2">
                            <div class="card medium">
                                <div class="card-image">
                                    <img class="materialboxed"
                                    src="{{ url('/img/') }}/{{($post->post_id)}}/{{($resource->filename)}}">
                                </div>
                                <div class="card-content black-text">
                                    <span class="card-title truncate"><a href="{{ url('/img/') }}/{{($post->post_id)}}/{{($resource->filename)}}" target="_blank">{{$resource->filename}}</a></span>
                                </div>
                                <div class="card-action">
                                    <p>
                                        <input name="featured" type="radio" class="attached-resource-radio" id="resource{{$resource->id}}" value="{{$resource->id}}"
                                        @if($resource->featured === 1)
                                            checked
                                        @endif
                                        />
                                        <label for="resource{{$resource->id}}">Use as Thumbnail Image</label>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
        @if(count($media))
            <div class="row">
                <h5>Other Images</h5>
                @foreach($media as $resource)
                    <div class="col s6 m4 l2">
                        <div class="card medium">
                            @if(isImage($resource->extension))
                                <div class="card-image">
                                    <img class="materialboxed" src="{{ url('/img/') }}/default/{{($site->id)}}/{{($resource->filename)}}">
                                </div>
                            @endif
                            <div class="card-content black-text">
                                <span class="card-title truncate"><a href="{{ url('/img/') }}/default/{{($site->id)}}/{{($resource->filename)}}" target="_blank">{{$resource->filename}}</a></span>
                            </div>
                            <div class="card-action">
                                <p>
                                    <input name="default" type="radio" class="default-resource-radio" id="resource_default{{$resource->id}}" value="{{$resource->id}}"
                                    @if($resource->id === $post->default_resource_id)
                                        checked
                                    @endif
                                    />
                                    <label for="resource_default{{$resource->id}}">Use as Thumbnail Image</label>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
        <a id="clearThumbSelection" href="#" class="waves-effect waves-green btn-flat">Clear Selection</a>
    </div>
</div>
