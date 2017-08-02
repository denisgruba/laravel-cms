<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_roles extends Model {

	protected $table = 'permission_role';
	public $timestamps = false;

	public function permission()
	{
		return $this->belongsTo('Permission');
	}

	public function roles()
	{
		return $this->belongsTo('Role');
	}

}
