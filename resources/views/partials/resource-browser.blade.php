<div id="resources_browser" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4>Attachments</h4>
        <div class="row">
            @foreach($resources as $resource)
                @if($category->id==5)
                    <div class="card horizontal">
                        <div class="card-image">
                            <img src="{{ url('/img/') }}/thumbs/{{($post->post_id)}}-{{str_replace('.pdf', '.jpg', $resource->filename)}}">
                        </div>
                        <div class="card-stacked">
                            <div class="card-content">
                                <p>{{$resource->filename}}</p>
                            </div>
                            <div class="card-action">
                                <a href="{{ url('/doc-uploads/') }}/{{($post->post_id)}}-{{($resource->filename)}}"
                                            target="_blank">{{$resource->filename}}</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col s12 m6 l3">
                        <div class="card large">
                            @if(isImage($resource->extension))
                                <div class="card-image">
                                    <img class="materialboxed"
                                         src="{{ url('/img/') }}/{{($post->post_id)}}/{{($resource->filename)}}">
                                </div>
                            @endif
                            <div class="card-content black-text">
                                <span class="card-title"><a
                                            href="{{ url('/uploads/') }}/{{($post->post_id)}}/{{($resource->filename)}}"
                                            target="_blank">{{$resource->filename}}</a></span>
                            </div>
                            <div class="card-action">
                                <p>
                                    <input name="delete[]" type="checkbox" id="delete{{$resource->id}}"
                                           value="{{$resource->id}}"/>
                                    <label for="delete{{$resource->id}}" class="red-text">Delete File</label>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
</div>
