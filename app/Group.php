<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'group';

	protected $dates = ['deleted_at'];

    use SoftDeletes;


	public function staff()
	{
		return $this->hasMany('App\Staff', 'group_id', 'id'  );
	}
	public function site()
	{
		return $this->belongsTo('App\site', 'id', 'site_id'  );
	}
}
