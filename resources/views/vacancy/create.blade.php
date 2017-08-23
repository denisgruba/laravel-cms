@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.vacancy-create')
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
                {{ Form::open(array('url' => '/vacancy/store', 'files' => true, 'class' => '')) }}
                    <div class="row" style="padding-left: 15px; padding-right: 15px; margin-bottom: 150px;">
                        <div class="col s12 card-panel white">
                            <h3>Create Vacancy</h3>
                            <div class="row" id="tutorial-create-title">
                                <div class="input-field col s12">
                                    <input id="title" name="title" type="text" class="validate" required value="{{ old('title') }}">
                                    <label for="title">Title (Required)</label>
                                </div>
                            </div>
                            <div class="row" id="tutorial-create-content">
                                <div class="input-field col s12" {{--id="wysiwyg-editor"--}}>
                                    <label for="title"><h6>Content</h6></label>
                                    <textarea id="material-editor" name="content" rows="4" class="material-editor materialize-textarea form-control" placeholder="Copy the Contents here">{{ old('content') }}</textarea>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col s12">
                                    <div class=""><label for=""><h6>Closing Date (Required)</h6></label></div>
                                    <div id="tutorial-create-end-date" class="input-field">
                                        <input id="datepicker2" name="end_date" type="text" class="" required placeholder="Date" value="{{ old('end_date') }}">
                                    </div>

                                </div>
                            </div>
                            <div class="row" id="tutorial-create-type">
                                <div class="input-field col s12">
                                    <select name="type" id="type" required>
                                        <option value="" disabled
                                            @unless(isset($type_id) || count($types)==1) selected @endunless
                                        >Pick a Job Role type (Required)</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->type_id}}"
                                            @if((isset($type_id) && $type_id==$type->type_id) || count($types)==1) selected @endif
                                            >{{$type->name}} @can('webteam')(Type ID: {{$type->type_id}})@endcan</option>
                                        @endforeach
                                    </select>
                                    <label for="type">Select Job Role: (Required)</label>
                                </div>
                            </div>
                            <div style="clear: both;"></div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="site" id="site" required>
                                        <option value="" disabled
                                            @unless(isset($site_id) || count($available_sites)==1) selected @endunless
                                        >Pick a Site (Required)</option>
                                        @foreach($available_sites as $single_site)
                                            <option value="{{$single_site->id}}"
                                            @if((isset($single_site_id) && $single_site_id==$single_site->id) || count($available_sites)==1) selected @endif
                                            data-icon="{{$single_site->logo}}"
                                            >{{$single_site->name}} @can('webteam')(Site ID: {{$single_site->id}})@endcan</option>
                                        @endforeach
                                    </select>
                                    <label for="type">Select Site: (Required)</label>
                                </div>
                            </div>
                            <div style="clear: both;"></div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="location" id="location" required>
                                        <option value="" disabled selected>Pick a Location (Required)</option>
                                        <option value="1">Internal</option>
                                        <option value="2">External</option>
                                        <option value="0">Both</option>
                                    </select>
                                    <label for="type">Type of vacancy: (Required)</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <h5>Optional settings:</h5>
                                    <p>You can attach images and pdf documents to your vacancy. One of the attached images will be used as a thumbnail. If there is no image added a random image will be used as a thumbnail. Alternatively, you can select a custom thumbnail in the "Thumbnail Settings".</p>
                                    <p>You can also customize the vacancy item's publish and expire dates in the "Publish Settings".</p>
                                </div>
                            </div>
                            <div class="row" id="tutorial-create-attachments">
                                <div class="file-field input-field col s12">
                                    {{-- <div class="green message" style="position: relative; top: -20px;"><p>Drag and drop here</p></div> --}}
                                    <div class="btn">
                                        <span>Upload</span>
                                        <input type="file" name="files[]" multiple>
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text"placeholder="Upload one or more files. Maximum 50 files & max 10MB each file.">
                                    </div>
                                </div>
                            </div>
                            <div id="tutorial-drawer">
                                @include('partials.drawer', [
                                    'drawerSubmit' => true,
                                    'drawerPage' => 'vacancy'
                                ])
                            </div>
                        </div>
                    </div>
                    <div id="publish_settings" class="modal bottom-sheet">
                        <div class="modal-content">
                            <h4>Publish Settings</h4>
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
                                    </div>
                                </div>
                                {{-- <div class="col s6">
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
                                </div> --}}
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            @else
                <div class="row">
                    <div class="col m10 offset-m1 white">
                        <h3>There is no Vacancy roles added.</h3>
                        <a class="red waves-effect waves-light btn-large" href="{{url('/')}}/vacancy/type/{{$site->id}}"><i class="material-icons right">add</i>Add Vacancy roles First</a>
                    </div>
                </div>
            @endif
        </div>
    </main>

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

            // var timepicker = TimePicker;
            //
            // timepicker.bindInput('#timepicker1', {timeFormat: 'military'});
            // timepicker.bindInput('#timepicker2', {timeFormat: 'military'});

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
            };



        });

    </script>
    <style>
        .select-dropdown li img {
            width: auto;
        }
    </style>

@endsection
