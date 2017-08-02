@php

	if($view_name == 'dashboard3-sites' || $view_name == 'dashboard3-sitessorted' || $view_name == 'auth-login' || $view_name == 'auth-register' || $view_name == 'user-list' || $view_name == 'user-edit' || $view_name == 'auth-accessDenied' || $view_name == 'site-create' || $view_name == 'user-activity' || $view_name == 'post3-converter') $navExtended = true;
	else $navExtended = false;


@endphp
<div class="navbar-fixed">
	<nav class="nav-extended">
		<div class="main nav-wrapper">
			<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons left">menu</i><span class="left brand-logo" style="padding-left: 30px;">Menu</span></a>
			<div class="nav-smaller">
				<a href="{{url('/')}}" class="brand-logo hide-on-med-and-down" style="padding-left: 10px; position: relative;">The Bee Hub</a>
				<ul class="right">
					{{-- <li>
						<form>
						   <div class="input-field">
							 <input id="search" type="search" required>
							 <label class="label-icon" for="search"><i class="material-icons">search</i></label>
							 <i class="material-icons">close</i>
						   </div>
						 </form>
					</li> --}}
			        <li id="tutorial-help"><a href="#helpcentre" style="height: 50px;"><i class="mdi mdi-help-circle"></i></a></li>



			        {{-- <li><a href="collapsible.html"><i class="material-icons">refresh</i></a></li> --}}
			        {{-- <li><a href="#!" class="dropdown-button" data-activates="dropdown-more"><i class="material-icons">more_vert</i></a></li>
					<ul id="dropdown-more" class="dropdown-content">
						<li><a href="#!">one</a></li>
						<li><a href="#!">two</a></li>
					</ul> --}}

	    		</ul>
				<div class="col l8">

				</div>
			</div>
		</div>
	</nav>
</div>
<ul class="side-nav fixed white lighten-4" id="slide-out">
	@unless($navExtended)
		@if (isset($site))
			<div class="nav-school-logo">
				<img src="{{ $site->logo }}" class="" alt="">
			</div>
		@endif
	@else
		<div class="nav-school-logo">
			<img src="{{url('/')}}/img/logo.png" class="responsive-img" alt="">
		</div>
	@endunless

	<li class="divider"></li>
	<li class="no-padding">
		<ul class="collapsible collapsible-accordion">
			@if (Auth::guest())
				<li>
					<a class="collapsible-header waves-effect">Hello, Guest<i class="material-icons right">arrow_drop_down</i></a>
					<div class="collapsible-body">
						<ul>
							<li><a href="{{ url('/login') }}">Login</a></li>
							<li><a href="{{ url('/register') }}">Register</a></li>
						</ul>
					</div>
				</li>
			@else
				<li>
					<a class="collapsible-header waves-effect"><span>Hello, {{ Auth::user()->name }}</span><i class="material-icons right">arrow_drop_down</i></a>
					<div class="collapsible-body">
						<ul>
							<li><a href="{{ url('/') }}/user/edit">Edit Profile<i class="material-icons right">account_box</i></a></li>
							<li><a href="{{ route('logout') }}">Logout<i class="material-icons right">input</i></a></li>
						</ul>
					</div>
				</li>
			@endif
		</ul>
	</li>
	<li class="divider"></li>
	<li><a href="{{ url('/') }}">Dashboard<i class="material-icons right">apps</i></a></li>

	@unless($navExtended)
		@if (isset($site))
			<nav-quick-create :site-id="{{$site->id}}"></nav-quick-create>
		@endif
	@endunless
	<li class="no-padding">
		<ul class="collapsible collapsible-accordion">
			@can('webteam')
				<li class="divider"></li>
				<li>
					<a class="collapsible-header waves-effect">Admin Settings<i class="material-icons right">arrow_drop_down</i></a>
					<div class="collapsible-body">
						<ul class="red lighten-5">
							<li><a href="{{ url('/user/activity') }}">Activity log<i class="material-icons right">storage</i></a></li>
							<li><a href="{{ url('/site/create') }}">Create new site<i class="material-icons right">library_add</i></a></li>
							@unless($navExtended)
								@if (isset($site))
									<li><a href="{{ url('/site/edit') }}/{{$site->id}}">Edit site details<i class="material-icons right">library_books</i></a></li>
								@endif
							@endunless
							<li><a href="{{ url('/user/list') }}">Edit users<i class="material-icons right">assignment_ind</i></a></li>
							<li><a href="{{ url('/convert') }}">PDF to Image Converter<i class="material-icons right">wallpaper</i></a></li>
						</ul>
					</div>
				</li>
			@endcan
		</ul>
	</li>
	<li class="divider"></li>
	<li><a href="#helpcentre">Help<i class="material-icons right">help_circle</i></a></li>
</ul>
