<?php

namespace App\Http\Controllers\Post;

use DB;
use Auth;
use File;
use Session;
use Storage;
use App\Post;
use App\Site;
use App\Type;
use Validator;
use App\Content;
use App\Category;
use App\Resource;
use Carbon\Carbon;
use App\Http\Requests;
use App\Traits\PermissionsTraits;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class PostTypeController extends Controller
{
	use PermissionsTraits;

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function typelist($category_id ,$type_id, $site_id)
	{
		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, $category_id)){

			if(is_null($site_id)){
				$site_id = session()->get('site_id');
				$site = Site::where('id', $site_id)
					->first();
			}
			else {
				$site = Site::where('id', $site_id)
					->first();
			}

			$posts = Post::select('posts.id', 'contents.post_id', 'contents.title', 'users.name', 'types.label', 'contents.start', 'contents.end', 'posts.pinned', 'posts.pinned_trust')
				->join('contents', 'posts.id', '=', 'contents.post_id')
				->join('users', 'posts.user_id', '=', 'users.id')
				->join('types', 'posts.type_id', '=', 'types.id')
				->where('site_id', $site->id)
				->where('posts.type_id', $type_id)
				->orderBy('start', 'desc')
				->paginate(15);

			$category = Category::where('id', $category_id)
				->first();

			$type = Type::where('id', $type_id)
				->first();

			return view('post3.type_list', compact('posts', 'site', 'category', 'type'));

		} else return redirect('denied');

	}

	public function type($category_id, $site_id)
	{
		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, $category_id)){

			if(is_null($site_id)){
				$site_id = session()->get('site_id');
				$site = Site::where('id', $site_id)
					->first();
			}
			else{
				$site = Site::where('id', $site_id)
					->first();
			}

			$category = Category::where('id', $category_id)
				->first();

			$types = Type::join('site_type', 'types.id', '=', 'site_type.type_id')
				->where('site_type.site_id', session()->get('site_id'))
				->where('category_id', $category_id)
				->get();

			return view('post3.type', compact('types', 'id', 'site', 'category'));

		} else return redirect('denied');
	}

	public function store(Request $request, $category_id)
	{
		$site_id = session()->get('site_id');

		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, $category_id)){

			$type = New Type;
			$type->name = $request::get('title');
			$type->label = $request::get('title');
			$type->category_id = $category_id;
			$type->save();

			$result = $type->id;

			if (count($result)) {
				DB::table('site_type')->insert(
					['type_id' => $result,
						'site_id' => $site_id]
				);
			}

			flash()->success('New type have been successfully added.');

			return redirect('post/type/' .$category_id.'/'.$site_id);

		} else return redirect('denied');
	}
}
