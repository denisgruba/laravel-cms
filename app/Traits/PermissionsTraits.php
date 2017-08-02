<?php namespace App\Traits;

use Auth;
use Activity;
use App\Site;
use App\Type;
use App\User;
use App\Post;
use App\Staff;
use App\Group;
use App\Category;
use App\Resource;
use App\Siteuser;
use App\Category_site;
use App\Http\Requests;
use App\Resourcedefault;

trait PermissionsTraits
{
    public function checkSitePermission($site_id)
    {
        $usersites = Siteuser::where('user_id', Auth::id())
            ->where('site_id', $site_id)
            ->get();
        if(count($usersites)) return true;
            Activity::log('Attempted access to site. Access denied: site_id="'.$site_id.'", url="'.url()->full().'".');
        return false;
    }
    public function checkCategorySitePermission($site_id, $category_id)
    {
        $categorysites = Category_site::where('category_id', $category_id)
            ->where('site_id', $site_id)
            ->get();
        if(count($categorysites)) return true;
            Activity::log('Attempted access to category. Access denied: site_id="'.$site_id.'", category_id="'.$category_id.'" url="'.url()->full().'".');
        return false;
    }
}
