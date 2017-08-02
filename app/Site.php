<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model {

	protected $table = 'sites';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function socialMedia()
	{
		return $this->hasMany('Socialaccount');
	}

	public function posts()
	{
		return $this->hasMany('Post');
	}
	public function usersites()
	{
		return $this->hasMany('Siteuser');
	}
	public function groups()
	{
		return $this->hasMany('App\Group');
	}

}
