<?php

namespace App\Http\Controllers\Api;

use Auth;
use File;
use Storage;
use Activity;
use App\Site;
use App\Type;
use App\User;
use App\Post;
use App\Staff;
use App\Group;
use ActivityGet;
use App\Category;
use App\Resource;
use App\Siteuser;
use App\Category_site;
use App\Http\Requests;
use App\Resourcedefault;
use App\Traits\ImageTraits;
use Illuminate\Http\Response;
use App\Traits\PermissionsTraits;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class ApiController extends Controller
{
    use ImageTraits;
    use PermissionsTraits;


    public function getUserSites()
    {
        $sites = Site::join('site_user', 'sites.id', '=', 'site_user.site_id')
            ->where('user_id', Auth::id())
            ->orderBy('sites.id', 'asc')
            ->get();

        return $sites;
    }
    public function getSite($site_id){
        if($this->checkSitePermission($site_id)){
            $site = Site::where('id', $site_id)
                ->first();

            return $site;
        } return null;
    }
    public function getSiteCategories($site_id)
    {
        if($this->checkSitePermission($site_id)){
            $categories = Category::join('category_site', 'categories.id', '=', 'category_site.category_id')
                ->where('site_id', $site_id)
                ->get();
            return $categories;
        } return null;
    }
    public function getCategoryLatestUpdates($site_id, $category_id, $howmany=10)
    {
        if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, $category_id)){
            $posts = Post::join('contents', 'posts.content_id', '=', 'contents.id')
                ->where('site_id', $site_id)
                ->where('category_id', $category_id)
                ->orderBy('contents.updated_at', 'desc')
                ->take($howmany)
                ->get();
            return $posts;
        } return null;
    }
    public function getCategoryTypes($site_id, $category_id)
    {
        if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, $category_id)){
            $types = Type::join('site_type', 'types.id', '=', 'site_type.type_id')
				->where('site_id', $site_id)
				->where('category_id', $category_id)
				->orderBy('name', 'asc')
				->get();
            return $types;
        } return null;
    }
    public function getGroupsWithStaff($site_id)
    {
        if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, 6)){
            $groups = Group::with('staff')
    			->where('site_id', $site_id)
    			->orderBy('order', 'asc')
    			->get();
            return $groups;
        } return null;
    }
    public function getMediaFiles($site_id)
    {
        if($this->checkSitePermission($site_id)){
            $media = Resourcedefault::where('site_id', $site_id)
		    	->get();
            return $media;
        } return null;
    }
    public function getResourceFiles($site_id, $post_id)
    {
        if($this->checkSitePermission($site_id)){
            $resources = Resource::where('post_id', $post_id)
    			->get();
            return $resources;
        } return null;
    }
    public function getActivityLog($user_id=null)
	{
        if(true){
            if(is_null($user_id)){
    			$latestActivities = ActivityGet::with('user')->latest()->get();
    		}
    		else $latestActivities = ActivityGet::with('user')->where('user_id', $user_id)->latest()->get();
            return $latestActivities;
        } return null;
	}
    public function getUserTutorialStatus()
	{
        if(true){
			$userTutorial = Auth::user()->tutorial;
            if($userTutorial==null) $userTutorial='null';
            return $userTutorial;
        } return false;
	}
    public function updateUserTutorialStatus($tutorial_id)
	{
        if(true){
            $user = User::where('id', Auth::id())->first();
            $userTutorial = $user->tutorial;
            $userTutorial = json_decode($userTutorial);
            if(empty($userTutorial)){
                $userTutorial = [];
            }
            if(!in_array($tutorial_id, $userTutorial))
            array_push($userTutorial, (int)$tutorial_id);
            $user->tutorial = json_encode($userTutorial);
            $user->save();
            return $user->tutorial;
        } return 'false';
	}
    public function stopUserTutorial()
	{
        if(true){
            $user = User::where('id', Auth::id())->first();
            $user->tutorial = 'false';

            $user->save();
            return $user->tutorial;
        } return 'false';
	}
    public function resetUserTutorial()
	{
        if(true){
            $user = User::where('id', Auth::id())->first();
            $user->tutorial = '[]';

            $user->save();
            return $user->tutorial;
        } return 'false';
	}
    public function storeImage(Request $request)
    {
        $site_id = $request::get('site_id');
        $category_id = $request::get('category_id');
        $post_id = $request::get('post_id');
        $file = $request::file('file');

        if($this->checkSitePermission($site_id) && $this->checkCategorySitePermission($site_id, $category_id)){

            $destinationPath = './uploads/posts/'.$site_id.'/'.$category_id.'/';

            if (count($file) && !is_null($file)) {

                if (!File::exists($destinationPath)) {
                    $new_folder = File::makeDirectory($destinationPath,0777,true);
                }
                $extension = $file->getClientOriginalExtension();
                $originalName=$file->getClientOriginalName();
                if(isImage($extension)){
                    $upload_success = $this->resizeAndSaveImage($file, $destinationPath.'/'. $originalName, 2000);
                }
                // if ($upload_success) {
                //     $resource = new Resource;
                //     $resource->filename = $originalName;
                //     $resource->post_id = $result;
                //     $resource->filesize = '1';
                //     $resource->extension = $extension;
                //     $resource->save();
                // }
                // Activity::log('Add resource to post: post_id="'.$post->id.'", resource_id="'.$resource->id.'", filename="'.$resource->filename.'".');
                return substr($destinationPath, 1).$originalName;

            }

        } return null;
    }

}
