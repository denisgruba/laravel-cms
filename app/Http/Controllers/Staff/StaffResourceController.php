<?php

namespace App\Http\Controllers\Staff;

use Auth;
use File;
use Activity;
use App\Staff;
use App\Site;
use App\Group;
use Validator;
use App\Http\Requests;
use App\Traits\ImageTraits;
use League\Flysystem\Filesystem;
use App\Traits\PermissionsTraits;
use League\Flysystem\Adapter\Local;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class StaffResourceController extends Controller
{
	use ImageTraits;
	use PermissionsTraits;

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function create($site_id)
	{
		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 6)){

			if (is_null($site_id)) {
				$site = session()->get('site_id');
			} else {
				$site = Site::where('id', $site_id)
					->first();
			}
			session(['site_id' => $site_id]);

			$groups = Group::with('staff')
				->where('site_id', $site_id)
				->orderBy('order', 'asc')
				->get();

			return view('staff/create', compact('site', 'groups'));

		} else return redirect('denied');
	}

	public function edit($staff_id, $site_id)
	{
		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 6)){

			if (is_null($site_id)) {
				$site = session()->get('site_id');
			} else {
				$site = Site::where('id', $site_id)
					->first();
			}
			session(['site_id' => $site_id]);

			$groups = Group::with('staff')
				->where('site_id', $site_id)
				->orderBy('order', 'asc')
				->get();

			$staff = Staff::where('id', $staff_id)
				->first();

			return view('staff/edit', compact('site', 'groups', 'staff'));

		} else return redirect('denied');
	}

	public function duplicate($staff_id, $site_id)
	{
		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 6)){

			if (is_null($site_id)) {
				$site = session()->get('site_id');
			} else {
				$site = Site::where('id', $site_id)
					->first();
			}
			session(['site_id' => $site_id]);

			$oldstaff = Staff::where('site_id', $site_id)
				->where('id', $staff_id)
				->orderBy('order', 'asc')
				->first();

			$staff = new Staff;

			$maxstaff = Staff::where('site_id', $site_id)
				->where('group_id', $oldstaff->group_id)
				->orderBy('order', 'desc')
				->first();

			if(isset($maxstaff->order)){
				$staff->order = $maxstaff->order+1;
			} else {
				$staff->order = 1;
			}

			$staff->author_id = Auth::id();
			$staff->site_id = $oldstaff->site_id;
			$staff->group_id = $oldstaff->group_id;
			$staff->title = $oldstaff->title;
			$staff->name = $oldstaff->name;
			$staff->position = $oldstaff->position;
			$staff->bio = $oldstaff->bio;

			$staff->save();

			Activity::log('Duplicate staff: staff_id="'.$staff->id.'".');

			flash()->success('Staff member have been successfully duplicated.');

			return redirect()->back();

		} else return redirect('denied');
	}

	public function store($site_id, Request $request)
	{
		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 6)){

			if (is_null($site_id)) {
				$site_id = session()->get('site_id');
			} else {
				$site = Site::where('id', $site_id)
					->first();
			}
			session(['site_id' => $site_id]);

			$staff = new Staff;


			$maxstaff = Staff::where('site_id', $site_id)
				->where('group_id', $request::get('group'))
				->orderBy('order', 'desc')
				->first();
			if(isset($maxstaff->order)){
				$staff->order = $maxstaff->order+1;
			} else {
				$staff->order = 1;
			}

			$staff->author_id = Auth::id();
			$staff->site_id = session()->get('site_id');
			$staff->group_id = $request::get('group');
			$staff->title = $request::get('title');
			$staff->name = $request::get('name');
			$staff->position = $request::get('position');
			$staff->bio = $request::get('bio');

			if($request::get('email')=="" || $request::get('email')==null){
				$staff->email = null;
			} else{
				$staff->email = $request::get('email');
			}

			$staff->save();

			$result = $staff->id;

			$destinationPath = './uploads/staff/';

			$files = $request::file('files');

			if (count($files) && !is_null($files) && is_array($files) && !is_null($files[0])) {
				if (!File::exists($destinationPath . $result)) {
					$new_folder = File::makeDirectory($destinationPath . $result);
				}

				foreach ($files as $index => $file) {
					$upload_success = $this->resizeAndSaveImage($file, $destinationPath . $result.'/'. $staff->title.$staff->name.'.'.$file->getClientOriginalExtension(), 1200);
					// $upload_success = $file->move($destinationPath . $result, $file->getClientOriginalName());
					$extension = $file->getClientOriginalExtension();

					if ($upload_success) {
						$staff->photo=$staff->title.$staff->name.'.'.$file->getClientOriginalExtension();
					}

				}
			}

			$staff->save();

			Activity::log('Create staff: staff_id="'.$staff->id.'".');

			flash()->success('Staff member have been successfully created.');

			return redirect('staff/edit/'.$staff->id.'/'.$site_id);

		} else return redirect('denied');
	}

	public function update($staff_id, $site_id, Request $request)
	{
		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 6)){

			if (is_null($site_id)) {
				$site_id = session()->get('site_id');
			} else {
				$site = Site::where('id', $site_id)
					->first();
			}
			session(['site_id' => $site_id]);

			$staff = Staff::where('id', $staff_id)
				->first();

			$staff->group_id = $request::get('group');
			$staff->title = $request::get('title');
			$staff->name = $request::get('name');
			$staff->position = $request::get('position');
			if($request::get('email')=="" || $request::get('email')==null){
				$staff->email = null;
			} else{
				$staff->email = $request::get('email');
			}
			$staff->bio = $request::get('bio');

			$destinationPath = './uploads/staff/';

			$delete_files = $request::get('delete');

			if(!empty($delete_files)){
				foreach ($delete_files as $delete_file) {
					$location = new Local('../public/uploads', 0);
					$filesystem = new Filesystem($location);
					$server = \League\Glide\ServerFactory::create([
						'source' => $filesystem,
						'cache' => $filesystem,
						'source_path_prefix' => '',
						'cache_path_prefix' => '/.cache',
					]);
					$server->deleteCache('staff'.'/'. $staff->id . '/' . $staff->photo);
					File::delete($destinationPath .'/'. $staff->id . '/' . $staff->photo);
					$staff->photo=null;
					$staff->save();
				}
			}
			$files = $request::file('files');
			// dd($files);

			if (count($files) && !is_null($files) && is_array($files) && !is_null($files[0])) {
				// dd('I got here');

				$result = $staff->id;

				File::delete($destinationPath .'/'. $staff->id . '/' . $staff->photo);
				$staff->photo=null;

				$staff->save();

				if (!File::exists($destinationPath . $result)) {
					$new_folder = File::makeDirectory($destinationPath . $result);
				}

				foreach ($files as $index => $file) {
					$upload_success = $this->resizeAndSaveImage($file, $destinationPath . $result.'/'. $staff->title.$staff->name.'.'.$file->getClientOriginalExtension(), 1200);
					// $upload_success = $file->move($destinationPath . $result, $file->getClientOriginalName());
					$extension = $file->getClientOriginalExtension();

					if ($upload_success) {
						$staff->photo=$staff->title.$staff->name.'.'.$file->getClientOriginalExtension();
					}

				}
			}

			$staff->save();

			Activity::log('Update staff: staff_id="'.$staff->id.'".');

			flash()->success('Staff member have been successfully updated.');

			return redirect('staff/edit/'.$staff->id.'/'.$site_id);

		} else return redirect('denied');
	}

	public function delete($staff_id, $site_id)
	{
		if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 6)){

			if (is_null($site_id)) {
				$site = session()->get('site_id');
			} else {
				$site = Site::where('id', $site_id)
					->first();
			}
			session(['site_id' => $site_id]);

			$staff = Staff::where('site_id', $site_id)
				->where('id', $staff_id)
				->orderBy('order', 'asc')
				->first();

			Activity::log('Delete staff: staff_id="'.$staff->id.'".');

			$staff->delete();

			flash()->success('Staff member have been successfully removed.');

			return redirect()->back();

		} else return redirect('denied');
	}
}
