<?php

use MUMSched\Utils\AppUtil;
use MUMSched\Services\UserService;

/**
 * Login Controller
 *
 * @author Fantastic Five
 */
class LoginController extends BaseController {

	/**
	 * Initial page
	 *
	 * @author Fantastic Five
	 */
	public function start() {
		
		// Redirects to the login page
		return View::make('login');
	}
	
	/**
	 * User login
	 *
	 * @author Fantastic Five
	 */
	public function login() {
		
		$validator = Validator::make(Input::all(), array(
			'username' => 'required',
			'password' => 'required'
		));
		
		if ($validator->passes()) {
			
			$login = Input::get('username');
			$passwd = Input::get('password');
			
			$user = UserService::getUserByLogin($login, $passwd);
			
			if ($user) {
				Auth::login ($user);
				
				if ($user->is_admin) {
					return \Redirect::route('admin.home.home');
				} else {
					return \Redirect::route('admin.user.edit', $user->id_user);
				}
				
			}								 
		} 
		 
		return Redirect::route('login')->withErrors('Invalid user name or password!');	
	}

	/**
	 * Direct link to the view layer (For prototype building purposes)
	 *
	 * @author Fantastic Five
	 */	
	public function link($params) {
		return View::make($params);
	}
	
	/**
	 * Home page
	 *
	 * @author Fantastic Five
	 */
	public function home() {
		
		// Redirects to the home page
		return View::make('admin.home');
	}
			
}