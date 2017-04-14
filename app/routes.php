<?php

	use Illuminate\Support\Facades\Redirect;
	
	/*
	|--------------------------------------------------------------------------
	| Application Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register all of the routes for an application.
	| It's a breeze. Simply tell Laravel the URIs it should respond to
	| and give it the Closure to execute when that URI is requested.
	|
	*/
		
	#################
	###### 404 ######
	App::error ( function ($exception, $code) {
		Log::error($code.': ' . Request::server('REQUEST_URI'));
		switch ($code) {
			case 403:
				return Redirect::route('404');
			case 404:
				return Redirect::route('404');
			case 500:
				if (! Config::get('app.debug')) {
					return Redirect::route('500');
				}
			default:
				if (! Config::get('app.debug')) {
					return Redirect::route('500');
				}
		}
	});
	
	## Basic Routes
	Route::any('/404', array('as' => '404', 'uses' => 'BaseController@error404'));
	Route::any('/error-500', array('as' => '500', 'uses' => 'BaseController@error500'));

	#######################
	######## LOGIN ########
	
	Route::any('/', array('as' => 'login', 'uses' => 'LoginController@start'));
	
	Route::group ( array ('prefix'=>'login'), function() {
		
		Route::post('auth', [
				'as' => 'auth',
				'uses' => 'LoginController@login'
		]);
		
	});
	
	##############################
	######## ADMIN LAYOUT ########
	
	Route::group ( array ('prefix'=>'admin', 'before' => 'isLogged'), function() {

		#############################
		########### USERS ###########
		
		Route::any('user/list', [
				'as' => 'admin.user.list',
				'uses' => 'UserController@showList',
				'before' => 'isAdmin'
		]);

		Route::any('user/create', [
				'as' => 'admin.user.create',
				'uses' => 'UserController@create',
				'before' => 'isAdmin'
		]);

		Route::any('user/edit/{id_user}', [
				'as' => 'admin.user.edit',
				'uses' => 'UserController@edit',
				'before' => 'isAdmin'
		]);
		
		Route::any('user/delete/{id_user}', [
				'as' => 'admin.user.delete',
				'uses' => 'UserController@delete',
				'before' => 'isAdmin'
		]);
		
		###############################################
		########## USERS -> SPECIALIZATION ############

		Route::any('user/specialization/list/{id_user}', [
				'as' => 'admin.user.specialization.list',
				'uses' => 'UserController@listSpecialization',
				'before' => 'isAdmin'
		]);		
		
		Route::any('user/specialization/create/{id_user}', [
				'as' => 'admin.user.specialization.create',
				'uses' => 'UserController@createSpecialization',
				'before' => 'isAdmin'
		]);

		Route::any('user/specialization/edit/{id_user}/{id_specialization}', [
				'as' => 'admin.user.specialization.edit',
				'uses' => 'UserController@editSpecialization',
				'before' => 'isAdmin'
		]);

		Route::any('user/specialization/delete/{id_specialization}', [
				'as' => 'admin.user.specialization.delete',
				'uses' => 'UserController@deleteSpecialization',
				'before' => 'isAdmin'
		]);		
		
	});
			
	#######################
	######## LOGOUT ########	
	Route::get('/logout', array('as'=>'logout', 'uses' => function() {
		Auth::logout();
		return Redirect::route('login');
	}));
	
?>