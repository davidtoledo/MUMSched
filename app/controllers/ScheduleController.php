<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use MUMSched\Services\ScheduleService;

/**
 * Schedule Controller
 *
 * @author Fantastic Five
 */
class ScheduleController extends BaseController {
		
	// View data
	var $data = [
		'schedule' => NULL,
		'schedules' => []
	];

	var $rules = [
		'id_entry' => [
			'required',
		],
	];

	var $niceNames = [
		'id_entry' => 'entry',
	];

	/**
	 * Show list
	 *
	 * @author Fantastic Five
	 */
	public function showList() {
					
		// Getting Schedule List from DB
		$schedules = ScheduleService::getScheduleList();
				
		// Adding objects to the view context
		$this->data['schedules'] = $schedules;
		
		// Redirecting to the view layer
		return View::make('admin.schedule.list-schedule', $this->data);
	}
		
	/**
	 * Generates a Schedule
	 *
	 * @author Fantastic Five
	 */
	public function generate() {
		
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
				
				return View::make('admin.schedule.form-schedule')
					->with($this->data)
					->withErrors($validator->messages()
				);
			}

			// Checks if same entry already exists
			$schedule = Schedule::where("id_entry", Input::get('id_entry'))
								->first();

			if ($schedule) {
				return Redirect::route('admin.schedule.list')
					->withErrors(['Entry already exists.']);
			}
			
			// Register
			$schedule = self::populate();
			
			if ( $schedule->save() ) {
				
				// Success
				Session::flash('success', 'Successfully registered.');
				
				// Show view
				return Redirect::route('admin.schedule.list');
			}
			
			return View::make('admin.schedule.form-schedule')
				->with($this->data)
				->withErrors('An error occurred while trying to register.')
			;
		}
		
		return View::make('admin.schedule.form-schedule')->with($this->data);
	}
	
	/**
	 * Edit entity
	 *
	 * @author Fantastic Five
	 */
	public function edit ($id) {
		
		// Getting User from DB
		$schedule = ScheduleService::getScheduleByID($id);
		
		if ( !$schedule ) {
			return Redirect::route('admin.schedule.list')->withErrors('Schedule not found.');
		}
		
		// Add select data
		self::addCombos();
		
		// Adding data in the view context
		$this->data['schedule'] = & $schedule;
		
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
				
				return View::make('admin.schedule.form-schedule')
					->with($this->data)
					->withErrors($validator->messages()
				);
			}
			
			// Edit
			$schedule = self::populate($id);
			
			if ( $schedule->save() ) {
				
				Session::flash('success', 'Successfully edited.');
				
				// show view
				return Redirect::route('admin.schedule.list');
			}

			// show view
			return View::make('admin.schedule.form-schedule')->with($this->data)
				->withErrors('An error occurred while trying to edit.');
		}

		// show view
		return View::make('admin.schedule.form-schedule')->with($this->data);
	}

	/**
	 * Delete Entity
	 *
	 * @author Fantastic Five
	 */
	public function delete ($id) {
				
		$return = ScheduleService::deleteSchedule($id);
		
		if ($return === TRUE) {	
			Session::flash('success', 'Successfully removed.');
			return ( self::showList() );

		} else {
			return Redirect::route('admin.schedule.list')
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
		
		// Entry Selectbox
		$entry_list = Entry::orderBy('name')
    					   ->lists('name', 'id_entry');
		
		$this->data['entry_list'] = ['' => 'Select an entry'];
		$this->data['entry_list'] += $entry_list;
		
		// Status Selectbox
		$this->data['status_list'] =  ['' => 'Select a status'];
		$this->data['status_list'] += ['D' => 'Draft'];
		$this->data['status_list'] += ['O' => 'OK'];
	}
	
	/**
	 * Populate data from the view layer
	 *
	 * @author Fantastic Five
	 */
	private function populate ($id = NULL) {
		
		$schedule = is_null($id) ? new Schedule() : Schedule::find($id);
		
		if (!$schedule) {
			return FALSE;
		}
		
		$schedule->id_entry = Input::get('id_entry');		
		$schedule->status = Input::get('status');
		$schedule->generated_date = date("Y-m-d H:i:s");
		
		if ($schedule->status == null) {
			$schedule->status = Schedule::STATUS_DRAFT;
		}

		return $schedule;
	}	
		
}