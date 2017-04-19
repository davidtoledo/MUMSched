<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use MUMSched\Services\BlockService;
use MUMSched\Utils\AppUtil;

/**
 * Block Controller
 *
 * @author Fantastic Five
 */
class BlockController extends BaseController {
		
	// View data
	var $data = [
		'block' => NULL,
		'blocks' => []
	];

	var $rules = [
		'name' => [
			'required',
		],
		'dt_start_date' => [
			'required',
		],
		'dt_end_date' => [
			'required',
		],
		'num_mpp_courses' => [
			'required',
		],
		'num_fpp_courses' => [
			'required',
		],
		
	];

	var $niceNames = [
		'dt_start_date' => 'start date',
		'dt_end_date' => 'end date',
		'num_mpp_courses' => 'number of MPP courses',
		'num_fpp_courses' => 'number of FPP courses'
	];

	/**
	 * Show list
	 *
	 * @author Fantastic Five
	 */
	public function showList() {
					
		// Getting Blocks List from DB
		$blocks = BlockService::getBlockList();
				
		// Adding objects to the view context
		$this->data['blocks'] = $blocks;
		
		// Redirecting to the view layer
		return View::make('admin.block.list-block', $this->data);
	}
	
	/**
	 * Creates a Block
	 *
	 * @author Fantastic Five
	 */
	public function create() {
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
				
				return View::make('admin.block.form-block')
					->with($this->data)
					->withErrors($validator->messages()
				);
			}
			
			// Register Block
			$block = self::populate();
			
			if ( $block->save() ) {
				
				// Success
				Session::flash('success', 'Successfully registered.');
				
				// Show view
				return Redirect::route('admin.block.list');
			}
			
			return View::make('admin.block.form-block')
				->with($this->data)
				->withErrors('An error occurred while trying to register.')
			;
		}
		
		return View::make('admin.block.form-block')->with($this->data);
	}
	
	/**
	 * Edit entity
	 *
	 * @author Fantastic Five
	 */
	public function edit ($id) {
		
		// Getting Block from DB
		$block = BlockService::getBlockByID($id);
		
		if ( !$block ) {
			return Redirect::route('admin.block.list')->withErrors('Block not found.');
		}
				
		// Adding data in the view context
		$this->data['block'] = & $block;
		
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
				
				return View::make('admin.block.form-block')
					->with($this->data)
					->withErrors($validator->messages()
				);
			}
			
			// Edit
			$block = self::populate($id);
			
			if ( $block->save() ) {
				
				Session::flash('success', 'Successfully edited.');
				
				// show view
				return Redirect::route('admin.block.list');
			}

			// show view
			return View::make('admin.block.form-block')->with($this->data)
				->withErrors('An error occurred while trying to edit.');
		}

		// show view
		return View::make('admin.block.form-block')->with($this->data);
	}	

	/**
	 * Delete Entity
	 *
	 * @author Fantastic Five
	 */
	public function delete ($id) {
				
		$return = BlockService::deleteBlock($id);
		
		if ($return === TRUE) {	
			Session::flash('success', 'Successfully removed.');
			return ( self::showList() );

		} else {
			return Redirect::route('admin.block.list')
				->withErrors(['An error occurred while trying to delete:', 
				$return->getMessage()]
			);
		}
	}	
	
	
	private function addCombos() {
		
		// Entry Selectbox
		$entry_list = Entry::orderBy('name')
    					   ->lists('name', 'id_entry');
		
		$this->data['entry_list'] = ['' => 'Select an entry'];
		$this->data['entry_list'] += $entry_list;
		
		
	}

	/**
	 * Populate data from the view layer
	 *
	 * @author Fantastic Five
	 */
	private function populate ($id = NULL) {
		
		$block = is_null($id) ? new Block() : Block::find($id);
		
		if (!$block) {
			return FALSE;
		}
				
		$block->id_entry = Input::get('id_entry');
		$block->name = Input::get('name');	
		$block->num_mpp_courses = Input::get('num_mpp_courses');
		$block->num_fpp_courses = Input::get('num_fpp_courses');
		$block->start_date = AppUtil::date2db(Input::get("start_date"));
		$block->end_date = AppUtil::date2db(Input::get("end_date"));
		
		return $block;
	}

}