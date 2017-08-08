@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.post-create')
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
            @if(count($types))
                {{ Form::open(array('url' => '/post/store', 'files' => true, 'class' => '')) }}
                    <div class="row" style="padding-left: 15px; padding-right: 15px; margin-bottom: 150px;">
                        <div class="col s12 card-panel white">
                            <h3>Create {{$category->name}}</h3>
                            <div class="row" id="tutorial-create-title">
                                <div class="input-field col s12">
                                    <input id="title" name="title" type="text" class="validate" required value="{{ old('title') }}">
                                    <label for="title">Title (Required)</label>
                                </div>
                            </div>
                            @unless ($category->id == 5)
                                <div class="row" id="tutorial-create-content">
                                    <div class="input-field col s12" {{--id="wysiwyg-editor"--}}>
                                        <label for="title"><h6>Content</h6></label>
                                        <textarea id="material-editor" name="content" rows="4" class="material-editor materialize-textarea form-control" placeholder="Add content">{{ old('content') }}</textarea>
                                    </div>
                                </div>
                            @endunless
                            @if ($category->id==2)
                                <div id="tutorial-create-venue" class="row">
                                    <div class="input-field col s12">
                                        <input id="venue" name="venue" type="text" class="validate" value="{{ old('venue') }}">
                                        <label for="venue">Event venue</label>
                                    </div>
                                </div>
                            @endif
                            @if ($category->id==2)
                                <div class="row">
                                    <div class="col s6">
                                        <div class=""><label for=""><h6>Start Date (Required)</h6></label></div>
                                        <div id="tutorial-create-start-date" class="input-field">
                                            <input id="datepicker1" name="start_date" type="text" class="" required placeholder="Date" value="{{ old('start_date') }}">
                                        </div>
                                        <div id="tutorial-create-start-time" class="switch">
                                            <label class="not-absolute">
                                                No Start time
                                                <input type="checkbox" name="enable_starttime" id="enable_starttime">
                                                <span class="lever"></span>
                                                Custom Start Time
                                            </label>
                                        </div>
                                        <div class="input-field" id="start">
                                            <input id="timepicker1" name="start_time" type="text" class="" placeholder="Time" value="{{ old('start_time') }}">
                                        </div>
                                    </div>
                                    <div class="col s6">
                                        <div class=""><label for=""><h6>End Date (Required)</h6></label></div>
                                        <div id="tutorial-create-end-date" class="input-field">
                                            <input id="datepicker2" name="end_date" type="text" class="" required placeholder="Date" value="{{ old('end_date') }}">
                                        </div>
                                        <div id="tutorial-create-end-time" class="switch">
                                            <label class="not-absolute">
                                                No End Time
                                                <input type="checkbox" name="enable_endtime" id="enable_endtime">
                                                <span class="lever"></span>
                                                Custom End Time
                                            </label>
                                        </div>
                                        <div class="input-field" id="end">
                                            <input id="timepicker2" name="end_time" type="text" class="" placeholder="Time" value="{{ old('end_time') }}">
                                        </div>
                                    </div>
                                </div>
                                <div style="clear: both; margin-bottom: 60px;"></div>
                            @endif
                            <div class="row" id="tutorial-create-type">
                                <div class="input-field col s12">
                                    <select name="type" id="type" required>
                                        <option value="" disabled
                                            @unless(isset($type_id) || count($types)==1) selected @endunless
                                        >Pick a {{$category->name}} type (Required)</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->type_id}}"
                                            @if((isset($type_id) && $type_id==$type->type_id) || count($types)==1) selected @endif
                                            >{{$type->name}} @can('webteam')(Type ID: {{$type->type_id}})@endcan</option>
                                        @endforeach
                                    </select>
                                    <label
                                    @if($category->id == 2)
                                       id="eventType"
                                    @endif
                                    for="type">Where to Publish: (Required)</label>
                                </div>
                            </div>
                            @if($category->id==1)
                                <div class="row">
                                    <div class="col s12">
                                        <h5>Optional settings:</h5>
                                        <p>You can attach images and pdf documents to your news items. One of the attached images will be used as a thumbnail. If there is no image added a random image will be used as a thumbnail. Alternatively, you can select a custom thumbnail in the "Thumbnail Settings".</p>
                                        <p>You can also customize the news item's publish and expire dates in the "Publish Settings".</p>
                                    </div>
                                </div>
                            @elseif($category->id==5)
                                <div class="row">
                                    <div class="col s12">
                                        <h5>Add your document:</h5>
                                        <p>You can attach .PDF documents here.</p>
                                        <p>You can also customize the letter's publish and expire dates in the "Publish Settings".</p>
                                    </div>
                                </div>
                            @elseif($category->id==2)
                                <div class="row">
                                    <div class="col s12">
                                        <h5>Optional settings:</h5>
                                        <p>You can attach images and other files to your post.</p>
                                        <p>You can also delay the publish date in the "Publish Settings". Setting up a Publish date will prevent the event from displaying on the website until the selected date.</p>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col s12">
                                        <h5>Optional settings:</h5>
                                        <p>You can attach images and other files to your post.</p>
                                        <p>You can also customize the post's publish and expire dates in the "Publish Settings".</p>
                                    </div>
                                </div>
                            @endif
                            <div class="row" id="tutorial-create-attachments">
                                <div class="file-field input-field col s12">
                                    {{-- <div class="green message" style="position: relative; top: -20px;"><p>Drag and drop here</p></div> --}}
                                    <div class="btn">
                                        <span>Upload</span>
                                        <input type="file" name="files[]" multiple
                                            @if($category->id==5)
                                                required
                                                accept="pdf"
                                            @endif
                                        >
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text"
                                            @if($category->id==5)
                                                placeholder="Upload one max 10MB file. PDF files required."
                                            @else
                                                placeholder="Upload one or more files. Maximum 50 files & max 10MB each file."
                                            @endif
										>
                                    </div>
                                </div>
                            </div>
                            <div id="tutorial-drawer">
                                @include('partials.drawer', [
                                    'drawerSubmit' => true,
                                    'drawerPage' => 'post'
                                ])
                            </div>
                        </div>
                    </div>
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
                                                    <input type="checkbox" name="enable_publish" id="enable_publish">
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
                                        <input id="datepicker3" name="publish_date" type="text" class="" placeholder="Date" value="{{ old('publish_date') }}">
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="timepicker3" name="publish_time" type="text" class="" placeholder="Time" value="{{ old('publish_time') }}">
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
                                                    <input type="checkbox" name="enable_custom" id="enable_custom">
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
                                                    <input type="checkbox" name="post_pinned" id="pinned">
                                                    <span class="lever"></span>
                                                    Pinned
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
                                                        <input type="checkbox" name="enable_publish" id="enable_publish">
                                                        <span class="lever"></span>
                                                        Custom Publish Date
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="publish">
                                                <div class="input-field">
                                                    <input id="datepicker1" name="start_date" type="text" class="" placeholder="Date" value="{{ old('start_date') }}">
                                                </div>
                                                <div class="input-field">
                                                    <input id="timepicker1" name="start_time" type="text" class="" placeholder="Time" value="{{ old('start_time') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <label for=""><h6>Allow Expire</h6></label>
                                            <div class="input-field">
                                                <div class="switch">
                                                    <label class="not-absolute">
                                                        Never Expire
                                                        <input type="checkbox" name="enable_expire" id="enable_expire">
                                                        <span class="lever"></span>
                                                        Custom Expire Date
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="expire">
                                                <div class="input-field">
                                                    <input id="datepicker2" name="end_date" type="text" class="" placeholder="Date" value="{{ old('end_date') }}">
                                                </div>
                                                <div class="input-field">
                                                    <input id="timepicker2" name="end_time" type="text" class="" placeholder="Time" value="{{ old('end_time') }}">
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
                    <div id="thumbnail_settings" class="modal modal-fixed-footer">
                        <div class="modal-content">
                            <h4>Custom Thumbnail Browser</h4>
                            <div class="row">
                                @if(count($media))
                                    @foreach($media as $resource)
                                        <div class="col s6 m4 l2">
                                            <div class="card medium">
                                                @if(isImage($resource->extension))
                                                    <div class="card-image">
                                                        <img class="materialboxed"
                                                             src="{{ url('/img/') }}/default/{{($site->id)}}/{{($resource->filename)}}">
                                                    </div>
                                                @endif
                                                <div class="card-content black-text">
                                                    <span class="card-title truncate"><a href="{{ url('/img/') }}/default/{{($site->id)}}/{{($resource->filename)}}" target="_blank">{{$resource->filename}}</a></span>
                                                </div>
                                                <div class="card-action">
                                                    <p>
                                                        <input name="default" type="radio" class="default-resource-radio" id="resource_default{{$resource->id}}" value="{{$resource->id}}"
															   {{-- @unless(isImage($resource->extension))
															   disabled
															   @endunless
															   @if($resource->featured === 1)
															   checked
																@endif --}}
														/>
														<label for="resource_default{{$resource->id}}">Use as Thumbnail Image</label>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
                            <a id="clearThumbSelection" href="#" class="waves-effect waves-green btn-flat">Clear Selection</a>
                        </div>
                    </div>
                {{ Form::close() }}
            @else
                <div class="row">
                    <div class="col m10 offset-m1 white">
                        <h3>There is no {{$category->name}} types added.</h3>
                        <a class="red waves-effect waves-light btn-large" href="{{url('/')}}/post/type/{{$category->id}}/{{$site->id}}"><i class="material-icons right">add</i>Add {{$category->name}} Type First</a>
                    </div>
                </div>
            @endif
        </div>
    </main>
    @if ($category->id==2)
        <tutorial-component :tutorial-page="'CreateEvent'"></tutorial-component>
    @elseif ($category->id==5)
        <tutorial-component :tutorial-page="'CreateDocument'"></tutorial-component>
    @else
        <tutorial-component :tutorial-page="'CreateNews'"></tutorial-component>
    @endif

@endsection

@section('vue-template')

<script type="text/x-template" id="tutorial-component"></script>

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
            $('#datepicker2').pickadate({
                formatSubmit: 'yyyy/mm/dd',
                hiddenName: true,
                selectMonths: true,
                selectYears: 5
            });

            var timepicker = TimePicker;

            timepicker.bindInput('#timepicker1', {timeFormat: 'military'});
            timepicker.bindInput('#timepicker2', {timeFormat: 'military'});

            @if($category->id ==2)
                $('#datepicker3').pickadate({
                    formatSubmit: 'yyyy/mm/dd',
					hiddenName: true,
					selectMonths: true,
					selectYears: 5
                });
            timepicker.bindInput('#timepicker3', {timeFormat: 'military'});
            @endif

            @if ($category->id==2)
                function startTimeCheck() {
                    if($('#enable_starttime').is(":checked")) $('#start').show();
                    else $('#start').hide();
                }
                startTimeCheck();
                $('#enable_starttime').on('change', function(){startTimeCheck()});

                function endTimeCheck() {
                    if($('#enable_endtime').is(":checked")) $('#end').show();
                    else $('#end').hide();
                }
                endTimeCheck();
                $('#enable_endtime').on('change', function(){endTimeCheck()});
            @else
                function customTimeCheck() {
                    if($('#enable_custom').is(":checked")) $('#custom').show();
                    else $('#custom').hide();
                }
                customTimeCheck();
                $('#enable_custom').on('change', function(){customTimeCheck()});
            @endif

            function expireCheck() {
                if($('#enable_expire').is(":checked")) $('#expire').show();
                else $('#expire').hide();
            }
            expireCheck();
            $('#enable_expire').on('change', function(){expireCheck()});

            function publishCheck() {
                if($('#enable_publish').is(":checked")) $('#publish').show();
                else $('#publish').hide();
            }
            publishCheck();
            $('#enable_publish').on('change', function(){publishCheck()});

            $('select').material_select();
            $("select[required]").css({display: "inline", height: 1, padding: 0, width: 1, border: 0, margin: 0, position: "relative", top: -30});

            $('.pin-panel').each(function() {
                var $this = $(this);
                $this.pushpin({
                    top: $this.offset().top
                });
            });
            $('#clearThumbSelection').click(function(){
                $('.default-resource-radio').each(function(){
                    $(this).prop('checked', false);
                });
            });

            $('#publish_settings').modal();

            var pinState = $('#pinCheckbox').val();
            var changePinState = function(){
                pinState = !pinState;
                // if(pinState==true){
                //     $('#pinToggle').addClass('blue');
                // } else $('#pinToggle').removeClass('blue');

            };



        });

    </script>


@endsection
