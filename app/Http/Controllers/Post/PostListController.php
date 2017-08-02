<?php

namespace App\Http\Controllers\Post;

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
use League\Flysystem\Filesystem;
use App\Traits\PermissionsTraits;
use League\Flysystem\Adapter\Local;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\HelpersController;

class PostListController extends Controller
{
	use PermissionsTraits;

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function listposts($category_id, $site_id)
	{
		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, $category_id)){
			if (is_null($site_id)) {
				$site = session()->get('site_id');
			} else {
				$site = Site::where('id', $site_id)
					->first();
			}

			$category = Category::where('id', $category_id)
				->first();

			$posts = Post::select('posts.id', 'contents.post_id', 'contents.title', 'users.name', 'types.label', 'types.id as type_id', 'contents.start', 'contents.end', 'posts.pinned', 'posts.pinned_trust', 'posts.times_viewed as viewed')
				->join('contents', 'posts.id', '=', 'contents.post_id')
				->join('users', 'posts.user_id', '=', 'users.id')
				->join('types', 'posts.type_id', '=', 'types.id')
				->where('site_id', session()->get('site_id'))
				->where('posts.category_id', $category_id)
				->orderBy('start', 'desc')
				->paginate(15);

			return view('post3.list', compact('posts', 'category', 'site'));
		} else return redirect('denied');

	}
	public function delete($post_id)
	{
		$post = Post::find($post_id);

		if($this->checkSitePermission($post->site_id) && $this->checkCategorySitePermission($post->site_id, $post->category_id)){
			$delete_files = Resource::where('post_id', $post->id)->get();
			if($post->category_id == 5){
				$destinationPath = './doc-uploads/';
				foreach ($delete_files as $delete_file) {
					$filename = Resource::where('id', $delete_file->id)->first();
					$resource = Resource::find($delete_file->id);
					Activity::log('Remove document from post: post_id="'.$post->id.'", resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');
					$resource->delete();
					File::delete($destinationPath . $post_id . '-' . $filename->filename);
				}
			} else {
				$destinationPath = './uploads/';
				foreach ($delete_files as $delete_file) {
					$filename = Resource::where('id', $delete_file->id)->first();
					$resource = Resource::find($delete_file->id);
					$location = new Local('../public/uploads', 0);
					$filesystem = new Filesystem($location);
					$server = \League\Glide\ServerFactory::create([
						'source' => $filesystem,
						'cache' => $filesystem,
						'source_path_prefix' => '',
						'cache_path_prefix' => '/.cache',
					]);

					$server->deleteCache($post_id . '/' . $filename->filename);
					Activity::log('Remove document from post: post_id="'.$post->id.'", resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');
					$resource->delete();
					File::delete($destinationPath . $post_id . '/' . $filename->filename);
				}
			}

			Activity::log('Delete post: post_id="'.$post->id.'".');
			$post->delete();

			flash()->success('Post have been successfully removed.');

			return redirect()->back();

		} else return redirect('denied');
	}
	public function pin($post_id)
	{
		$post = Post::find($post_id);

		if($this->checkSitePermission($post->site_id) && $this->checkCategorySitePermission($post->site_id, $post->category_id)){

			$post->pinned = '1';

			Activity::log('Pin post: post_id="'.$post->id.'".');

			$post->save();

			flash()->success('Post have been successfully pinned.');

			return redirect()->back();

		} else return redirect('denied');
	}

	public function unpin($post_id)
	{
		$post = Post::find($post_id);

		if($this->checkSitePermission($post->site_id) && $this->checkCategorySitePermission($post->site_id, $post->category_id)){

			$post->pinned = null;

			Activity::log('Unpin post: post_id="'.$post->id.'".');

			$post->save();

			flash()->success('Post have been successfully unpinned.');

			return redirect()->back();

		} else return redirect('denied');
	}
	public function pinTrust($post_id)
	{
		$post = Post::find($post_id);

		if($this->checkSitePermission($post->site_id) && $this->checkCategorySitePermission($post->site_id, $post->category_id)){

			$post->pinned_trust = '1';

			Activity::log('Pin trust post: post_id="'.$post->id.'".');

			$post->save();

			flash()->success('Post have been successfully pinned to the trust website.');

			return redirect()->back();

		} else return redirect('denied');
	}

	public function unpinTrust($post_id)
	{
		$post = Post::find($post_id);

		if($this->checkSitePermission($post->site_id) && $this->checkCategorySitePermission($post->site_id, $post->category_id)){

			$post->pinned_trust = null;

			Activity::log('Unpin trust post: post_id="'.$post->id.'".');

			$post->save();

			flash()->success('Post have been successfully unpinned from the trust website.');

			return redirect()->back();

		} else return redirect('denied');
	}
}
