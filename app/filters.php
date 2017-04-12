<?php
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Redirect;
	
	/**
	 * APP filters to chekc if the user is logged into the system
	 *
	 * @author Fantastic Five
	 */
	Route::filter('isLogged', function () {
					
		if ( !Auth::check()	) {
			return Redirect::route('login');
		}
	
	});
	
	/**
	 * Checks if the user is logged into the system and if he has admin privilegies
	 *
	 * @author Fantastic Five
	 */
	Route::filter('isAdmin', function ()
	{
		if ( Auth::check() ) {
			
			$user = SystemUser::find(Auth::user()->id_user);
			
			if ( !$user->is_admin ) {
				return Redirect::route('login')->withErrors('You dont have permission to access this module.');
			}
		} 
	});
		
	/*************************************************************************
	 * Prevents SSL
	 * 
	 * @author Fantastic Five
	 */
	Route::filter('prevent.ssl', function () {
	    $request = Request::instance();
	    $request->setTrustedProxies([Request::server('REMOTE_ADDR')]);
	    if ($request->secure()) {
	        return Redirect::to(Request::getRequestUri(), 302, array(), false);
	    }
	});	
	
	/*
	 * |-------------------------------------------------------------------------- |
	 * Guest Filter
	 * |-------------------------------------------------------------------------- |
	 * | The "guest" filter is the counterpart of the authentication filters as | it
	 * simply checks that the current user is not logged in. A redirect | response
	 * will be issued if they are, which you may freely change. |
	 */
	
	Route::filter('guest', function ()
	{
		if (Auth::check()) {
			return Redirect::route('login');
		}
	});
	
	/*
	 * |-------------------------------------------------------------------------- |
	 * CSRF Protection Filter
	 * |-------------------------------------------------------------------------- |
	 * | The CSRF filter is responsible for protecting your application against |
	 * cross-site request forgery attacks. If this special token in a user | session
	 * does not match the one given in this request, we'll bail. |
	 */
	
	Route::filter('csrf', function ()
	{
		if (Session::token() != Input::get('_token')) {
			throw new Illuminate\Session\TokenMismatchException();
		}
	});
	
?>