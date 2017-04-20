<?php

use MUMSched\Services\CourseService;

/**
 * Course Prerequisite Controller
 *
 * @author Fantastic Five
 */
class CoursePrereqController extends BaseController {
		
	// Dados para a view
	var $data = [
		'title' => 'Course',
		'coursePrereq' => NULL,
		'coursePrereqs' => []
	];

	var $rules = [
		'id_prerequisite' => [
			'required',
		],
		'id_course' =>[
			'required',
		],
		'id_prerequisite_course' =>[
			'required'
		],
	];

	var $niceNames = [
		'id_prerequisite' => 'prerequisite id',
		'id_course' => 'course',
		'id_prerequisite_course' => 'prerequisite course'
	];

	/**
	 * List Prerequisite course
	 *
	 * @author Fantastic Five
	 */
	public function showList ($id_course) {
		
		$course = CourseService::getCoursePrerequisite($id_course);
		if ( !$user || !Auth::user()->is_admin && Auth::user()->id_user != $id_user) {
			return Redirect::route('login')->withErrors('User does not exists.');
		}	

		$this->data['course'] = & $course;
		
		return View::make('admin.course.list-prerequisite')->with($this->data);
	}
	
	/**
	 * Associate an Course to a Prerequisite
	 *
	 * @author Fantastic Five
	 */
	public function create ($id_course) {
		
		$course = SystemUser::with('prerequisite')->find($id_course);
		$this->data['coursePrereq'] = & $course;
		
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
				return View::make('admin.course.form-prerequisition')->with($this->data)
					->withErrors($validator->messages());
			}
			
			// Checks if association already exists
			$fs = CourseService::getCoursePrerequisition($id_course, Input::get('id_prerequisite'));
			
			if ($fs) {
				return Redirect::route('admin.course.prerequisition.list', [$course->id_course])
					->withErrors(['Association already exists.']);
			}
						
			// create
			$prereq = self::populate();
			
			if ( $prereq->save() ) {
				
				// success
				Session::flash('success', 'Successfully added.');
				return Redirect::route('admin.course.prerequisition.list', [$course->id_course]);
			}
			
			return View::make('admin.user.form-prerequisition')->with($this->data)
				->withErrors('Error while trying to add.');
		}

		return View::make('admin.user.form-prerequisition')->with($this->data);
	}

	/**
	 * Delete entity
	 *
	 * @author Fantastic Five
	 */
	public function delete ($id) {

		$fs = CoursePrerequisition::find ($id);
		$ret = CourseService::deleteCoursePrerequisition($id);
				
		if ($ret === TRUE) {	
			Session::flash('success', 'Successfully deleted.');
			return Redirect::route('admin.course.prerequisition.list', [$fs->id_course]);

		} else {
			return Redirect::route('admin.course.prerequisition.list', [$fs->id_course])
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
		
		$fs = is_null($id) ? new CoursePrerequisition() : CoursePrerequisition::find($id);
		
		if (!$fs) {
			return FALSE;
		}
		
		$fs->id_prerequisite = Input::get('id_prerequisite');
		$fs->id_course = Input::get('id_course');

		return $fs;
	}
	
	/**
	 * Add combo data
	 * 
	 * @author Fantastic Five
	 */
	private function addCombos() {
		
		// Selectbox
		$specialization_list = Specialization::orderBy('prerequisition')
    										  ->lists('prerequisition', 'id_prerequisition');
		
		$this->data['prerequisition_list'] = ['' => 'Select a specialization area'];
		$this->data['prerequisition_list'] += $prerequisition_list;
	} 	
	
}