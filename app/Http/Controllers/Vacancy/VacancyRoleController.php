<?php

namespace App\Http\Controllers\Vacancy;

use DB;
use Auth;
use File;
use Session;
use Storage;
use Activity;
use App\Post;
use App\Site;
use App\Type;
use Validator;
use App\Content;
use App\Category;
use App\Resource;
use Carbon\Carbon;
use App\Http\Requests;
use App\Traits\ImageTraits;
use App\Traits\DatabaseTraits;
use League\Flysystem\Filesystem;
use App\Traits\PermissionsTraits;
use League\Flysystem\Adapter\Local;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\HelpersController;

class VacancyRoleController extends Controller
{
    use PermissionsTraits;

    public function __construct()
	{
		$this->middleware('auth');
	}
    public function role($site_id)
	{
        $category_id = 9;

        if (is_null($site_id)) {
            $site = session()->get('site_id');
        } else {
            $site = Site::where('id', $site_id)
                ->first();
        }

		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, $category_id)){

			$roles = Type::join('site_type', 'types.id', '=', 'site_type.type_id')
				->where('site_type.site_id', session()->get('site_id'))
				->where('category_id', $category_id)
				->get();

			return view('vacancy.role', compact('roles', 'site'));

		} else return redirect('denied');
	}
    public function rolelist($role_id, $site_id)
	{

        $category_id = 9;
		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, $category_id)){

			if (is_null($site_id)) {
				$site = session()->get('site_id');
			} else {
				$site = Site::where('id', $site_id)
					->first();
			}

			$posts = Post::select('posts.id', 'contents.post_id', 'contents.title', 'users.name', 'types.label', 'types.id as type_id', 'sites.name as site_name', 'contents.start', 'contents.end', 'posts.pinned', 'posts.pinned_trust', 'posts.times_viewed as viewed')
				->join('contents', 'posts.id', '=', 'contents.post_id')
				->join('users', 'posts.user_id', '=', 'users.id')
				->join('types', 'posts.type_id', '=', 'types.id')
				->join('sites', 'posts.site_id', '=', 'sites.id')
				// ->where('site_id', session()->get('site_id'))
				->where('posts.category_id', $category_id)
                ->where('posts.type_id', $role_id)
				->orderBy('start', 'desc')
				->paginate(15);

			return view('vacancy.list', compact('posts', 'category', 'site'));

		} else return redirect('denied');
	}
}
