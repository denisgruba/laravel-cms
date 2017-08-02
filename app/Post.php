<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {

	protected $table = 'posts';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at','start','end', 'publish_at'];

	public function site()
	{
		return $this->hasOne('Site');
	}

	public function type()
	{
		return $this->hasOne('Type');
	}

	public function content()
	{
		return $this->hasOne('Content');
	}

	public function resource()
	{
		return $this->hasMany('Resources');
	}
	public function user()
	{
		return $this->belongsTo('User');
	}

}
