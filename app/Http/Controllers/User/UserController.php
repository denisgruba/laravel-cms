<?php

namespace App\Http\Controllers\User;

use DB;
use Auth;
use File;
use Mail;
use Session;
use Storage;
use App\Post;
use App\Site;
use App\Type;
use App\User;
use Validator;
use App\Content;
use App\Category;
use App\Resource;
use App\Siteuser;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	public function edit()
	{
		$user = Auth::user();

		return view('user/edit', compact('user'));
	}
	public function userUpdate(Request $request)
	{
		$user = Auth::user();
		$user->email = $request::get('email');
		$user->name = $request::get('name');
		$user->save();

		return redirect()->back();
	}

	public function getActivityLog($user_id=null)
	{
		return view('user/activity');
	}

	public function userList()
	{
		$users = User::all();

		$sites = Site::all();

		$users->map(function ($users) {

			$sites = Siteuser::Sites($users->id)->get();

			$sites->map(function ($site) {
				return $site;
			});

			$users['sites'] = $sites;
			return $users;
		});

		return view('user/list', compact('users', 'sites'));

	}
	public function update_sites($id, Request $request)
	{
		$user = User::where('id', $id)->first();
		Siteuser::where('user_id', $id)->delete();

		$switches = $request::all();
		unset($switches['_token']);
		unset($switches['action']);

		foreach ($switches as $switch) {
			$siteuser = new Siteuser;
			$siteuser->user_id = $id;
			$siteuser->site_id = $switch;
			$siteuser->save();
		}
		$sites = Siteuser::where('user_id', $id)
			->join('sites', 'site_user.site_id', '=', 'sites.id')
			->get();

		Mail::send('auth.emails.sitesupdated', ['user' => $user, 'sites'=>$sites], function($message) use ($user)
		{
			$message->from('webteam@hasla.org.uk', 'Webteam');
			$message->to($user->email, $user->name)->subject('The Bee Hub - Your site access have been updated.');
		});

		flash()->success('Sites have been updated for the staff member.');

		return redirect()->back();

	}
	public function resetpassword(){

		Auth::logout();

		return redirect('/password/reset');
	}

    public function resetUserTutorial()
	{
        if(true){
            $user = User::where('id', Auth::id())->first();
            $user->tutorial = '[]';

            $user->save();
			flash()->success('Tutorial has ben successfully reset.');
            return redirect()->back();
        } return redirect()->back();
	}
}
