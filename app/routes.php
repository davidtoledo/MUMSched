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
		########### HOME ############
		
		Route::any('home/home', [
				'as' => 'admin.home.home',
				'uses' => 'LoginController@home',
		]);

		#############################
		########### USERS ###########
		
		Route::any('user/list', [
				'as' => 'admin.user.list',
				'uses' => 'UserController@showList',
		]);

		Route::any('user/create', [
				'as' => 'admin.user.create',
				'uses' => 'UserController@create',

		]);

		Route::any('user/edit/{id_user}', [
				'as' => 'admin.user.edit',
				'uses' => 'UserController@edit',
		]);
		
		Route::any('user/delete/{id_user}', [
				'as' => 'admin.user.delete',
				'uses' => 'UserController@delete',
		]);
		
		###############################################
		########## COURSE -> PREREQUISITE ############

		Route::any('course/prerequisite/list/{id_course}', [
				'as' => 'admin.course.prerequisite.list',
				'uses' => 'CoursePrereqController@showList',
		]);		
		
		Route::any('course/prerequisite/create/{id_course}', [
				'as' => 'admin.user.prerequisite.create',
				'uses' => 'CoursePrereqController@create',
		]);

		Route::any('course/prerequisite/delete/{id_fs}', [
				'as' => 'admin.user.prerequisite.delete',
				'uses' => 'CoursePrereqController@delete',
		]);
		
		
		
		###############################################
		########## USERS -> SPECIALIZATION ############

		Route::any('user/specialization/list/{id_user}', [
				'as' => 'admin.user.specialization.list',
				'uses' => 'UserSpecController@showList',
		]);		
		
		Route::any('user/specialization/create/{id_user}', [
				'as' => 'admin.user.specialization.create',
				'uses' => 'UserSpecController@create',
		]);

		Route::any('user/specialization/delete/{id_fs}', [
				'as' => 'admin.user.specialization.delete',
				'uses' => 'UserSpecController@delete',
		]);
		
		################################
		########### SCHEDULE ###########
		
		Route::any('schedule/list', [
				'as' => 'admin.schedule.list',
				'uses' => 'ScheduleController@showList',
				'before' => 'isAdmin'
		]);

		Route::any('schedule/create', [
				'as' => 'admin.schedule.create',
				'uses' => 'ScheduleController@create',
				'before' => 'isAdmin'
		]);

		Route::any('schedule/generate/{id_schedule}/{algorithm_type}/{block_order}', [
				'as' => 'admin.schedule.generate',
				'uses' => 'ScheduleController@generate',
				'before' => 'isAdmin'
		]);

		Route::any('schedule/edit/{id_schedule}', [
				'as' => 'admin.schedule.edit',
				'uses' => 'ScheduleController@edit',
				'before' => 'isAdmin'
		]);
		
		Route::any('schedule/delete/{id_schedule}', [
				'as' => 'admin.schedule.delete',
				'uses' => 'ScheduleController@delete',
				'before' => 'isAdmin'
		]);
		
		################################
		############# COURSE ###########
		
		Route::any('course/list', [
				'as' => 'admin.course.list',
				'uses' => 'CourseController@showList',
				'before' => 'isAdmin'
		]);

		Route::any('course/create', [
				'as' => 'admin.course.create',
				'uses' => 'CourseController@create',
				'before' => 'isAdmin'
		]);

		Route::any('course/edit/{id_entry}', [
				'as' => 'admin.course.edit',
				'uses' => 'CourseController@edit',
				'before' => 'isAdmin'
		]);
		
		Route::any('course/delete/{id_entry}', [
				'as' => 'admin.course.delete',
				'uses' => 'CourseController@delete',
				'before' => 'isAdmin'
		]);
		
		################################
		############# ENTRY ############
		
		Route::any('entry/list', [
				'as' => 'admin.entry.list',
				'uses' => 'EntryController@showList',
				'before' => 'isAdmin'
		]);

		Route::any('entry/create', [
				'as' => 'admin.entry.create',
				'uses' => 'EntryController@create',
				'before' => 'isAdmin'
		]);

		Route::any('entry/edit/{id_entry}', [
				'as' => 'admin.entry.edit',
				'uses' => 'EntryController@edit',
				'before' => 'isAdmin'
		]);
		
		Route::any('entry/delete/{id_en  	try}', [
				'as' => 'admin.entry.delete',
				'uses' => 'EntryController@delete',
				'before' => 'isAdmin'
		]);
		
		################################
		############# BLOCK ############
		
		Route::any('block/list', [
				'as' => 'admin.block.list',
				'uses' => 'BlockController@showList',
				'before' => 'isAdmin'
		]);

		Route::any('block/create', [
				'as' => 'admin.block.create',
				'uses' => 'BlockController@create',
				'before' => 'isAdmin'
		]);

		Route::any('block/edit/{id_block}', [
				'as' => 'admin.block.edit',
				'uses' => 'BlockController@edit',
				'before' => 'isAdmin'
		]);
		
		Route::any('block/delete/{id_block}', [
				'as' => 'admin.block.delete',
				'uses' => 'BlockController@delete',
				'before' => 'isAdmin'
		]);
		
		
		################################
		############# SECTION ############
		
		Route::any('section/list', [
				'as' => 'admin.section.list',
				'uses' => 'SectionController@showList',
				'before' => 'isAdmin'
		]);

		Route::any('section/create', [
				'as' => 'admin.section.create',
				'uses' => 'SectionController@create',
				'before' => 'isAdmin'
		]);

		Route::any('section/edit/{id_section}', [
				'as' => 'admin.section.edit',
				'uses' => 'SectionController@edit',
				'before' => 'isAdmin'
		]);
		
		Route::any('section/delete/{id_section}', [
				'as' => 'admin.section.delete',
				'uses' => 'SectionController@delete',
				'before' => 'isAdmin'
		]);
	});
	
	###################################
	######## SCHEDULE CALENDAR ########
	
	Route::group ( array ('prefix'=>'calendar' ), function() {

		##############################
		####### VIEW SCHEDULE ########

		Route::any('view/{id_schedule}/{id_user?}', [
				'as' => 'calendar.view',
				'uses' => 'ScheduleController@view'
		]);

	});

	#######################
	######## LOGOUT ########	
	Route::get('/logout', array('as'=>'logout', 'uses' => function() {
		Auth::logout();
		return Redirect::route('login');
	}));

?>