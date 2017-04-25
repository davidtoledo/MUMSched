<?php

use MUMSched\Services\UserService;
use MUMSched\Services\StudentSectionService;

/**
 * User Section Controller
 *
 * @author Fantastic Five
 */
class UserSectionController extends BaseController {
		
	// Dados para a view
	var $data = [
		'title' => 'User',
		'userSpec' => NULL,
		'userSpecs' => []
	];

	var $rules = [
		'id_course' => [
			'required',
		],
	];

	var $niceNames = [
		'id_course' => 'course',
	];

	/**
	 * List User Courses
	 *
	 * @author Fantastic Five
	 */
	public function showList ($id_user) {
		
		// Getting Sections List from DB
		$ss = StudentSectionService::getSectionsByStudent($id_user);
	
				
		// Adding objects to the view context
		$this->data['ss'] = $ss;
				
		$this->data['user'] = SystemUser::find($id_user);
		
		// Redirecting to the view layer
		return View::make('admin.user.list-sections')->with($this->data);
	}
	
	/**
	 * Associate an User to a Course
	 *
	 * @author Fantastic Five
	 */
	public function create ($id_user) {
		
		$user = SystemUser::with('entry')->find($id_user);
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
				return View::make('admin.user.form-course')->with($this->data)
					->withErrors($validator->messages());
			}
			
			// Checks if association already exists
			$fs = UserService::getFacultyCourse($id_user, Input::get('id_course'));
			
			if ($fs) {
				return Redirect::route('admin.user.list-sections', [$user->id_user])
					->withErrors(['Association already exists.']);
			}
						
			// create
			$spec = self::populate();
			
			if ( $spec->save() ) {
				
				// success
				Session::flash('success', 'Successfully added.');
				return Redirect::route('admin.user.list-sections', [$user->id_user]);
			}
			
			return View::make('admin.user.form-sections')->with($this->data)
				->withErrors('Error while trying to add.');
		}

		return View::make('admin.user.form-sections')->with($this->data);
	}

	/**
	 * Delete entity
	 *
	 * @author Fantastic Five
	 */
	public function delete ($id) {

		$fs = FacultyCourse::find ($id);
		$ret = UserService::deleteFacultyCourse($id);
				
		if ($ret === TRUE) {	
			Session::flash('success', 'Successfully deleted.');
			return Redirect::route('admin.user.course.list', [$fs->id_faculty]);

		} else {
			return Redirect::route('admin.user.course.list', [$fs->id_faculty])
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
		
		$fc = is_null($id) ? new FacultyCourse() : FacultyCourse::find($id);
		
		if (!$fc) {
			return FALSE;
		}
		
		$fc->id_course = Input::get('id_course');
		$fc->id_faculty = Input::get('id_user');

		return $fc;
	}
	
	/**
	 * Add combo data
	 * 
	 * @author Fantastic Five
	 */
	private function addCombos() {
		
		// Selectbox
		//SystemUser::with('entry')->find($id_user);
						$section_list = \Section::with("course")
					  	     ->lists('id_section', 'id_section');
		//$section_list = Section::orderBy('name')->lists('name', 'id_course');
		
		$this->data['section_list'] = ['' => 'Select the sections'];
		$this->data['section_list'] += $section_list;
	} 	
	
}