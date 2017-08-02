<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
{{-- <meta id="token" name="csrf-token" content="{{ csrf_token() }}"> --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- <!--[if IE]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
<![endif]--> --}}

<title>The Bee Hub</title>

<!-- Fonts -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet'
	  type='text/css'>
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700' rel='stylesheet' type='text/css'>
{{--<link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.7.0/summernote.css" rel="stylesheet">--}}

<link rel="stylesheet" href="/lib/picker/default.css"/>
<link rel="stylesheet" href="/lib/picker/default.date.css"/>
<link rel="stylesheet" href="/lib/picker/default.time.css"/>

<link rel="stylesheet" href="/lib/sweetalert.css"/>
<!-- Styles -->

{{--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">--}}
{{-- <link href="{{ mix('/css/app.css') }}" rel="stylesheet"> --}}
<link href="{{mix('/css/app.css')}}" rel="stylesheet">
{{--<link href="/css/style.css" rel="stylesheet">--}}
<script type="text/javascript">
	window.smartlook||(function(d) {
		var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
		var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
		c.charset='utf-8';c.src='//rec.getsmartlook.com/recorder.js';h.appendChild(c);
	})(document);
	smartlook('init', '6944854ae5e3f22cd5ed224fba47140a9b310690');
</script>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
