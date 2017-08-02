<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model {

	protected $table = 'roles';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function permissions()
	{
		return $this->belongsToMany('Permissionroles');
	}

	public function roles()
	{
		return $this->hasMany('Roleusers');
	}

}