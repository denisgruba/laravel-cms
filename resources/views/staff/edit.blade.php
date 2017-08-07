@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.staff-edit')
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
        <div class="row"  style="padding-left: 15px; padding-right: 15px; margin-bottom: 80px;">
            @if(count($groups))
                {{ Form::open(array('url' => '/staff/update/'.$staff->id.'/'.$site->id, 'files' => true, 'class' => 'col m12 card-panel white')) }}
                <h3>Edit Staff Member</h3>
                <div class="row">
                    <div class="input-field col s3">
                        <input id="title" name="title" type="text" class="validate" value="{{$staff->title}}">
                        <label for="title">Title/Initial/First Name</label>
                    </div>
                    <div class="input-field col s9">
                        <input id="name" name="name" type="text" class="validate" required value="{{$staff->name}}">
                        <label for="name">Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s3">
                        @if(isset($staff->photo))
                            <div class="card large">
                                <div class="card-image">
                                    <img class="materialboxed"
                                         src="{{ url('/uploads/staff') }}/{{($staff->id)}}/{{($staff->photo)}}">
                                </div>
                                <div class="card-content black-text">
                                    <span class="card-title truncate"><a
                                            href="{{ url('/uploads/staff') }}/{{($staff->id)}}/{{($staff->photo)}}"
                                            target="_blank">{{$staff->photo}}</a></span>
                                </div>
                                <div class="card-action">
                                    <p>
                                        <input name="delete[]" type="checkbox" id="delete{{$staff->id}}"
                                               value="{{$staff->photo}}"/>
                                        <label for="delete{{$staff->id}}" class="red-text">Delete Image</label>
                                    </p>
                                </div>
                            </div>
						@else
							<div class="card">
								<div class="card-image">
									<img class=""
										 src="{{ url('/img/') }}/nostaffimage.png">
								</div>
							</div>
                        @endif
                    </div>
                    <div class="col s9">
                        <div class="input-field">
                            <input id="position" name="position" type="text" class="validate" value="{{$staff->position}}">
                            <label for="position">Job Title</label>
                        </div>
                        <div class="input-field">
                            <input id="email" name="email" type="email" class="validate"  value="{{$staff->email}}">
                            <label for="email">E-Mail</label>
                        </div>
                        <div class="row">
							<div class="col s12" {{--id="wysiwyg-editor"--}}>
                                <label for="title"><h6>Content</h6></label>
                                <textarea id="material-editor" name="bio" rows="2" class="material-editor form-control" placeholder="Add content">{!!$staff->bio!!}</textarea>
                            </div>
                        </div>
                        <div class="input-field">
							<select name="group" id="group" required >
                                @foreach($groups as $group)
									<option value="{{$group->id}}"
											@if($staff->group_id == $group->id)
											selected
											@endif
									>{{$group->name}} @can('webteam')(Type ID: {{$group->id}}, Order: {{$group->order}})@endcan</option>
								@endforeach
							</select>
							<label for="type">Edit Group</label>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>Upload Photograph</span>
                            <input type="file" name="files[]">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload">
                        </div>
                    </div>
                </div>
                @include('partials.drawer', [
                    'drawerSubmit' => true,
                    'drawerPage' => 'staff'
                ])
                {{ Form::close() }}
            @else
                <div class="row">
                    <div class="col m10 offset-m1 white">
                        <h3>There is no staff groups added.</h3>
                        <a class="red waves-effect waves-light btn-large" href="{{ url('/') }}/staff/group/{{$site->id}}"><i class="material-icons right">add</i>Add Staff groups First</a>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection

@section('scripts')

	<script>
		$(document).ready(function(){
			$('select').material_select();
		});
	</script>

@endsection
