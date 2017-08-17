<?php

namespace App\Http\Controllers\Media;

use File;
use Session;
use Activity;
use App\Site;
use Validator;
use App\Http\Requests;
use App\Resourcedefault;
use App\Traits\ImageTraits;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class MediaController extends Controller
{
    use ImageTraits;
    public function __construct()
	{
		$this->middleware('auth');
	}

    public function listMedia($site_id=null)
    {
        if (is_null($site_id)) {
			$site_id = session()->get('site_id');
			$site = Site::where('id', $site_id)
				->first();
		} else {
			$site = Site::where('id', $site_id)
				->first();
			session(['site_id' => $site_id]);
		}

        $media = Resourcedefault::where('site_id', $site_id)
			->get();

        return view('media/list', compact('site', 'media'));
    }
    public function update($site_id=null, Request $request)
    {
        if (is_null($site_id)) {
            $site_id = session()->get('site_id');
            $site = Site::where('id', $site_id)
                ->first();
        } else {
            $site = Site::where('id', $site_id)
                ->first();
            session(['site_id' => $site_id]);
        }

        $files = $request::file('files');

        $destinationPath = './uploads/default/'.$site->id.'/';

        $delete_files = $request::get('delete');
        if (!empty($delete_files)) {
            foreach ($delete_files as $delete_file) {
                $filename = Resourcedefault::where('id', $delete_file)->first();
                $resource = Resourcedefault::find($delete_file);

                Activity::log('Remove media: resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');

                $resource->delete();

                $location = new Local('../public/uploads/default'.$site->id, 0);
                $filesystem = new Filesystem($location);
                $server = \League\Glide\ServerFactory::create([
                    'source' => $filesystem,
                    'cache' => $filesystem,
                    'source_path_prefix' => '',
                    'cache_path_prefix' => '/.cache',
                ]);
                $server->deleteCache($filename->filename);

                File::delete($destinationPath . $filename->filename);

            }
        }

        if (count($files) && !is_null($files) && is_array($files) && !is_null($files[0])) {
            if (!File::exists($destinationPath)) {
                $new_folder = File::makeDirectory($destinationPath);
            }
            foreach ($files as $index => $file) {
                $extension = $file->getClientOriginalExtension();
                $originalName=$file->getClientOriginalName();
                if(isImage($extension)){
                    $upload_success = $this->resizeAndSaveImage($file, $destinationPath.'/'. $originalName, 2000);
                } else{
                    $upload_success = $file->move($destinationPath, $originalName);
                }
                if ($upload_success) {
                    $resource = new Resourcedefault;
                    $resource->filename = $originalName;
                    $resource->site_id = $site->id;
                    $resource->extension = $extension;
                    $resource->save();
                }
                Activity::log('Add media: resource_default_id="'.$resource->id.'", filename="'.$resource->filename.'".');
            }
        }

        flash()->success('Images were successfully updated.');

        return redirect()->back();
    }
}
