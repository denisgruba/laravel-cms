@extends('layouts.app2')

@section('content')
	<main>
		@include('partials.breadcrumbs.user-list')
		<div class="row">
			<div class="col s12 m12">
				<ul class="collapsible" data-collapsible="accordion">
					@foreach($users as $user)
					    <li>
					    	<div class="collapsible-header">{{$user->name}}</div>
					    	<div class="collapsible-body">
								{{ Form::open(array('url' => '/user/edit/sites/'.$user->id)) }}
									@foreach($sites as $site)
										<p>
											<input type="checkbox" id="user{{$user->id}}site{{$site->id}}" value="{{$site->id}}" name="{{$site->id}}"
												@foreach($user->sites as $usersite)
													@if($usersite->id == $site->id)
														checked
													@endif
												@endforeach
											/>
											<label for="user{{$user->id}}site{{$site->id}}">{{$site->name}}</label>
										</p>
									@endforeach
									<button class="btn-large waves-effect waves-light right" type="submit" name="action">Update
										<i class="material-icons right">send</i>
									</button>
									<div class="clearfix"></div>
								{{ Form::close() }}
							</div>
					    </li>
					@endforeach
				</ul>
			</div>
		</div>
	</main>

@endsection

@section('scripts')

	<script>
		$(document).ready(function(){
			$('.hideme').hide();
			$('#1').show();
			$('select').material_select();
			$('select').change(function () {
				$('.hideme').hide();
				$('#'+$(this).val()).show();
			});
		});
	</script>

@endsection
