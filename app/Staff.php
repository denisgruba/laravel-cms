<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
	protected $table = 'staff';

	use SoftDeletes;

	public function group()
	{
		return $this->hasOne('App\Group', 'id', 'group_id');
	}

}
