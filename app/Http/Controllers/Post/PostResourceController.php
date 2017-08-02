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
use App\Resourcedefault;
use App\Traits\ImageTraits;
use App\Traits\DatabaseTraits;
use League\Flysystem\Filesystem;
use App\Traits\PermissionsTraits;
use League\Flysystem\Adapter\Local;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\HelpersController;

class PostResourceController extends HelpersController
{
	use ImageTraits;
	use DatabaseTraits;
	use PermissionsTraits;

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function create($category_id, $site_id, $type_id=null)
	{
		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, $category_id)){

			session(['category_id' => $category_id]);

			if (is_null($site_id)) {
				$site_id = session()->get('site_id');
				$site = Site::where('id', $site_id)
					->first();
			} else {
				$site = Site::where('id', $site_id)
					->first();
				session(['site_id' => $site_id]);
			}

			$category = Category::where('id', $category_id)
				->first();

			$types = Type::join('site_type', 'types.id', '=', 'site_type.type_id')
				->where('site_id', $site_id)
				->where('category_id', $category_id)
				->orderBy('name', 'asc')
				->get();

			$media = Resourcedefault::where('site_id', $site_id)
				->get();

			return view('post3.create', compact('types', 'category', 'site', 'type_id', 'media'));

		} else return redirect('denied');
	}
	public function date($category_id, $site_id, $type_id=null)
	{
		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, $category_id)){

			session(['category_id' => $category_id]);

			if (is_null($site_id)) {
				$site_id = session()->get('site_id');
				$site = Site::where('id', $site_id)
					->first();
			} else {
				$site = Site::where('id', $site_id)
					->first();
				session(['site_id' => $site_id]);
			}

			$category = Category::where('id', $category_id)
				->first();

			$types = Type::join('site_type', 'types.id', '=', 'site_type.type_id')
				->where('site_id', $site_id)
				->where('category_id', $category_id)
				->orderBy('name', 'asc')
				->get();

			$media = Resourcedefault::where('site_id', $site_id)
				->get();

			return view('post3.date', compact('types', 'category', 'site', 'type_id', 'media'));

		} else return redirect('denied');
	}

	public function edit($post_id, $site_id)
	{
		$post = Post::join('contents', 'posts.id', '=', 'contents.post_id')
			->where('posts.id', $post_id)
			->first();

		if(is_null($post)){
			return redirect('site/'.$site_id);
		}

		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, $post->category_id)){

			if (is_null($site_id)) {
				$site_id = session()->get('site_id');
				$site = Site::where('id', $site_id)
					->first();
			} else {
				$site = Site::where('id', $site_id)
					->first();
				session(['site_id' => $site_id]);
			}

			$category = Category::where('id', $post->category_id)
				->first();

			session(['category_id' => $category->id]);

			$types = Type::join('site_type', 'types.id', '=', 'site_type.type_id')
				->where('site_id', $site_id)
				->where('category_id', $category->id)
				->orderBy('name', 'asc')
				->get();

			$resources = Resource::where('post_id', $post_id)
				->get();

			$media = Resourcedefault::where('site_id', $site_id)
				->get();

			return view('post3.edit', compact('post', 'category', 'resources', 'site', 'types', 'media'));

		} else return redirect('denied');
	}

	public function store(Request $request, $category_id=null, $site_id=null)
	{
		if(is_null($category_id)){
			$category_id = session()->get('category_id');
		};
		if(is_null($site_id)){
			$site_id = session()->get('site_id');
		};

		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, $category_id)){

			$validator = Validator::make(Request::all(), [
				'title' => 'required',
				'type' => 'required',
			]);

			if ($validator->fails()) {
				flash()->error("We've encountered some problems!");
				return redirect('post/create/'.$category_id.'/'.session()->get('site_id'))
					->withErrors($validator)
					->withInput($request::all());
			}
			$post = new Post;
			$post->user_id = Auth::id();
			$post->site_id = $site_id;
			$post->type_id = $request::get('type');
			$post->category_id = $category_id;
			if($request::get('post_pinned') == 'on'){
				$post->pinned = 1;
			}
			if($request::get('post_pinned_trust') == 'on'){
				$post->pinned_trust = 1;
			}
			$post->default_resource_id = $request::get('default');
			$post->thumbnail_style = $request::get('thumbnail_style');
			$post->save();
			$result = $post->id;

			if (count($result)) {

				$content = new Content;
				$content->post_id = $result;
				$content->title = $request::get('title');
				$content->contents = $request::get('content');
				$content->venue = $request::get('venue');

				if($category_id==2){
					$content->start = $this->parseDate(
						$request::get('start_date'),
						$request::get('enable_starttime') ? $request::get('start_time') : '00:00:00',
						true
					);
					$content->end = $this->parseDate(
						$request::get('end_date'),
						$request::get('enable_endtime') ? $request::get('end_time') : '23:00:00',
						true
					);
					$content->publish_at = $this->parseDate(
						$request::get('publish_date'),
						$request::get('publish_time'),
						$request::get('enable_publish')
					);
				} else {
					$content->start = $this->parseDate(
						$request::get('start_date'),
						$request::get('start_time'),
						$request::get('enable_publish'),
						$request::get('start_date') == '' && $request::get('start_time') == '' ? true : false
					);
					$content->end = $this->parseDate(
						$request::get('end_date'),
						$request::get('end_time'),
						$request::get('enable_expire')
					);
				}

				$content->save();

				$content_id = $content->id;
				$post->content_id = $content_id;

				$post->save();

				$files = $request::file('files');

				if($category_id==5){
					$destinationPath = './doc-uploads/';
				} else {
					$destinationPath = './uploads/';
				}
				if (count($files) && !is_null($files) && is_array($files) && !is_null($files[0])) {
					if($category_id == 5){
						foreach ($files as $index => $file) {
							$newFileName = $result . '-' . $file->getClientOriginalName();
							$upload_success = $file->move($destinationPath, $newFileName);
							$extension = $file->getClientOriginalExtension();
							if ($upload_success) {
								$resource = new Resource;
								$resource->filename = $file->getClientOriginalName();
								$resource->post_id = $result;
								$resource->filesize = 1;
								$resource->extension = $extension;
								$resource->save();

								if(isPDF($extension)){
									$conversionPath = './uploads/thumbs/'.basename($newFileName, '.'.$extension).'.jpg';
									$pdf = new \Spatie\PdfToImage\Pdf($destinationPath.$newFileName);
									$pdf->setOutputFormat('jpg')
										->resizeImage(200, 300)
										->saveImage($conversionPath);
								}
								Activity::log('Add document to post: post_id="'.$post->id.'", resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');
							}
						}
					} else{
						if (!File::exists($destinationPath . $result)) {
							$new_folder = File::makeDirectory($destinationPath . $result);
						}
						foreach ($files as $index => $file) {
							$extension = $file->getClientOriginalExtension();
							$originalName=$file->getClientOriginalName();
							if(isImage($extension)){
								$upload_success = $this->resizeAndSaveImage($file, $destinationPath . $result.'/'. $originalName, 2000);
							} else{
								$upload_success = $file->move($destinationPath . $result, $originalName);
							}
							if ($upload_success) {
								$resource = new Resource;
								$resource->filename = $originalName;
								$resource->post_id = $result;
								$resource->filesize = '1';
								$resource->extension = $extension;
								$resource->save();
							}
							Activity::log('Add resource to post: post_id="'.$post->id.'", resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');
						}
					}
				}
				Activity::log('Create post: post_id="'.$post->id.'", content_id="'.$content_id.'", category_id="'.$post->category_id.'", type_id="'.$post->type_id.'".');

				flash()->success('Post have been successfully created.');

				return redirect('post/edit/' . $post->id . '/' . $post->site_id);

			}
		} else return redirect('denied');
	}

	public function update($post_id, Request $request)
	{
		$post = Post::where('id', $post_id)
			->first();

		if($this->checkSitePermission($post->site_id) && $this->checkCategorySitePermission($post->site_id, $post->category_id)){

			$validator = Validator::make(Request::all(), [
				'title' => 'required',
				'type' => 'required',
			]);

			if ($validator->fails()) {
				flash()->error("We've encountered some problems!");
				return redirect()->back()
					->withErrors($validator)
					->withInput($request::all());
			}
			$category = session()->get('category_id');

			$content = Content::where('post_id', $post_id)
				->first();

			$result = $post->id;
			if(count($result)){
				$content->title = $request::get('title');
				$content->contents = $request::get('content');
				$content->venue = $request::get('venue');
				$post->type_id = $request::get('type');
				$post->default_resource_id = $request::get('default');
				$post->thumbnail_style = $request::get('thumbnail_style');
				if($request::get('post_pinned') == 'on'){
					$post->pinned = 1;
				} else $post->pinned = null;
				if($request::get('post_pinned_trust') == 'on'){
					$post->pinned_trust = 1;
				} else $post->pinned = null;
				if($category==2){
					$content->start = $this->parseDate(
						$request::get('start_date'),
						$request::get('enable_starttime') ? $request::get('start_time') : '00:00:00',
						true
					);
					$content->end = $this->parseDate(
						$request::get('end_date'),
						$request::get('enable_endtime') ? $request::get('end_time') : '23:00:00',
						true
					);
					$content->publish_at = $this->parseDate(
						$request::get('publish_date'),
						$request::get('publish_time'),
						$request::get('enable_publish')
					);
				} else {
					$content->start = $this->parseDate(
						$request::get('start_date'),
						$request::get('start_time'),
						$request::get('enable_publish'),
						$request::get('start_date') == '' && $request::get('start_time') == '' ? true : false
					);
					$content->end = $this->parseDate(
						$request::get('end_date'),
						$request::get('end_time'),
						$request::get('enable_expire')
					);
				}

				$content->save();
				$post->save();

				if (isset($_REQUEST['featured'])) {

					$featured_remove = Resource::where('post_id', $post_id)
					->update(['featured' => 0]);

					$featured_id = $request::get('featured');
					$featured = Resource::find($featured_id);
					$featured->featured = '1';
					$featured->save();
				}
				if (isset($_REQUEST['default'])) {

					$featured_remove = Resource::where('post_id', $post_id)
						->update(['featured' => 0]);
				}

				if($category==5){
					$destinationPath = './doc-uploads/';
				} else {
					$destinationPath = './uploads/';
				}

				$delete_files = $request::get('delete');
				if (!empty($delete_files)) {
					foreach ($delete_files as $delete_file) {
						$filename = Resource::where('id', $delete_file)->first();
						$resource = Resource::find($delete_file);
						if($category==5){
							Activity::log('Remove document from post: post_id="'.$post->id.'", resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');
						}else{
							Activity::log('Remove resource from post: post_id="'.$post->id.'", resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');
						}
						$resource->delete();
						if($category==5){
							File::delete($destinationPath . $post_id . '-' . $filename->filename);
						} else{
							$location = new Local('../public/uploads', 0);
							$filesystem = new Filesystem($location);
							$server = \League\Glide\ServerFactory::create([
								'source' => $filesystem,
								'cache' => $filesystem,
								'source_path_prefix' => '',
								'cache_path_prefix' => '/.cache',
							]);
							$server->deleteCache($post_id . '/' . $filename->filename);
							File::delete($destinationPath . $post_id . '/' . $filename->filename);
						}
					}
				}
				$files = $request::file('files');
				if (count($files) && !is_null($files) && is_array($files) && !is_null($files[0])) {
					if($category == 5){
						$delete_files = Resource::where('post_id', $post->id)->get();
						foreach ($delete_files as $delete_file) {
							$filename = Resource::where('id', $delete_file->id)->first();
							$resource = Resource::find($delete_file->id);
							Activity::log('Remove document from post: post_id="'.$post->id.'", resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');
							$resource->delete();
							File::delete($destinationPath . $post_id . '-' . $filename->filename);
						}
						foreach ($files as $index => $file) {
							$newFileName = $result . '-' . $file->getClientOriginalName();
							$upload_success = $file->move($destinationPath, $newFileName);
							$extension = $file->getClientOriginalExtension();
							if ($upload_success) {
								$resource = new Resource;
								$resource->filename = $file->getClientOriginalName();
								$resource->post_id = $result;
								$resource->filesize = 1;
								$resource->extension = $extension;
								$resource->save();

								if(isPDF($extension)){
									$conversionPath = './uploads/thumbs/'.basename($newFileName, '.'.$extension).'.jpg';
									$pdf = new \Spatie\PdfToImage\Pdf($destinationPath.$newFileName);
									$pdf->setOutputFormat('jpg')
										->resizeImage(200, 300)
										->saveImage($conversionPath);
								}
								Activity::log('Add document to post: post_id="'.$post->id.'", resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');
							}
						}
					} else{
						if (!File::exists($destinationPath . $result)) {
							$new_folder = File::makeDirectory($destinationPath . $result);
						}
						foreach ($files as $index => $file) {
							$extension = $file->getClientOriginalExtension();
							$originalName=$file->getClientOriginalName();
							if(isImage($extension)){
								$upload_success = $this->resizeAndSaveImage($file, $destinationPath . $result.'/'. $originalName, 2000);
							} else{
								$upload_success = $file->move($destinationPath . $result, $originalName);
							}
							if ($upload_success) {
								$resource = new Resource;
								$resource->filename = $originalName;
								$resource->post_id = $result;
								$resource->filesize = '1';
								$resource->extension = $extension;
								$resource->save();
							}
							Activity::log('Add resource to post: post_id="'.$post->id.'", resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');
						}
					}
				}
				Activity::log('Update post: post_id="'.$post->id.'", content_id="'.$post->content_id.'", category_id="'.$post->category_id.'", type_id="'.$post->type_id.'".');

				flash()->success('Post have been successfully updated.');

				return redirect('post/edit/' . $post->id . '/' . $post->site_id);

			} else return redirect('denied');
		}
	}
}
