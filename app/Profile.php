<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model {

	protected $table = 'profiles';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function user()
	{
		return $this->belongsTo('User');
	}

}