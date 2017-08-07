<?php

function isPDF($file_extension){
	$acceptedExtensions = [
		'pdf',
	];
	if (in_array(strtolower($file_extension), $acceptedExtensions)){
		return true;
	}
	else return false;

}
