<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model {

	protected $table = 'types';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function category()
	{
		return $this->hasOne('Category');
	}

	public function posts()
	{
		return $this->hasMany('Post');
	}

}