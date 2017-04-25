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
		'title' => 'Prerequisite',
		'coursePrereq' => NULL,
		'coursePrereqs' => []
	];
		
	var $rules = [
		'id_prerequisite' => [
			'required',
		],
	];

	var $niceNames = [
		'id_prerequisite' => 'course prerequisite',
	];

	/**
	 * List Prerequisite course
	 *
	 * @author Fantastic Five
	 */
	public function showList ($id_course) {
		
		$course = CourseService::getCourseByIDWithPrerequisites($id_course);

		$this->data['course'] = & $course;
				
		return View::make('admin.course.list-prerequisite')->with($this->data);
	}

	/**
	 * Associate an Prerequisite to a Course
	 *
	 * @author Fantastic Five
	 */
	public function create ($id_course) {
		
		$course = CourseService::getCourseByIDWithPrerequisites($id_course);
		$this->data['course'] = & $course;
		
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
				return View::make('admin.course.form-prerequisite')->with($this->data)
					->withErrors($validator->messages());
			}
			
			// Checks if association already exists
			$pre = Prerequisite::where("id_course", $id_course)
							   ->where("id_prerequisite", Input::get("id_prerequisite"))
							   ->first();
			
			if ($pre) {
				return Redirect::route('admin.course.prerequisite.list', [$course->id_course])
					->withErrors(['Association already exists.']);
			}
						
			// create
			$prereq = self::populate();
			
			if ( $prereq->save() ) {
				
				// success
				Session::flash('success', 'Successfully added.');
				return Redirect::route('admin.course.prerequisite.list', [$course->id_course]);
			}
			
			return View::make('admin.course.form-prerequisite')->with($this->data)
				->withErrors('Error while trying to add.');
		}

		return View::make('admin.course.form-prerequisite')->with($this->data);
	}

	/**
	 * Delete entity
	 *
	 * @author Fantastic Five
	 */
	public function delete ($id_course, $id_prerequisite) {

		$ret = CourseService::deletePrerequisite($id_prerequisite);
				
		if ($ret === TRUE) {	
			Session::flash('success', 'Successfully deleted.');
			return Redirect::route('admin.course.prerequisite.list', [$id_course]);

		} else {
			return Redirect::route('admin.course.prerequisite.list', [$id_course])
				->withErrors(['An error occurred while trying to delete:', 
				$ret->getMessage()]
			);
		}
	}
	
	/**
	 * Populate data from the view layer
	 *
	 * @author Fantastic Five
	 */
	private function populate ($id = NULL) {
		
		$prec = is_null($id) ? new Prerequisite() : Prerequisite::find($id);
		
		if (!$prec) {
			return FALSE;
		}
		
		$prec->id_course = Input::get('id_course');
		$prec->id_prerequisite = Input::get('id_prerequisite');

		return $prec;
	}
	
	/**
	 * Add combo data
	 * 
	 * @author Fantastic Five
	 */
	private function addCombos() {
		
		// Selectbox
		$prerequisite_list = Course::orderBy('name')
									->lists('name', 'id_course');
		
		$this->data['prerequisite_list'] = ['' => 'Select a prerequisite course'];
		$this->data['prerequisite_list'] += $prerequisite_list;
		 
	} 	
	
}