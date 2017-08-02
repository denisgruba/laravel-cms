@extends('layouts.app2')

@section('content')

	<main>
        @include('partials.breadcrumbs.post-edit')
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
                {{ Form::open(array('url' => '/post/update/'.$post->post_id, 'files' => true, 'class' => '')) }}
                    <div class="row" style="padding-left: 15px; padding-right: 15px; margin-bottom: 250px;">
                        <div class="col s12 card-panel white">
                            <h3>Edit {{$category->name}}</h3>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="title" name="title" type="text" class="validate" required value="{{$post->title}}">
                                    <label for="title">Title (Required)</label>
                                </div>
                            </div>
                            @unless ($category->id==5)
                                <div class="row">
									<div class="col s12" {{--id="wysiwyg-editor"--}}>
                                        <label for="title"><h6>Content</h6></label>
                                        <textarea id="material-editor" name="content" rows="4" class="material-editor form-control" placeholder="Add content">{!!$post->contents!!}</textarea>
                                    </div>
                                </div>
                            @endunless
                            @if ($category->id==2)
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="venue" name="venue" type="text" class="validate" value="{{$post->venue}}">
                                        <label for="venue">Event venue</label>
                                    </div>
                                </div>
                            @endif
                            @if ($category->id==2)
                                <div class="row">
                                    <div class="col s6">
                                        <div class=""><label for=""><h6>Start Date/Time (Required)</h6></label></div>
                                        <div class="input-field">
                                            <input id="datepicker1" name="start_date" type="text" class="" required placeholder="Date" value="{{ isset($post->start) ? $post->start->toFormattedDateString() : '' }}" data-value="{!! isset($post->start) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->start)->format('Y/m/d') : '' !!}">
                                        </div>
                                        <div class="switch">
                                            <label class="not-absolute">
                                                No Start time
                                                <input type="checkbox" name="enable_starttime" id="enable_starttime"
													@unless(isset($post->start) && \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->start)->format('H:i:s')=='00:00:00')
														checked
													@endunless
												>
                                                <span class="lever"></span>
                                                Custom Start Time
                                            </label>
                                        </div>
                                        <div class="input-field" id="start">
                                            <input id="timepicker1" name="start_time" type="text" class="" placeholder="Time" value="{!! isset($post->start) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->start)->format('H:i:s') : ''!!}">
                                        </div>
                                    </div>
                                    <div class="col s6">
                                        <div class=""><label for=""><h6>End Date/Time (Required)</h6></label></div>
                                        <div class="input-field">
                                            <input id="datepicker2" name="end_date" type="text" class="" required placeholder="Date" value="{{ isset($post->end) ? $post->end->toFormattedDateString() : '' }}" data-value="{!! isset($post->end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->end)->format('Y/m/d') : '' !!}">
                                        </div>
                                            <div class="switch">
                                                <label class="not-absolute">
                                                    No End Time
                                                    <input type="checkbox" name="enable_endtime" id="enable_endtime"
														@unless(isset($post->end) && \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->end)->format('H:i:s')=='23:00:00')
															checked
														@endunless
													>
                                                    <span class="lever"></span>
                                                    Custom End Time
                                                </label>
                                            </div>
                                        <div class="input-field" id="end">
                                            <input id="timepicker2" name="end_time" type="text" class="" placeholder="Time" value="{!! isset($post->end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->end)->format('H:i:s') : ''!!}">
                                        </div>
                                    </div>
                                </div>
                            @endif
							<div class="row">
                                <div class="input-field col s12">
									<select name="type" id="type" required>
										<option value="" disabled>Edit {{$category->name}} type</option>
										@foreach($types as $type)
											<option value="{{$type->type_id}}"
													@if($post->type_id == $type->type_id)
														selected
													@endif
											>{{$type->name}} @can('webteam')(Type ID: {{$type->type_id}})@endcan</option>
										@endforeach
									</select>
                                    <label for="type">Where to Publish: (Required)</label>
                                </div>
                            </div>
							@if($category->id==1)
                                <div class="row">
                                    <div class="col s12">
                                        <h5>Optional settings:</h5>
                                        <p>You can attach more images and pdf documents to your news items. One of the attached images will be used as a thumbnail. If there is no image added a random image will be used as a thumbnail. Alternatively, you can select a custom thumbnail in the "Thumbnail Settings".</p>
                                        <p>You can also customize the news item's publish and expire dates in the "Publish Settings".</p>
                                    </div>
                                </div>
                            @elseif($category->id==5)
                                <div class="row">
                                    <div class="col s12">
                                        <h5>Replace your document:</h5>
                                        <p>Adding new .PDF document will replace the previous one.</p>
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
                                        <p>You can attach more images and other files to your post.</p>
                                        <p>You can also customize the post's publish and expire dates in the "Publish Settings".</p>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="file-field input-field col s12">
                                    <div class="btn">
                                        <span>
											@if($category->id==5)
												Replace
											@else
												Upload
											@endif
										</span>
                                        <input type="file" name="files[]" multiple
											@if($category->id==5)
												accept="pdf"
											@endif
										>
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text"
											@if($category->id==5)
	                                            placeholder="Upload one max 10MB file. PDF files recommended."
	                                        @else
												placeholder="Upload one or more files. Maximum 50 files & max 10MB each file."
	                                        @endif
										>
                                    </div>
                                </div>
                            </div>
							@if(count($resources))
								<div class="row">
									<div class="col s12">
										<h5>Attached Files/Images ({{count($resources)}})</h5>
										<a class="waves-effect waves-light btn-large" href="#resources_browser">View/Edit/Remove Attached Files/Images</a>
									</div>
								</div>
							@endif
							@include('partials.drawer', [
                                'drawerSubmit' => true,
                                'drawerPage' => 'post'
                            ])
                        </div>
                    </div>
					@include('partials.resource-browser')
					@include('partials.thumbnail-browser')
					@include('partials.publish-settings')
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

	<div id="confirm-delete" class="modal" style="width: 50%;">
	    <div class="modal-content">
	        <h4>Delete item</h4>
	        <p>Do you really want to delete this item?</p>
	    </div>
	    <div class="modal-footer">
	        <a href="{{ url('/post/delete/') }}/{{$post->post_id}}" class="modal-action red white-text waves-effect btn-flat">Delete</a>
	        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
	    </div>
	</div>
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

			@if($category->name ==='events')
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

			$('.default-resource-radio').change(function(){
				$('.attached-resource-radio').each(function(){
					$(this).prop('checked', false);
				});
			});

			$('.attached-resource-radio').change(function(){
				$('.default-resource-radio').each(function(){
					$(this).prop('checked', false);
				});
			});


			$('#clearThumbSelection').click(function(){
                $('.default-resource-radio').each(function(){
                    $(this).prop('checked', false);
                });
                $('.attached-resource-radio').each(function(){
                    $(this).prop('checked', false);
                });
            });


			$('#publish_settings').modal();

		});


	</script>

@endsection
