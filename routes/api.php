<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});






Route::group(['middleware' => 'auth:api'], function () {
    Route::get('getuser', function(){
        dd(Auth::id());
    });

    Route::get('getUserSites', 'ApiController@getUserSites');
    Route::get('getSite/{site_id}', 'ApiController@getSite');
    Route::get('getSiteCategories/{site_id}', 'ApiController@getSiteCategories');
    Route::get('getCategoryLatestUpdates/{site_id}/{category_id}/{howmany?}', 'ApiController@getCategoryLatestUpdates');
    Route::get('getCategoryTypes/{site_id}/{category_id}', 'ApiController@getCategoryTypes');
    Route::get('getGroupsWithStaff/{site_id}', 'ApiController@getGroupsWithStaff');
    Route::get('getMediaFiles/{site_id}', 'ApiController@getMediaFiles');
    Route::get('getResourceFiles/{site_id}/{post_id}', 'ApiController@getResourceFiles');
    Route::get('getActivityLog/{user_id?}', 'ApiController@getActivityLog');
    Route::get('getUserTutorialStatus', 'ApiController@getUserTutorialStatus');
    Route::get('updateUserTutorialStatus/{tutorial_id}', 'ApiController@updateUserTutorialStatus');
    Route::get('stopUserTutorial', 'ApiController@stopUserTutorial');
    Route::get('resetUserTutorial', 'ApiController@resetUserTutorial');
    Route::post('storeImage', 'ApiController@storeImage');

});
