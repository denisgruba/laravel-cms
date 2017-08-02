<?php

namespace App\Http\Controllers\Dashboard;

use Auth;
use Activity;
use App\Site;
use App\Type;
use App\User;
use App\Siteuser;
use App\Category;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Traits\PermissionsTraits;
use App\Http\Controllers\Controller;
use App\Providers\AppServiceProvider;

class DashboardController extends Controller
{
    use PermissionsTraits;

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function sites()
    {
        $categories = Category::join('category_site', 'categories.id', '=', 'category_site.category_id')
            ->get();

        $sites = Site::join('site_user', 'sites.id', '=', 'site_user.site_id')
            ->where('user_id', Auth::id())
            ->orderBy('sites.id', 'asc')
            ->get();


        if (count($sites) > 1) {
            return view('dashboard3.sites', compact('sites', 'categories'));

        } else if(count($sites) == 0) {
        	return view('dashboard3.nosites');
		} {
            $site = $sites->first();

            session(['site_id' => $site->id]);

            $categories = Category::join('category_site', 'categories.id', '=', 'category_site.category_id')
                ->where('site_id', $site->id)
                ->get();
                
            $siteusers = User::join('site_user', 'users.id', '=', 'site_user.user_id')
                // ->join('posts', 'users.id', '=', 'posts.user_id')
                ->where('site_user.site_id', $site->id)
                ->withCount(['posts' => function ($query ) use ($site) {
                    $query->where('site_id', '=', $site->id);
                }])->get();

            return view('dashboard3.site', compact('site', 'categories', 'siteusers'));
        }
    }

    public function category($site_id)
    {
        if($this->checkSitePermission($site_id)){

            session(['site_id' => $site_id]);

            $categories = Category::join('category_site', 'categories.id', '=', 'category_site.category_id')
                ->where('site_id', $site_id)
                ->get();

            $site = Site::where('id', $site_id)
                ->first();

            $siteusers = User::join('site_user', 'users.id', '=', 'site_user.user_id')
                // ->join('posts', 'users.id', '=', 'posts.user_id')
                ->where('site_user.site_id', $site->id)
                ->withCount(['posts' => function ($query ) use ($site_id) {
                    $query->where('site_id', '=', $site_id);
                }])->get();

                // dd($siteusers);

            return view('dashboard3.site', compact('site', 'categories', 'siteusers'));

        } else return redirect('denied');

    }

}
