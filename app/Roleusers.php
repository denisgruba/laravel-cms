<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roleusers extends Model {

	protected $table = 'role_user';
	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo('User');
	}

}