<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use MUMSched\Services\SectionService;
use MUMSched\Utils\AppUtil;

/**
 * Section Controller
 *
 * @author Fantastic Five
 */
class SectionController extends BaseController {
		
	// View data
	var $data = [
		'section' => NULL,
		'sections' => []
	];

	var $rules = [
		'track' => [
			'required',
		],
		'id_block' => [
			'required',
			'numeric',
		],
		'id_course' => [
			'required',
			'numeric',
		],
		'id_faculty' => [
			'required',
			'numeric',
		],
		
		'capacity' => [
			'required',
			'numeric',
		],
	];

	var $niceNames = [
		'track' => 'Track for each student: FPP, MPP, US',
		'capacity' => 'capacity of this section'
		
	];

	/**
	 * Show list of Section
	 *
	 * @author Fantastic Five
	 */
	public function showList() {
					
		// Getting Sections List from DB
		$sections = SectionService::getSectionList();
				
		// Adding objects to the view context
		$this->data['sections'] = $sections;
		
		// Redirecting to the view layer
		return View::make('admin.section.list-section', $this->data);
	}
	
	/**
	 * Creates a Section
	 *
	 * @author Fantastic Five
	 */
	public function create() {
				
		if ( Request::isMethod('post') ) {
			
			// Validator
			parent::useCustomValidator();
			$post = Input::all();
			
			$validator = Validator::make($post, $this->rules);
			$validator->setAttributeNames($this->niceNames);
			
			if ( !$validator->passes() ) {
				
				// Store fields
				Input::flash();
				
				return View::make('admin.section.form-section')
					->with($this->data)
					->withErrors($validator->messages()
				);
			}
			
			// Register Section
			$section = self::populate();
			
			if ( $section->save() ) {
				
				// Success
				Session::flash('success', 'Successfully registered.');
				
				// Show view
				return Redirect::route('admin.section.list');
			}
			
			return View::make('admin.section.form-section')
				->with($this->data)
				->withErrors('An error occurred while trying to register.')
			;
		}
		
		return View::make('admin.section.form-section')->with($this->data);
	}
	
	/**
	 * Edit a Section
	 *
	 * @author Fantastic Five
	 */
	public function edit ($id) {
		
		// Getting Section from DB
		$section = SectionService::getSectionByID($id);
		
		if ( !$section ) {
			return Redirect::route('admin.section.list')->withErrors('Section not found.');
		}
				
		// Adding data in the view context
		$this->data['section'] = & $section;
		
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
				
				return View::make('admin.section.form-section')
					->with($this->data)
					->withErrors($validator->messages()
				);
			}
			
			// Edit
			$section = self::populate($id);
			
			if ( $section->save() ) {
				
				Session::flash('success', 'Successfully edited.');
				
				// show view
				return Redirect::route('admin.section.list');
			}

			// show view
			return View::make('admin.section.form-section')->with($this->data)
				->withErrors('An error occurred while trying to edit.');
		}

		// show view
		return View::make('admin.section.form-section')->with($this->data);
	}	

	/**
	 * Delete Entity
	 *
	 * @author Fantastic Five
	 */
	public function delete ($id) {
				
		$return = SectionService::deleteSection($id);
		
		if ($return === TRUE) {	
			Session::flash('success', 'Successfully removed.');
			return ( self::showList() );

		} else {
			return Redirect::route('admin.section.list')
				->withErrors(['An error occurred while trying to delete:', 
				$return->getMessage()]
			);
		}
	}	
	
	/**
	 * Populate data from the view layer
	 *
	 * @author Fantastic Five
	 */
	private function populate ($id = NULL) {
		
		$section = is_null($id) ? new Section() : Section::find($id);
		
		if (!$section) {
			return FALSE;
		}
				
		$section->track = Input::get('track');
		$section->fpp_total = Input::get('fpp_total');
		$section->mpp_total = Input::get('mpp_total');
		$section->opt_percent = Input::get('opt_percent');
		$section->start_date = AppUtil::date2db(Input::get("dt_start_date"));
		$section->end_date = AppUtil::date2db(Input::get("dt_end_date"));
		
		return $section;
	}

}