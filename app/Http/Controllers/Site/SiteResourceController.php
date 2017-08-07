<?php

namespace App\Http\Controllers\Site;

use DB;
use Auth;
use File;
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
use App\Category_site;
use App\Http\Requests;
use App\Traits\PermissionsTraits;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class SiteResourceController extends Controller
{
	use PermissionsTraits;

	public function __construct()
	{
		$this->middleware('auth');
	}
	public function create()
	{
		if(true){

			$categories = Category::all();

			return view('site.create',compact('categories'));

		} else return redirect('denied');
	}
	public function edit($site_id)
	{
		if($this->checkSitePermission($site_id)){

			$site = Site::where('id', $site_id)
				->first();

			$categories = Category::all();

			$category_site = Category_site::where('site_id', $site->id)
				->get();

			return view('site.edit',compact('site', 'categories', 'category_site'));

		} else return redirect('denied');
	}
	public function store(Request $request)
	{
		if(true){

			$validator = Validator::make(Request::all(), [
				'name' => 'required',
				'hex_color' => 'size:6',
			]);

			if ($validator->fails()) {
				flash()->error("We've encountered some problems!");
				return redirect('post/create/'.$category_id.'/'.session()->get('site_id'))
					->withErrors($validator)
					->withInput($request::all());
			}

			$site= new Site;

			$site->name = $request::get('name');
			$site->slug = $request::get('slug');
			$site->hex_color = $request::get('hexcolor');
			$site->url = $request::get('url');
			$site->logo = $request::get('logo');
			$site->trust = $request::get('trust');
			$site->dfe = $request::get('dfe');
			$site->ofsted_grade = $request::get('ofsted_grade');
			$site->joined = $request::get('joined');
			$site->principal = $request::get('principal');
			$site->email = $request::get('email');
			$site->telephone = $request::get('telephone');
			$site->postal = $request::get('postal');
			$site->map = $request::get('map');

			$site->save();

			foreach($request::get('checked') as $category => $value){
				$cs = new Category_site;
				$cs->site_id = $site->id;
				$cs->category_id = $category;
				$cs->save();
			}

			flash()->success('Site have been successfully created.');

			return redirect()->back();

		} else return redirect('denied');
	}
	public function update($site_id, Request $request)
	{
		if($this->checkSitePermission($site_id)){

			if (is_null($site_id)) {
				$site = session()->get('site_id');
			} else {
				$site = Site::where('id', $site_id)
					->first();
			}
			session(['site_id' => $site_id]);

			$site->name = $request::get('name');
			$site->slug = $request::get('slug');
			$site->hex_color = $request::get('hexcolor');
			$site->url = $request::get('url');
			$site->logo = $request::get('logo');
			$site->trust = $request::get('trust');
			$site->dfe = $request::get('dfe');
			$site->ofsted_grade = $request::get('ofsted_grade');
			$site->joined = $request::get('joined');
			$site->principal = $request::get('principal');
			$site->email = $request::get('email');
			$site->telephone = $request::get('telephone');
			$site->postal = $request::get('postal');
			$site->map = $request::get('map');

			$site->save();

			$category_site = Category_site::where('site_id', $site->id)->delete();

			foreach($request::get('checked') as $category => $value){
				$cs = new Category_site;
				$cs->site_id = $site->id;
				$cs->category_id = $category;
				$cs->save();
			}

			flash()->success('Site have been successfully updated.');

			return redirect()->back();

		} else return redirect('denied');

	}
}
