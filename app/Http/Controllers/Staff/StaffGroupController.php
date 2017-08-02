<?php

namespace App\Http\Controllers\Staff;

use Auth;
use File;
use App\Staff;
use App\Site;
use App\Group;
use Validator;
use App\Http\Requests;
use App\Traits\PermissionsTraits;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class StaffGroupController extends Controller
{
    use PermissionsTraits;

    public function __construct()
	{
		$this->middleware('auth');
	}

    public function create($site_id, Request $request)
    {
        if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 6)){

            if (is_null($site_id)) {
                $site = session()->get('site_id');
            } else {
                $site = Site::where('id', $site_id)
                    ->first();
            }
            session(['site_id' => $site_id]);

            $group = new Group;

            $maxgroup = Group::where('site_id', $site_id)
                ->orderBy('order', 'desc')
                ->first();
            if(isset($maxgroup->order)){
                $group->order = $maxgroup->order+1;
            } else {
                $group->order = 1;
            }

            $group->name = $request::get('group');
            $group->site_id = $site_id;
            $group->author_id = Auth::id();

            $group->save();

            flash()->success('Staff group have been succesfully added.');

            return redirect()->back();

        } else return redirect('denied');
    }

    public function rename($group_id, $site_id, Request $request)
    {
        if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 6)){

            if (is_null($site_id)) {
                $site = session()->get('site_id');
            } else {
                $site = Site::where('id', $site_id)
                    ->first();
            }
            session(['site_id' => $site_id]);

            $group = Group::where('site_id', $site_id)
                ->where('id', $group_id)
                ->first();

            $group->name = $request::get('group');

            $group->save();

            flash()->success('Staff group have been successfully renamed.');

            return redirect()->back();

        } else return redirect('denied');
    }

    public function delete($group_id, $site_id)
    {
        if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 6)){

            if (is_null($site_id)) {
                $site = session()->get('site_id');
            } else {
                $site = Site::where('id', $site_id)
                    ->first();
            }
            session(['site_id' => $site_id]);

            $group = Group::where('site_id', $site_id)
                ->where('id', $group_id)
                ->first();

            $group->delete();

            flash()->success('Staff group have been successfully removed.');

            return redirect()->back();

        } else return redirect('denied');
    }

    public function listgroups($site_id)
    {
        if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 6)){
            
            if (is_null($site_id)) {
                $site = session()->get('site_id');
            } else {
                $site = Site::where('id', $site_id)
                    ->first();
            }
            session(['site_id' => $site_id]);

            $groups = Group::where('site_id', $site_id)
                ->orderBy('order', 'asc')
                ->get();

            return view('staff/group', compact('site', 'groups'));

        } else return redirect('denied');
    }
}
