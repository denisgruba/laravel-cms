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

class VacancyResourceController extends Controller
{
    use DatabaseTraits;
    use PermissionsTraits;

    public function __construct()
	{
		$this->middleware('auth');
	}
    public function create( $site_id, $type_id=null)
	{
		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 9)){

			if (is_null($site_id)) {
				$site_id = session()->get('site_id');
				$site = Site::where('id', $site_id)
					->first();
			} else {
				$site = Site::where('id', $site_id)
					->first();
				session(['site_id' => $site_id]);
			}

			$types = Type::join('site_type', 'types.id', '=', 'site_type.type_id')
				->where('site_id', $site_id)
				->where('category_id', 9)
				->orderBy('name', 'asc')
				->get();

            $available_sites = Site::where('trust', 'HAT')
                ->orWhere('trust', 'UoBAT')
                ->orderBy('name', 'asc')
                ->get();

			return view('vacancy.create', compact('types', 'site', 'type_id' , 'available_sites'));

		} else return redirect('denied');
	}
    public function edit( $post_id, $site_id, $type_id=null)
	{
        $post = Post::join('contents', 'posts.id', '=', 'contents.post_id')
            ->where('posts.id', $post_id)
            ->first();

        if(is_null($post)){
			return redirect('site/'.$site_id);
		}

		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 9)){

			if (is_null($site_id)) {
				$site_id = session()->get('site_id');
				$site = Site::where('id', $site_id)
					->first();
			} else {
				$site = Site::where('id', $site_id)
					->first();
				session(['site_id' => $site_id]);
			}

			$types = Type::join('site_type', 'types.id', '=', 'site_type.type_id')
				->where('site_id', $site_id)
				->where('category_id', 9)
				->orderBy('name', 'asc')
				->get();

            $available_sites = Site::where('trust', 'HAT')
                ->orWhere('trust', 'UoBAT')
                ->orderBy('name', 'asc')
                ->get();

            $resources = Resource::where('post_id', $post_id)
				->get();


			return view('vacancy.edit', compact('post', 'types', 'resources', 'site', 'type_id', 'available_sites'));

		} else return redirect('denied');
	}
    public function store(Request $request, $site_id=null)
	{

		$category_id = 9;

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
				return redirect('vacancy/create/'.session()->get('site_id'))
					->withErrors($validator)
					->withInput($request::all());
			}

			$post = new Post;
			$post->user_id = Auth::id();
			$post->site_id = $request::get('site');
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

                $content->start = $this->parseDate(
                    $request::get('start_date'),
                    '00:00:00',
                    $request::get('enable_publish'),
                    $request::get('start_date') == '' ? true : false
                );

				$content->end = $this->parseDate(
					$request::get('end_date'),
					'23:00:00',
					true
				);

				$content->save();

				$content_id = $content->id;
				$post->content_id = $content_id;

				$post->save();

				$files = $request::file('files');


				$destinationPath = './uploads/';

				if (count($files) && !is_null($files) && is_array($files) && !is_null($files[0])) {

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
						Activity::log('Add resource to vacancy: post_id="'.$post->id.'", resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');
					}

				}
				Activity::log('Create vacancy: post_id="'.$post->id.'", content_id="'.$content_id.'", site_id="'.$post->site_id.'", type_id="'.$post->type_id.'".');

				flash()->success('Vacancy have been successfully created.');

				return redirect('vacancy/edit/' . $post->id . '/' . $site_id);

			}
		} else return redirect('denied');
	}
    public function update(Request $request, $post_id, $site_id)
	{
        if(is_null($site_id)){
			$site_id = session()->get('site_id');
		};

		$post = Post::where('id', $post_id)
			->first();

		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 9)){

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

                $content->start = $this->parseDate(
                    $request::get('start_date'),
                    '00:00:00',
                    $request::get('enable_publish'),
                    $request::get('start_date') == '' ? true : false
                );

				$content->end = $this->parseDate(
					$request::get('end_date'),
					'23:00:00',
					true
				);

				$content->save();
				$post->save();

				$destinationPath = './uploads/';


				$delete_files = $request::get('delete');
				if (!empty($delete_files)) {
					foreach ($delete_files as $delete_file) {
						$filename = Resource::where('id', $delete_file)->first();
						$resource = Resource::find($delete_file);
						Activity::log('Remove resource from vacancy: post_id="'.$post->id.'", resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');

						$resource->delete();

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
				$files = $request::file('files');
				if (count($files) && !is_null($files) && is_array($files) && !is_null($files[0])) {

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
						Activity::log('Add resource to vacancy: post_id="'.$post->id.'", resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');
					}

				}
				Activity::log('Update vacancy: post_id="'.$post->id.'", content_id="'.$post->content_id.'", site_id="'.$post->site_id.'", type_id="'.$post->type_id.'".');

				flash()->success('Vacancy have been successfully updated.');

				return redirect('vacancy/edit/' . $post->id . '/' . $site_id);

			} else return redirect('denied');
		}
	}
}
