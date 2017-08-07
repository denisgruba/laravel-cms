<?php

function isImage($file_extension){
	$acceptedExtensions = [
		'jpg',
		'png',
		'jpeg',
		'gif',
		'bmp'
	];
	if (in_array(strtolower($file_extension), $acceptedExtensions)){
		return true;
	}
	else return false;

}