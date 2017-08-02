<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function userRole()
    {
        return $this->hasOne('Roleusers');
    }

    public function profile()
    {
        return $this->hasOne('Profile');
    }
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

	public function usersites()
	{
		return $this->belongsToMany('App\Siteuser');
	}
	public function scopelist()
	{
		$users = User::select('users.id', 'users.name', 'users.email')
			->join('site_user', 'users.id', '=', 'site_user.user_id')
			->get();


	}
}
