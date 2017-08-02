

<script type="text/javascript" src="/js/timepicker.js"></script>


{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}
{{--<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.0/summernote.css" rel="stylesheet">--}}
{{--<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.0/summernote.js"></script>--}}

{{-- <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
tinymce.init({
selector:'.tinymce',
plugins: 'link code',
block_formats:'Header 1=h1;Header 2=h2;Header 3=h3;Header 4=h4;Header 5=h5;Header 6=h6;Paragraph=p;Blockquote=blockquote',
toolbar: [
'cut copy paste | undo redo  | link unlink | code',
'bold italic | formatselect |  bullist numlist outdent indent | alignleft aligncenter alignright | removeformat'
],
menubar: false,
//		statusbar: false,
min_height: 200
});
</script> --}}
<script src="/js/libs.js"></script>



{{--<script type="text/javascript" src="/lib/picker/picker.js"></script>--}}
{{--<script type="text/javascript" src="/lib/picker/picker.date.js"></script>--}}
{{--<script type="text/javascript" src="/lib/picker/picker.time.js"></script>--}}

{{-- <script src="/lib/sweetalert.min.js"></script> --}}

<script src="{{mix('/js/app.js')}}"></script>

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>

<script>
$(document).ready(function(){

	$(".button-collapse").sideNav();
	$('.dropdown-button').dropdown({
		belowOrigin: true, // Displays dropdown below the button
	}
);
function checkDrawerFixed(){
	var $windowHeight = $(window).height();
	var $offset = $('#drawer-location').position().top - $(window).scrollTop()+$('#drawer-fixed').outerHeight(true);
	if($offset>$windowHeight){
		$('#drawer-static').hide();
		$('#drawer-fixed').show();
	} else {
		$('#drawer-static').show();
		$('#drawer-fixed').hide();
	}
};

if(!(typeof drawerEnabled=='undefined')){
	checkDrawerFixed();
	$(window).scroll(function(){
		checkDrawerFixed();
	});
	$(window).resize(function(){
		checkDrawerFixed();
	});
}
$('.modal').modal();
$('form').submit(function(){
	$('button[type="submit"]').attr('disabled','disabled');
});
var toolbar = [
	['cleaner', ['cleaner']],
	['presets', ['style']],
	['style', ['bold', 'italic']],
	['clear', ['clear']],
	['undo', ['undo', 'redo']],
	// ['fonts', ['fontsize', 'fontname']],
	// ['fonts', ['fontsize', 'fontname']],
	// ['color', ['color']],
	['ckMedia', ['ckImageUploader', 'ckVideoEmbeeder']],
	// ['para', ['ul', 'ol', 'paragraph', 'leftButton', 'centerButton', 'rightButton', 'justifyButton', 'outdentButton', 'indentButton']],
	['para', ['ul', 'ol', 'leftButton', 'centerButton', 'rightButton', 'outdentButton', 'indentButton']],
	// ['height', ['lineheight']],
	['table', ['table']],
	['insert', ['link', 'picture', 'hr']],
	['misc', ['codeview', 'fullscreen', 'help']],
	// ['help', ['help']]],
];

$('#material-editor').materialnote({
	toolbar: toolbar,
	height: 300,
	minHeight: 100,
	defaultBackColor: '#e0e0e0',
	// maximumImageFileSize: 1000,
	disableDragAndDrop: true,
	codemirror: {
		theme: 'monokai'
	},
	cleaner:{
		notTime: 2400, // Time to display Notifications.
		action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
		newline: '<br>', // Summernote's default is to use '<p><br></p>'
		notStyle: 'position:absolute;top:0;left:0;right:0', // Position of Notification
		icon: '<i class="material-icons">description</i>',
		keepHtml: false, // Remove all Html formats
		keepClasses: false, // Remove Classes
		badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
		badAttributes: ['style', 'start'] // Remove attributes from remaining tags
	},
	onImageUpload: function(files, editor, $editable) {
		$.each(files, function (idx, file) {
			sendFile(file,file.name);
		});
	},
	onInit: function() {
		checkDrawerFixed();
	},


});
function sendFile(file) {
	data = new FormData();
	data.append("file", file);
	data.append("site_id", {{isset($site->id) ? $site->id : 0}});
	data.append("category_id", {{isset($category->id) ? $category->id : 0}});
	data.append("post_id", {{isset($post->id) ? $post->id : 0}});
	$.ajax({
		url: "/api/storeImage",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		type: 'POST',
		success: function(url){
			$('#material-editor').materialnote('editor.insertImage', url);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus+" "+errorThrown);
		}
	});
}
// $('#materialnote').on('materialnote.image.upload', function(we, files) {
// 	// upload image to server and create imgNode...
// 	$materialnote.materialnote('insertNode', imgNode);
// });


//airmode editor
// $('.editorAir').materialnote({
// 	airMode: true,
// 	airPopover: [
// 		['color', ['color']],
// 		['font', ['bold', 'underline', 'clear']],
// 		['para', ['ul', 'paragraph']],
// 		['table', ['table']],
// 		['insert', ['link', 'picture']]
// 	]
// });



$(document).on('dragstart dragenter dragover', function(event) {
	dropZoneHideDelay=70;
	dropZoneVisible=true;
	dropZoneTimer=0;
	// Only file drag-n-drops allowed, http://jsfiddle.net/guYWx/16/
	if ($.inArray('Files', event.originalEvent.dataTransfer.types) > -1) {
		// Needed to allow effectAllowed, dropEffect to take effect
		event.stopPropagation();
		// Needed to allow effectAllowed, dropEffect to take effect
		// event.preventDefault();

		$('.file-field').addClass('highlight');     // Hilight the drop zone
		$('.file-field input').addClass('mouseover');     // Hilight the drop zone
		dropZoneVisible= true;

		// http://www.html5rocks.com/en/tutorials/dnd/basics/
		// http://api.jquery.com/category/events/event-object/
		// event.originalEvent.dataTransfer.effectAllowed= 'none';
		event.originalEvent.dataTransfer.dropEffect= 'none';
		// .dropzone .message
		if($(event.target).hasClass('highlight') || $(event.target).hasClass('message')) {
			event.originalEvent.dataTransfer.effectAllowed= 'copyMove';
			event.originalEvent.dataTransfer.dropEffect= 'move';
		}
		if($(event.target).hasClass('mouseover')) {
			$('.file-field').addClass('teal lighten-5');
		} else $('.file-field').removeClass('teal lighten-5');
	}
}).on('drop dragleave dragend', function (event) {
	dropZoneVisible= false;

	clearTimeout(dropZoneTimer);
	dropZoneTimer= setTimeout( function(){
		if( !dropZoneVisible ) {
			$('.file-field').removeClass('highlight');
			$('.file-field').removeClass('teal lighten-5');
		}
	}, dropZoneHideDelay); // dropZoneHideDelay= 70, but anything above 50 is better
});

// fileField = $('.file-field');
// $('#app-layout').on('dragenter', function() {
// 	$('#app-layout').addClass('dragover');
// 	fileField.addClass('teal');
// 	// $dropzoneMessage.text(options.langInfo.image.dropImage);
// }).on('dragleave', function() {
// 	$('#app-layout').removeClass('dragover');
// 	fileField.removeClass('teal');
// 	// $dropzoneMessage.text(options.langInfo.image.dragImageHere);
// });
$(".note-editor")
.find("button")
.attr("type", "button");

// $(".note-editor")
// 			.find(".note-misc")
// 			.addClass("right");

$('.modal').modal();
});
</script>
