<?php

use MUMSched\Services\UserService;

/**
 * User Specialization Controller
 *
 * @author Fantastic Five
 */
class UserSpecController extends BaseController {
		
	// Dados para a view
	var $data = [
		'title' => 'User',
		'userSpec' => NULL,
		'userSpecs' => []
	];

	var $rules = [
		'id_specialization' => [
			'required',
		],
	];

	var $niceNames = [
		'id_specialization' => 'specialization',
	];

	/**
	 * List User Specializations
	 *
	 * @author Fantastic Five
	 */
	public function showList ($id_user) {
		
		$user = UserService::getUserWithSpecializations($id_user);
		if ( !$user || !Auth::user()->is_admin && Auth::user()->id_user != $id_user) {
			return Redirect::route('login')->withErrors('User does not exists.');
		}	

		$this->data['user'] = & $user;
		
		return View::make('admin.user.list-specialization')->with($this->data);
	}
	
	/**
	 * Associate an User to a Specialization
	 *
	 * @author Fantastic Five
	 */
	public function create ($id_user) {
		
		$user = SystemUser::with('specializations')->find($id_user);
		$this->data['user'] = & $user;
		
		// Add combo objects
		self::addCombos();
		
		if (Request::isMethod('post')) {
			
			// validator
			parent::useCustomValidator();
			$post = Input::all();
			
			$validator = Validator::make($post, $this->rules);
			$validator->setAttributeNames($this->niceNames);
			
			if ( !$validator->passes() ) {
				
				// store fields
				Input::flash();
				return View::make('admin.user.form-specialization')->with($this->data)
					->withErrors($validator->messages());
			}
			
			// Checks if association already exists
			$fs = UserService::getFacultySpecialization($id_user, Input::get('id_specialization'));
			
			if ($fs) {
				return Redirect::route('admin.user.specialization.list', [$user->id_user])
					->withErrors(['Association already exists.']);
			}
						
			// create
			$spec = self::populate();
			
			if ( $spec->save() ) {
				
				// success
				Session::flash('success', 'Successfully added.');
				return Redirect::route('admin.user.specialization.list', [$user->id_user]);
			}
			
			return View::make('admin.user.form-specialization')->with($this->data)
				->withErrors('Error while trying to add.');
		}

		return View::make('admin.user.form-specialization')->with($this->data);
	}

	/**
	 * Delete entity
	 *
	 * @author Fantastic Five
	 */
	public function delete ($id) {

		$fs = FacultySpecialization::find ($id);
		$ret = UserService::deleteFacultySpecialization($id);
				
		if ($ret === TRUE) {	
			Session::flash('success', 'Successfully deleted.');
			return Redirect::route('admin.user.specialization.list', [$fs->id_faculty]);

		} else {
			return Redirect::route('admin.user.specialization.list', [$fs->id_faculty])
				->withErrors(['An error occurred while trying to delete:', 
				$retorno->getMessage()]
			);
		}
	}
	
	/**
	 * Populate data from the view layer
	 *
	 * @author Fantastic Five
	 */
	private function populate ($id = NULL) {
		
		$fs = is_null($id) ? new FacultySpecialization() : FacultySpecialization::find($id);
		
		if (!$fs) {
			return FALSE;
		}
		
		$fs->id_specialization = Input::get('id_specialization');
		$fs->id_faculty = Input::get('id_user');

		return $fs;
	}
	
	/**
	 * Add combo data
	 * 
	 * @author Fantastic Five
	 */
	private function addCombos() {
		
		// Selectbox
		$specialization_list = Specialization::orderBy('specialization')
    										  ->lists('specialization', 'id_specialization');
		
		$this->data['specialization_list'] = ['' => 'Select a specialization area'];
		$this->data['specialization_list'] += $specialization_list;
	} 	
	
}