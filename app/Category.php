<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {

	protected $table = 'categories';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function type()
	{
		return $this->hasMany('Type');
	}
	public function site_cat()
	{
		return $this->hasMany('Category_site');
	}
}