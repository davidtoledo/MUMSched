<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use MUMSched\Services\UserService;

/**
 * User Controller
 *
 * @author Fantastic Five
 */
class UserController extends BaseController {
		
	// View data
	var $data = [
		'user' => NULL,
		'users' => []
	];

	var $rules = [
		'first_name' => [
			'required',
			'max:45',
		],
		'last_name' => [
			'required',
			'max:45',
		],
		'username' => [
			'required',
			'max:45',
			'unique:system_user,username',
		],
		'password' => [
			'required',
			'max:45',
		],		
		'type' => [
			'required',
		],
		'is_admin' => [
			'required',
		],
	];

	var $niceNames = [
		'first_name' => 'first name',
		'last_name' => 'last name',
		'username' => 'user name',
		'perfil' => 'perfil do usuário',
		'is_admin' => 'is admin',
	];

	/**
	 * Show list
	 *
	 * @author Fantastic Five
	 */
	public function showList() {
					
		// Getting User List from DB
		$users = UserService::getUserList();
				
		// Adding objects to the view context
		$this->data['users'] = $users;
		
		// Redirecting to the view layer
		return View::make('admin.user.list-user', $this->data);
	}
	
	/**
	 * Creates a new entity
	 *
	 * @author Fantastic Five
	 */
	public function create() {
		
		// Add select data
		self::addCombos();
		
		if ( Request::isMethod('post') ) {
			
			// Validator
			parent::useCustomValidator();
			$post = Input::all();
			
			$validator = Validator::make($post, $this->rules);
			$validator->setAttributeNames($this->niceNames);
			
			if ( !$validator->passes() ) {
				
				// Armazena campos enviados
				Input::flash();
				
				return View::make('admin.user.form-user')
					->with($this->data)
					->withErrors($validator->messages()
				);
			}
			
			// Register
			$user = self::populate();
			
			if ( $user->save() ) {
				
				// Success
				Session::flash('success', 'Successfully registered.');
				
				// Show view
				return Redirect::route('admin.user.edit', $user->id_user);
			}
			
			return View::make('admin.user.form-user')
				->with($this->data)
				->withErrors('An error occurred while trying to register.')
			;
		}
		
		return View::make('admin.user.form-user')->with($this->data);
	}
	
	/**
	 * Edit entity
	 *
	 * @author Fantastic Five
	 */
	public function edit ($id) {
		
		// Getting User from DB
		$user = UserService::getUserByID($id);
		
		if ( !$user ) {
			return Redirect::route('admin.user.list')->withErrors('User not found.');
		}
		
		// Add select data
		self::addCombos();
					
		
		// Adding data in the view context
		$this->data['user'] = & $user;
		
		if ( Request::isMethod('post') ) {
						
			// Validator
			parent::useCustomValidator();
			$post = Input::all();
						
			// Check if exists another user with the same username
			$check = UserService::getUserByUsername($post['username']);
			
			if ($check && $check->id_user == $user->id_user) {
				// Removes restriction
				unset ( $this->rules['username'] );
			}
			
			// validate
			$validator = Validator::make($post, $this->rules);
			$validator->setAttributeNames($this->niceNames);
			
			if ( !$validator->passes() ) {
				
				// Store fields
				Input::flash();
				
				return View::make('admin.user.form-user')
					->with($this->data)
					->withErrors($validator->messages()
				);
			}
			
			// Edit
			$user = self::populate($id);
			
			if ( $user->save() ) {
				
				Session::flash('success', 'Successfully edited.');
				
				// show view
				return Redirect::route('admin.user.edit', $user->id_user);
			}

			// show view
			return View::make('admin.user.form-user')->with($this->data)
				->withErrors('An error occurred while trying to edit.');
		}

		// show view
		return View::make('admin.user.form-user')->with($this->data);
	}

	/**
	 * Delete Entity
	 *
	 * @author Fantastic Five
	 */
	public function delete ($id) {
				
		$return = UserService::deleteUser($id);
		
		if ($return === TRUE) {	
			Session::flash('success', 'Successfully removed.');
			return ( self::showList() );

		} else {
			return Redirect::route('admin.user.list')
				->withErrors(['An error occurred while trying to delete:', 
				$return->getMessage()]
			);
		}
	}	
	
	/**
	 * Add data in the select controls from the view layer
	 * 
	 * @author Fatastic Five
	 */
	private function addCombos() {
			
		$this->data['user_type_list'] = [
			'F' => 'Faculty',
			'S' => 'Student'
		];
		
	}
	
	/**
	 * Populate data according to the view fields
	 *
	 * @author Fantastic Five
	 */
	private function populate ($id = NULL) {
		
		$user = is_null ($id) ? new SystemUser() : UserService::getUserByID($id);
		
		if (!$user) {
			return FALSE;
		}
		
		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');
		$user->username = Input::get('username');
		$user->password = Input::get('password');
		$user->type = Input::get('type');
		$user->is_admin = Input::get('is_admin');
		
		return $user;
	}
	
}