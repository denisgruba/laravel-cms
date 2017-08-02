<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model {

	protected $table = 'resources';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function post()
	{
		return $this->belongsTo('Post');
	}

}