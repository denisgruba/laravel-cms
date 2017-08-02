<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resourcedefault extends Model {

	protected $table = 'resources_default';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function site_id()
	{
		return $this->belongsTo('Site');
	}

}
