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

//En API-REST entre mas corta sea la ruta es mejor asi que el tema de los prefix hay que omitirlos
//api routes prefix
Route::prefix('v1')->group(function(){
	//auth route
		Route::post('logins', 'Api\AuthControllers@logins');
		Route::post('registers', 'Api\AuthControllers@registers');
	//

	//api auth user middleware
		Route::group(['middleware' => 'auth:api'], function(){
			Route::post('getUser', 'Api\AuthControllers@getUser');
			Route::post('logout', 'Api\AuthControllers@logouts');
			//crud roles route
				Route::prefix('roles')->group(function(){
					Route::get('all', 'Api\RolesControllers@show');
					Route::post('create', 'Api\RolesControllers@store');
					Route::get('filter/{id}', 'Api\RolesControllers@filter');
					Route::delete('delete/{id}', 'Api\RolesControllers@delete');
					Route::put('update/{id}', 'Api\RolesControllers@update');
					Route::get('assing/{id}/{role}', 'Api\RolesControllers@assingRoles');
					Route::get('user/{id}', 'Api\RolesControllers@returnUserRoles');
					Route::get('user/revoke/{id}/{role}', 'Api\RolesControllers@revokeById');
					Route::get('user/revoke/byslug/{id}/{slug}', 'Api\RolesControllers@revokeBySlug');
				});
		});		
});

Route::apiResource('roles', 'ASanchez85\RoleController');