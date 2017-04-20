<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use MUMSched\Services\CourseService;
use MUMSched\Utils\AppUtil;

/**
 * Course Controller
 *
 * @author Fantastic Five
 */
class CourseController extends BaseController {
		
	// View data
	var $data = [
		'course' => NULL,
		'courses' => []
	];

	var $rules = [
		'id_specialization' => [
			'required',
		],
		'code' => [
			'required',
		],
		'name' => [
			'required',
		],
	];

	var $niceNames = [
		'id_specialization' => 'course specialization',
		'code' => 'course code',
		'name' => 'course name',
	];

	/**
	 * Show list
	 *
	 * @author Fantastic Five
	 */
	public function showList() {
					
		// Getting Courses List from DB
		$courses = CourseService::getCourseList();
				
		// Adding objects to the view context
		$this->data['courses'] = $courses;
		
		// Redirecting to the view layer
		return View::make('admin.course.list-course', $this->data);
	}
	
	/**
	 * Creates an Course
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
				
				// Store fields
				Input::flash();
				
				return View::make('admin.course.form-course')
					->with($this->data)
					->withErrors($validator->messages()
				);
			}
			
			// Add Course
			$course = self::populate();
			
			if ( $course->save() ) {
				
				// Success
				Session::flash('success', 'Successfully added.');
				
				// Show view
				return Redirect::route('admin.course.list');
			}
			
			return View::make('admin.course.form-course')
				->with($this->data)
				->withErrors('An error occurred while trying to add course.')
			;
		}
		
		return View::make('admin.course.form-course')->with($this->data);
	}
	
	/**
	 * Edit course
	 *
	 * @author Fantastic Five
	 */
	public function edit ($id) {
		
		// Getting Course from DB
		$course = CourseService::getCourseByID($id);
		
		if ( !$course ) {
			return Redirect::route('admin.course.list')->withErrors('Course not found.');
		}
		
		// Add select data
		self::addCombos();		
				
		// Adding data in the view context
		$this->data['course'] = & $course;
		
		if ( Request::isMethod('post') ) {
						
			// Validator
			parent::useCustomValidator();
			$post = Input::all();

			// validate
			$validator = Validator::make($post, $this->rules);
			$validator->setAttributeNames($this->niceNames);
			
			if ( !$validator->passes() ) {
				
				// Store fields
				Input::flash();
				
				return View::make('admin.course.form-course')
					->with($this->data)
					->withErrors($validator->messages()
				);
			}
			
			// Edit
			$course = self::populate($id);
			
			if ( $course->save() ) {
				
				Session::flash('success', 'Successfully edited.');
				
				// show view
				return Redirect::route('admin.course.list');
			}

			// show view
			return View::make('admin.course.form-course')->with($this->data)
				->withErrors('An error occurred while trying to edit.');
		}

		// show view
		return View::make('admin.course.form-course')->with($this->data);
	}	

	/**
	 * Delete Course
	 *
	 * @author Fantastic Five
	 */
	public function delete ($id) {
				
		$return = CourseService::deleteCourse($id);
		
		if ($return === TRUE) {	
			Session::flash('success', 'Successfully removed.');
			return ( self::showList() );

		} else {
			return Redirect::route('admin.course.list')
				->withErrors(['An error occurred while trying to delete:', 
				$return->getMessage()]
			);
		}
	}
	
	/**
	 * Add combo data
	 * 
	 * @author Fantastic Five
	 */
	private function addCombos() {
		
		// Specialization Selectbox
		$spec_list = Specialization::orderBy('specialization')
    					   		   ->lists('specialization', 'id_specialization');
				
		// Add to the view context
		$this->data['spec_list'] =  $spec_list;
	}		
	
	/**
	 * Populate data from the view layer
	 *
	 * @author Fantastic Five
	 */
	private function populate ($id = NULL) {
		
		$course = is_null($id) ? new Course() : Course::find($id);
		
		if (!$course) {
			return FALSE;
		}
		$course->id_specialization = Input::get('id_specialization');
		$course->code = Input::get('code');
		$course->name = Input::get('name');	
			
		return $course;
	}

}