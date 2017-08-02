<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model {

	protected $table = 'contents';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function content()
	{
		return $this->belongsTo('Post');
	}

}