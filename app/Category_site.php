<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category_site extends Model {

	protected $table = 'category_site';
	public $timestamps = false;

	public function categorysite()
	{
		return $this->belongsTo('Site');
	}

	public function category()
	{
		return $this->belongsTo('Category');
	}

}