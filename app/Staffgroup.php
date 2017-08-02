<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staffgroup extends Model
{
	protected $table='staff_group';
	protected $with = 'staff';

	public function group()
	{
		return $this->belongsTo('Group');
	}
	public function staff()
	{
		return $this->hasMany('App\Staff', 'id', 'staff_id'  );
	}
}
