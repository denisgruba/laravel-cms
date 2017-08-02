<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Socialaccount extends Model {

	protected $table = 'social_accounts';
	public $timestamps = true;

	public function site()
	{
		return $this->belongsTo('Site');
	}

}