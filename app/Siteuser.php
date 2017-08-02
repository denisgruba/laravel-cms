<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siteuser extends Model {

	protected $table = 'site_user';
	public $timestamps = false;

	public function site()
	{
		return $this->belongsTo('Site');
	}

	public function user()
	{
		return $this->belongsToMany('User');
	}
	public function scopeSites($query, $user )
	{
		return $query ->join('sites', 'site_user.site_id', '=', 'sites.id')
				      ->where('user_id', $user);
	}
}
