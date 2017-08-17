<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::group(['namespace'=>'Site'], function(){
    Route::get('site/create', 'SiteResourceController@create');
    Route::post('site/store', 'SiteResourceController@store');
    Route::get('site/edit/{site_id?}', 'SiteResourceController@edit');
    Route::post('site/update/{site_id?}', 'SiteResourceController@update');
});

Route::group(['namespace'=>'Dashboard'], function(){
    Route::get('/', 'DashboardController@sites');
    Route::get('home', 'DashboardController@sites');
    Route::get('site', 'DashboardController@sites');
    Route::get('site/{site_id}', 'DashboardController@category');
    Route::get('categories/{site_id}', 'DashboardController@category');
});

Route::group(['namespace'=>'Post'], function(){
    Route::get('post/list/{category_id}/{site_id}', 'PostListController@listposts');
    Route::get('post/delete/{post_id}','PostListController@delete');
    Route::get('post/pin/{post_id}', 'PostListController@pin');
    Route::get('post/unpin/{post_id}', 'PostListController@unpin');
    Route::get('post/pin-trust/{post_id}', 'PostListController@pinTrust');
    Route::get('post/unpin-trust/{post_id}', 'PostListController@unpinTrust');

    Route::get('post/create/{category_id}/{site_id}/{type_id?}', 'PostResourceController@create');
    Route::get('post/date/{category_id}/{site_id}/{type_id?}', 'PostResourceController@date');
    Route::get('post/edit/{post_id}/{site_id}', 'PostResourceController@edit');
    Route::post('post/store/{category_id?}/{site_id?}', 'PostResourceController@store');
    Route::post('post/update/{post_id}', 'PostResourceController@update');

    Route::get('post/type/{category_id}/{site_id}','PostTypeController@type');
    Route::get('post/type_list/{category_id}/{type_id}/{site_id}','PostTypeController@typelist');
    Route::post('post/storetype/{category_id}', 'PostTypeController@store');
});

Route::group(['namespace'=>'Vacancy'], function(){
    Route::get('vacancy/list/{site_id}', 'VacancyListController@listRoles');
    Route::get('vacancy/delete/{site_id}/{post_id}','VacancyListController@delete');
    // Route::get('post/pin/{post_id}', 'PostListController@pin');
    // Route::get('post/unpin/{post_id}', 'PostListController@unpin');
    // Route::get('post/pin-trust/{post_id}', 'PostListController@pinTrust');
    // Route::get('post/unpin-trust/{post_id}', 'PostListController@unpinTrust');

    Route::get('vacancy/create/{site_id}/{type_id?}', 'VacancyResourceController@create');
    Route::get('vacancy/edit/{post_id}/{site_id}', 'VacancyResourceController@edit');
    Route::post('vacancy/store/{category_id?}/{site_id?}', 'VacancyResourceController@store');
    Route::post('vacancy/update/{post_id}/{site_id}', 'VacancyResourceController@update');

    Route::get('vacancy/role/{site_id}','VacancyRoleController@role');
    Route::get('vacancy/role_list/{role_id}/{site_id}','VacancyRoleController@rolelist');
    // Route::post('post/storetype/{category_id}', 'PostTypeController@store');
});

Route::group(['namespace'=>'Blocks'], function(){
    Route::get('blocks/create/{site_id}', 'BlocksResourceController@create');
});

Route::group(['namespace'=>'Staff'], function(){
    Route::get('staff/group/delete/{group_id}/{site_id}', 'StaffGroupController@delete');
    Route::get('staff/group/{site_id}', 'StaffGroupController@listgroups');
    Route::post('staff/group/create/{site_id}', 'StaffGroupController@create');
    Route::post('staff/group/rename/{group_id}/{site_id}', 'StaffGroupController@rename');

    Route::get('staff/create/{site_id}', 'StaffResourceController@create');
    Route::get('staff/edit/{staff_id}/{site_id}', 'StaffResourceController@edit');
    Route::get('staff/delete/{staff_id}/{site_id}', 'StaffResourceController@delete');
    Route::get('staff/duplicate/{staff_id}/{site_id}', 'StaffResourceController@duplicate');
    Route::post('staff/store/{site_id}', 'StaffResourceController@store');
    Route::post('staff/update/{staff_id}/{site_id}', 'StaffResourceController@update');

    Route::get('staff/sort/{id}', 'StaffSortController@sort');
    Route::post('staff/sort', 'StaffSortController@update');
});

Route::group(['namespace'=>'User'], function(){
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::get('user/edit', 'UserController@edit');
    Route::get('user/list', 'UserController@userList');
    Route::get('user/password/reset', 'UserController@resetpassword');
    Route::post('user/edit/sites/{id}', 'UserController@update_sites');
    Route::post('user/update', 'UserController@userUpdate');
    Route::get('user/activity/{user_id?}', 'UserController@getActivityLog');
    Route::get('user/tutorial/reset', 'UserController@resetUserTutorial');
});

Route::group(['namespace'=>'Media'], function(){
    Route::get('media/list/{site_id}', 'MediaController@listMedia');
    Route::post('media/update/{site_id}', 'MediaController@update');
});

Route::get('denied', function(){ return view('auth.accessDenied'); });

Route::post('convertnow', 'ImageController@convert');
Route::get('convertclear', 'ImageController@convertclear');
Route::get('convert', 'ImageController@convertview');
Route::get('getinfo', 'HelpersController@getinfo');
Route::get('video/upload/{site_id}', 'HomeController@videoUpload');
Route::post('video/store', 'HomeController@videoUploadstore');

Route::get('img/{path}', function (League\Glide\Server $server, $path) {
    $server->outputImage($path, $_GET);
})->where('path', '.+');

Route::get('clear/{path}', function (League\Glide\Server $server, $path) {
    $server->deleteCache($path);
    return redirect()->back();
})->where('path', '.+');

Route::group(['middleware' => 'api', 'namespace'=> 'Api'], function(){
    Route::get('api/getUserSites', 'ApiController@getUserSites');
    Route::get('api/getSite/{site_id}', 'ApiController@getSite');
    Route::get('api/getSiteCategories/{site_id}', 'ApiController@getSiteCategories');
    Route::get('api/getCategoryLatestUpdates/{site_id}/{category_id}/{howmany?}', 'ApiController@getCategoryLatestUpdates');
    Route::get('api/getCategoryTypes/{site_id}/{category_id}', 'ApiController@getCategoryTypes');
    Route::get('api/getGroupsWithStaff/{site_id}', 'ApiController@getGroupsWithStaff');
    Route::get('api/getMediaFiles/{site_id}', 'ApiController@getMediaFiles');
    Route::get('api/getResourceFiles/{site_id}/{post_id}', 'ApiController@getResourceFiles');
    Route::get('api/getActivityLog/{user_id?}', 'ApiController@getActivityLog');
    Route::get('api/getUserTutorialStatus', 'ApiController@getUserTutorialStatus');
    Route::get('api/updateUserTutorialStatus/{tutorial_id}', 'ApiController@updateUserTutorialStatus');
    Route::get('api/stopUserTutorial', 'ApiController@stopUserTutorial');
    Route::get('api/resetUserTutorial', 'ApiController@resetUserTutorial');
    Route::post('api/storeImage', 'ApiController@storeImage');
});
