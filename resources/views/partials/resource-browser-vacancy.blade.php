<div id="resources_browser" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4>Attachments</h4>
        <div class="row">
            @foreach($resources as $resource)
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
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
</div>
