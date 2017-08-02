<?php

namespace App\Http\Controllers;


use App\Site;
use Auth;
use File;
use App\User;
use App\Http\Requests;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
    public function sites()
    {
        Session::flush();

        $sites = Site::join('site_user', 'sites.id', '=', 'site_user.site_id')
            ->where('user_id', Auth::id())
            ->get();

        if (count($sites) > 1) {
            return view('home', compact('sites'));
        }

        return view('dashboard.sites', compact('sites'));
    }
    public function dashboard()
    {
        $sites = Site::join('site_user', 'sites.id', '=', 'site_user.site_id')
            ->where('user_id', Auth::id())
            ->get();

        if (count($sites) > 1) {
            return view('home', compact('sites'));
        }

        return view('dashboard.sites', compact('sites'));
    }
    public function videoUpload($site_id)
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



        return view('post3.videocreate', compact('site'));
    }
    public function videoUploadstore(Request $request, $site_id=null)
	{

		if(is_null($site_id)){
			$site_id = session()->get('site_id');
		};
		$files = $request::file('files');

		$destinationPath = './videos/oq/';

		if (count($files) && !is_null($files) && is_array($files) && !is_null($files[0])) {
            // dd('test');
			if (!File::exists($destinationPath)) {
				$new_folder = File::makeDirectory($destinationPath);
			}
			foreach ($files as $index => $file) {
				$extension = $file->getClientOriginalExtension();
				$originalName=$file->getClientOriginalName();
				$upload_success = $file->move($destinationPath, $originalName);

			}
		}

	    return redirect('video/upload/'. $site_id);


	}
}
