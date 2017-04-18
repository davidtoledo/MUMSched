<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use MUMSched\Services\EntryService;
use MUMSched\Utils\AppUtil;

/**
 * Entry Controller
 *
 * @author Fantastic Five
 */
class EntryController extends BaseController {
		
	// View data
	var $data = [
		'entry' => NULL,
		'entries' => []
	];

	var $rules = [
		'name' => [
			'required',
		],
		'fpp_total' => [
			'required',
		],
		'mpp_total' => [
			'required',
		],
		'opt_percent' => [
			'required',
		],
		'dt_start_date' => [
			'required',
		],
		'dt_end_date' => [
			'required',
			'after:dt_start_date',
		],
	];

	var $niceNames = [
		'fpp_total' => 'total of FPP',
		'mpp_total' => 'total of MPP',
		'opt_percent' => 'percentage of OPT',
		'dt_start_date' => 'start date',
		'dt_end_date' => 'end date',
	];

	/**
	 * Show list
	 *
	 * @author Fantastic Five
	 */
	public function showList() {
					
		// Getting Entries List from DB
		$entries = EntryService::getEntryList();
				
		// Adding objects to the view context
		$this->data['entries'] = $entries;
		
		// Redirecting to the view layer
		return View::make('admin.entry.list-entry', $this->data);
	}
	
	/**
	 * Creates an Entry
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
				
				return View::make('admin.entry.form-entry')
					->with($this->data)
					->withErrors($validator->messages()
				);
			}
			
			// Register Entry
			$entry = self::populate();
			
			if ( $entry->save() ) {
				
				// Success
				Session::flash('success', 'Successfully registered.');
				
				// Show view
				return Redirect::route('admin.entry.list');
			}
			
			return View::make('admin.entry.form-entry')
				->with($this->data)
				->withErrors('An error occurred while trying to register.')
			;
		}
		
		return View::make('admin.entry.form-entry')->with($this->data);
	}
	
	/**
	 * Edit entity
	 *
	 * @author Fantastic Five
	 */
	public function edit ($id) {
		
		// Getting Entry from DB
		$entry = EntryService::getEntryByID($id);
		
		if ( !$entry ) {
			return Redirect::route('admin.entry.list')->withErrors('Entry not found.');
		}
				
		// Adding data in the view context
		$this->data['entry'] = & $entry;
		
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
				
				return View::make('admin.entry.form-entry')
					->with($this->data)
					->withErrors($validator->messages()
				);
			}
			
			// Edit
			$entry = self::populate($id);
			
			if ( $entry->save() ) {
				
				Session::flash('success', 'Successfully edited.');
				
				// show view
				return Redirect::route('admin.entry.list');
			}

			// show view
			return View::make('admin.entry.form-entry')->with($this->data)
				->withErrors('An error occurred while trying to edit.');
		}

		// show view
		return View::make('admin.entry.form-entry')->with($this->data);
	}	

	/**
	 * Delete Entity
	 *
	 * @author Fantastic Five
	 */
	public function delete ($id) {
				
		$return = EntryService::deleteEntry($id);
		
		if ($return === TRUE) {	
			Session::flash('success', 'Successfully removed.');
			return ( self::showList() );

		} else {
			return Redirect::route('admin.entry.list')
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
		
		$entry = is_null($id) ? new Entry() : Entry::find($id);
		
		if (!$entry) {
			return FALSE;
		}
				
		$entry->name = Input::get('name');
		$entry->fpp_total = Input::get('fpp_total');
		$entry->mpp_total = Input::get('mpp_total');
		$entry->opt_percent = Input::get('opt_percent');
		$entry->start_date = AppUtil::date2db(Input::get("dt_start_date"));
		$entry->end_date = AppUtil::date2db(Input::get("dt_end_date"));
		
		return $entry;
	}
				
}