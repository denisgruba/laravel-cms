@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.staff-create')
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
        <div class="row" style="padding-left: 15px; padding-right: 15px; margin-bottom: 80px;">
            @if(count($groups))
                {{ Form::open(array('url' => '/staff/store/'.$site->id, 'files' => true, 'id' => 'form', 'class' => 'col m12 card-panel white')) }}
                    <h3>Add Staff Member</h3>
                    <div id="tutorial-staff-create-name" class="row">
                        <div class="input-field col s3">
                            <input id="title" name="title" type="text" autocomplete="off" class="autocomplete validate" value="{{ old('title') }}">
                            <label for="title">Title/Initial/First Name</label>
                        </div>
                        <div class="input-field col s9">
                            <input id="name" name="name" type="text" class="validate" required value="{{ old('name') }}">
                            <label for="name">Name (Required)</label>
                        </div>
                    </div>
                    <div id="tutorial-staff-create-job" class="row">
                        <div class="input-field col s12">
                            <input id="position" name="position" type="text" autocomplete="off" class="autocomplete validate" value="{{ old('position') }}">
                            <label for="position">Job Title</label>
                        </div>
                    </div>
                    <div id="tutorial-staff-create-email" class="row">
                        <div class="input-field col s12">
                            <input id="email" name="email" type="email" class="validate" value="{{ old('email') }}">
                            <label for="email">E-Mail</label>
                        </div>
                    </div>
    				<div id="tutorial-staff-create-group" class="row">
    					<div class="input-field col s12">
                            <select name="group" id="group" required >
                                <option value="" disabled
                                    @unless (count($groups)==1)
                                        selected
                                    @endunless
                                >Pick a Group</option>
                                @foreach($groups as $group)
                                    <option value="{{$group->id}}"
                                        @if(count($groups)==1)
                                            selected
                                        @endif
                                    >{{$group->name}} @can('webteam')(Type ID: {{$group->id}}, Order: {{$group->order}})@endcan</option>
                                @endforeach
                            </select>
    						<label for="type">Group (Required)</label>
    					</div>
    				</div>
                    <div id="tutorial-staff-create-photo" class="row">
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
                    <div id="tutorial-drawer">
                        @include('partials.drawer', [
                            'drawerSubmit' => true,
                            'drawerPage' => 'staff'
                        ])
                    </div>
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
    <tutorial :tutorial-page="'CreateStaff'"></tutorial>


@endsection

@section('vue-template')

<script type="text/x-template" id="tutorial-component">
    <div></div>
</script>

@endsection

@section('scripts')

    <script>
    	$(document).ready(function(){
			$('select').material_select();
            $('input.autocomplete#title').autocomplete({
                data: {
                  "Mr": null,
                  "Mrs": null,
                  "Miss": null,
                  "Ms": null,
                  "Dr.": null,
                  "Prof.": null,
                },
                limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
                onAutocomplete: function(val) {
                  // Callback function when value is autcompleted.
                },
                minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
            });
            $('input.autocomplete#position').autocomplete({
                data: {
                  "Teacher": null,
                  "Teaching Assistant": null,
                  "Leadership Team": null,
                  "Principal": null,
                  "Subject Leader": null,
                  "Governor": null,
                  "Chair of Governors": null,
                  "Head of School": null,
                  "Vice Principal": null,
                  "Assistant Principal": null,
                  "Executive Principal": null,
                  "Vice Principal": null,
                  "Receptionist": null,
                  "Facilities": null,
                  "Cleaner": null,
                  "Finance": null,
                  "Bursar": null,
                  "SENCO": null,
                  "Secretary": null,
                  "Safeguarding": null,
                },
                limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
                onAutocomplete: function(val) {
                  // Callback function when value is autcompleted.
                },
                minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
            });
        });

    </script>

@endsection
