<div id="publish_settings" class="modal bottom-sheet">
    <div class="modal-content">
        <h4>Publish Settings</h4>
        @if($category->id==2)
            <div class="row">
                <div class="col s6">
                    <label for=""><h6>Custom Publish</h6></label>
                    <div class="input-field">
                        <div class="switch">
                            <label class="not-absolute">
                                Publish now
                                <input type="checkbox" name="enable_publish" id="enable_publish"
                                    {{ isset($post->publish_at) ? 'checked' : '' }}
                                >
                                <span class="lever"></span>
                                Custom Publish
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="publish">
                <div class="col s12"><label for=""><h6>Publish From Date/Time</h6></label></div>
                <div class="input-field col s6">
                    <input id="datepicker3" name="publish_date" type="text" class="" placeholder="Date" value="{{ isset($post->publish_at) ? $post->publish_at->toFormattedDateString() : '' }}" data-value="{!! isset($post->publish_at) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->publish_at)->format('Y/m/d') : '' !!}">
                </div>
                <div class="input-field col s6">
                    <input id="timepicker3" name="publish_time" type="text" class="" placeholder="Time" value="{!! isset($post->publish_at) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->publish_at)->format('H:i:s') : '' !!}">
                </div>
            </div>
        @else
            <div class="row">
                <div class="col s6">
                    <label for=""><h6>Custom Publish</h6></label>
                    <div class="input-field">
                        <div class="switch">
                            <label class="not-absolute">
                                Publish now + Never Expire
                                <input type="checkbox" name="enable_custom" id="enable_custom"
                                    checked
                                >
                                <span class="lever"></span>
                                Custom Publish
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col s6">
                    <label for=""><h6>Pin Item</h6></label>
                    <div class="input-field">
                        <div class="switch">
                            <label class="not-absolute">
                                Unpinned
                                <input type="checkbox" name="post_pinned" id="pinned"
                                    {{ $post->pinned==1 ? 'checked' : '' }}
                                >
                                <span class="lever"></span>
                                Pinned
                            </label>
                        </div>
                    </div>
                    <br />
                    <label for=""><h6>Pin Item to Trust Website</h6></label>
                    <div class="input-field">
                        <div class="switch">
                            <label class="not-absolute">
                                Unpinned
                                <input type="checkbox" name="post_pinned_trust" id="pinned_trust"
                                    {{ $post->pinned_trust==1 ? 'checked' : '' }}
                                >
                                <span class="lever"></span>
                                Pinned to Trust Website
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="custom">
                <div class="row">
                    <div class="col s6">
                        <label for=""><h6>Display From</h6></label>
                        <div class="input-field">
                            <div class="switch">
                                <label class="not-absolute">
                                    Publish Now
                                    <input type="checkbox" name="enable_publish" id="enable_publish"
                                        @if(isset($post->start))
                                            checked
                                        @endif
                                    >
                                    <span class="lever"></span>
                                    Custom Publish Date
                                </label>
                            </div>
                        </div>
                        <div id="publish">
                            <div class="input-field">
                                <input id="datepicker1" name="start_date" type="text" class="" placeholder="Date" value="{{ isset($post->start) ? $post->start->toFormattedDateString() : '' }}" data-value="{!! isset($post->start) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->start)->format('Y/m/d') : '' !!}">
                            </div>
                            <div class="input-field">
                                <input id="timepicker1" name="start_time" type="text" class="" placeholder="Time" value="{!! isset($post->start) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->start)->format('H:i:s') : ''!!}">
                            </div>
                        </div>
                    </div>
                    <div class="col s6">
                        <label for=""><h6>Allow Expire</h6></label>
                        <div class="input-field">
                            <div class="switch">
                                <label class="not-absolute">
                                    Never Expire
                                    <input type="checkbox" name="enable_expire" id="enable_expire"
                                        @if(isset($post->end))
                                            checked
                                        @endif
                                    >
                                    <span class="lever"></span>
                                    Custom Expire Date
                                </label>
                            </div>
                        </div>
                        <div id="expire">
                            <div class="input-field">
                                <input id="datepicker2" name="end_date" type="text" class="" placeholder="Date" value="{{ isset($post->end) ? $post->end->toFormattedDateString() : '' }}" data-value="{!! isset($post->end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->end)->format('Y/m/d') : '' !!}">
                            </div>
                            <div class="input-field">
                                <input id="timepicker2" name="end_time" type="text" class="" placeholder="Time" value="{!! isset($post->end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->end)->format('H:i:s') : ''!!}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
</div>
