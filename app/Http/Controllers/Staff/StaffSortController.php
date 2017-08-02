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

class StaffSortController extends Controller
{
    use PermissionsTraits;

    public function __construct()
	{
		$this->middleware('auth');
	}

    public function sort($site_id)
    {
        if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 6)){

            session(['site_id' => $site_id]);

            if (is_null($site_id)) {
                $site = session()->get('site_id');
            } else {
                $site = Site::where('id', $site_id)
                    ->first();
            }
            $groups = Group::with('staff')
                ->where('site_id', $site_id)
                ->orderBy('order', 'asc')
                ->get();

            $userTutorial = json_decode(Auth::user()->tutorial);
            // dd($userTutorial);
            if($userTutorial===false){

                $enableSortTutorial = false;
                // dd('1');
            } else{
                if(in_array(8, $userTutorial)){
                    $enableSortTutorial = false;
                    // dd('2');
                } else {
                    $enableSortTutorial = true;
                    // dd('3');
                };

             };

            return view('staff/sort', compact('site', 'groups', 'enableSortTutorial'));

        } else return redirect('denied');
    }

    public function update(Request $request)
	{
        $site_id = session()->get('site_id');

        if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 6)){

            $groupOrder = $request::get('groupOrder');			// Get Group order value from the request
            $groupOrder = explode(",", str_replace("group_", "", $groupOrder[0]));			// Split Group order into array

            $sortOrder=[];		// Declare empty array to store sort order

            $groupIndex=1;		// Create sort index that will be used to assign order values

            foreach($groupOrder as $orderItem){
                $group = Group::where('id', $orderItem)
                    ->first();
                $group->order= $groupIndex;		// Give sort index a value of current index
                $group->save();

                $orderOfSingleGroupRaw = $request::get('staffOrderOfGroup'.$orderItem);		// Get raw sorting in staff ordering for the $orderItem
                if ($orderOfSingleGroupRaw[0]!="") {

                    $orderOfSingleGroup = explode(",", str_replace("sort_", "", $orderOfSingleGroupRaw[0]));		//Process Raw data to array
                    $sortOrder[$orderItem]=$orderOfSingleGroup;				//Assign each Sort Order item by it's key a single ordering
                } else {
                    $sortOrder[$orderItem]=null;			// I can't remember what it does
                }

                if (count($sortOrder[$orderItem])>0) {
                    $staffIndex=1;			// Each staff in the order gets increasing order id and a new group
                    foreach ($sortOrder[$orderItem] as $staffOrder) {
                        $staff = Staff::where('id', $staffOrder)
                            ->first();
                        $staff->group_id=$orderItem;
                        $staff->order=$staffIndex;
                        $staff->save();
                        $staffIndex++;
                    }
                }

                $groupIndex++;		//Increace sort index's value
            }

            flash()->success('Staff list have been successfully sorted.');

            return redirect()->back();

        } else return redirect('denied');
	}
}
