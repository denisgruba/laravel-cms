@extends('layouts.app2')

@section('content')
	<main>
		@include('partials.breadcrumbs.staff-group')
		<div class="row">
			<div class="col m10 offset-m1">
				@if(count($groups))
					<div class="row">
						<table class="highlight white z-depth-1 col m12">
							<thead>
							<tr>
								@can('webteam')
									<th data-field="ID">Group ID</th>
								@endcan
								<th data-field="Title">Group name</th>
								<th>Rename</th>
								<th data-field="Options" class="right-align">Remove</th>
							</tr>
							</thead>
							@foreach($groups as $group)
								{{ Form::open(array('url' => 'staff/group/rename/'.$group->id.'/'.$site->id, 'class' => '')) }}
									<tr>

										@can('webteam')
											<td>{{$group->id}}</td>
										@endcan

										<td>
											<div class="input-field inline" style="width:100%">
												<input id="group" name="group" type="text" class="validate" required value="{{$group->name}}">
												<label for="group">Rename group</label>
											</div>
										</td>
										<td>
											<button class="btn green waves-effect waves-light" type="submit" name="action">Rename
												<i class="material-icons right">mode_edit</i>
											</button>
										</td>

										<td>
											<a href="{{ url('staff/group/delete/') }}/{{$group->id}}/{{$site->id}}" class="waves-effect btn red right"><i class="material-icons">delete</i></a>
										</td>

									</tr>
								{{ Form::close() }}
							@endforeach
						</table>
					</div>
				@endif
				<div class="row">
					{{ Form::open(array('url' => 'staff/group/create/'.$site->id, 'class' => 'col m12 card-panel white')) }}
						<div class="input-field col s10">
							<input id="group" name="group" type="text" class="validate" required value="{{ old('group') }}">
							<label for="group">Add new group</label>
						</div>
						<div class="input-field col s2">
							<button class="btn-large waves-effect waves-light right" type="submit" name="action">
								<i class="material-icons">add</i>
							</button>
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>

	</main>

@endsection

@section('scripts')



@endsection
