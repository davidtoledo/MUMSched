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
	 * Creates a Schedule
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
				
				return View::make('admin.schedule.form-schedule')
					->with($this->data)
					->withErrors($validator->messages()
				);
			}

			// Checks if same entry already exists
			$schedule = Schedule::where("id_entry", Input::get('id_entry'))
								->first();

			if ($schedule) {
				return Redirect::route('admin.schedule.list')->withErrors(['Entry already exists.']);
			}
			
			
			// Register Schedule
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
		
		// Getting Schedule from DB
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
		$schedule->created_date = date("Y-m-d H:i:s");
		
		if ($schedule->status == null) {
			$schedule->status = Schedule::STATUS_DRAFT;
		}

		return $schedule;
	}
	
	/**
	 * Generate Schedule via AJAX
	 * 
	 * @author Fantastic Five
	 */
	 public function generate ($id_schedule, $algorithm_type, $block_order) {
	 	
		$jsonRet = [
			'return' => 0,
			'messages' => [],
		];
		
		try {

			if ($algorithm_type == NULL || $block_order == NULL) {
				$jsonRet['return'] = 1;
				$jsonRet['messages'][] = "Invalid parameters (algorithm_type: " . $algorithm_type . ", block_order: " . $block_order . ")";
				return $jsonRet;			
			}
			
			// Getting the Schedule
			$schedule = Schedule::find($id_schedule);
			if (!$schedule) {
				$jsonRet['return'] = 2;
				$jsonRet['messages'][] = "An error ocurred while trying to retrieve the schedule data!";
				return $jsonRet;
			}
			
			// Getting the Entry
			$entry = Entry::find($schedule->id_entry);
			if (!$entry) {
				$jsonRet['return'] = 3;
				$jsonRet['messages'][] = "An error ocurred while trying to retrieve the entry data!";
				return $jsonRet;
			}
			
			// Getting the Blocks
			if ($block_order == Schedule::BLOCK_ORDER_DEFAULT) {
				
				$blocks = Block::where("id_entry", $entry->id_entry)
								->get();
			} else {
				
				$blocks = Block::where("id_entry", $entry->id_entry)
							   ->orderByRaw("RAND()")
							   ->get();
			}
			if (!$blocks) {
				$jsonRet['return'] = 4;
				$jsonRet['messages'][] = "An error ocurred while trying to retrieve the block data!";
				return $jsonRet;
			}

			/*************************************************************
			 * 
			 * GENERATE SCHDULE PROCESS - BEGIN
			 * 
			 * @author David Toledo Costa (david.oracle@gmail.com)
			 * 
			 */
			
			// Getting SCI course data
			$sci_course = Course::with("faculties")
								->where("code", Course::COURSE_SCI_CODE)
								->first();
								
			if (!$sci_course || sizeof ($sci_course->faculties) == 0) {
				$jsonRet['return'] = 5;
				$jsonRet['messages'][] = 'SCI course error. Please create a course with the code "' . Course::COURSE_SCI_CODE . '" and make sure there is at least one faculty assigned to teach this course.';
				return $jsonRet;
			}
			
			// Getting MPP course data
			$mpp_course = Course::with("faculties")
								->where("code", Course::COURSE_MPP_CODE)
								->first();
			
			if (!$mpp_course || sizeof($mpp_course->faculties) == 0) {
				$jsonRet['return'] = 6;
				$jsonRet['messages'][] = 'MPP course error. Please create a course with the code "' . Course::COURSE_MPP_CODE . '" and make sure there is at least one faculty assigned to teach this course.';
				return $jsonRet;
			}

			// Getting FPP course data
			$fpp_course = Course::with("faculties")
								->where("code", Course::COURSE_FPP_CODE)
								->first();
			
			if (!$fpp_course || sizeof($fpp_course->faculties) == 0) {
				$jsonRet['return'] = 7;
				$jsonRet['messages'][] = 'FPP course error. Please create a course with the code "' . Course::COURSE_FPP_CODE . '" and make sure there is at least one faculty assigned to teach this course.';
				return $jsonRet;
			}

			// Getting Carrer Strategies course data
			$crs_course = Course::with("faculties")
								->where("code", Course::COURSE_CRS_CODE)
								->first();
			
			if (!$crs_course || sizeof($crs_course->faculties) == 0) {
				$jsonRet['return'] = 8;
				$jsonRet['messages'][] = 'Carrer Strategies course error. Please create a course with the code "' . Course::COURSE_CRS_CODE . '" and make sure there is at least one faculty assigned to teach this course.';
				return $jsonRet;
			}

			// Iterating over the blocks from the selected entry
			$b = 1;
			foreach ($entry->blocks as $block) {
					
				// Skipping break blocks
				if ($block->num_mpp_courses == 0 || $block->num_fpp_courses == 0) {
					continue;
				}
  					
  				// BR: Generating 1st block with SCI course
				if ($algorithm_type == Schedule::ALGORITHM_MUM_DEFAULT && $b == 1) {
					
					for ($i=0; $i < 2; $i++) {
						$section = new Section();
						$section->track = ($i == 0 ? Section::TRACK_MPP : Section::TRACK_FPP);
						$section->id_block = $block->id_block;
						$section->id_course = $sci_course->id_course;
						$section->id_faculty = $sci_course->faculties->first()->id_faculty;
						$section->capacity = Section::DEFAULT_CAPACITY;
						$section->save();
					}					
				}
					
  				// BR: Generating 2nd block with MPP and FPP courses
				if ($algorithm_type == Schedule::ALGORITHM_MUM_DEFAULT && $b == 2 ||
					$algorithm_type == Schedule::ALGORITHM_ONLY_COMPUTER_SCIENCE && $b == 1 
				) {
					
					for ($i=0; $i < 2; $i++) {
						$section = new Section();
						$section->track = ($i == 0 ? Section::TRACK_MPP : Section::TRACK_FPP);
						$section->id_block = $block->id_block;
						$section->id_course = ($i == 0 ? $mpp_course->id_course : $fpp_course->id_course);
						
						$section->id_faculty = ($i == 0 ? $mpp_course->faculties->first()->id_faculty 
															: 
															$fpp_course->faculties->first()->id_faculty
											   );
											   
						$section->capacity = Section::DEFAULT_CAPACITY;
						$section->save();
					}					
				}
				
  				// BR: Generating 3nd block with MPP course for FPP track
				if ($algorithm_type == Schedule::ALGORITHM_MUM_DEFAULT && $b == 3 ||
					$algorithm_type == Schedule::ALGORITHM_ONLY_COMPUTER_SCIENCE && $b == 2
				) {
					
					for ($i=0; $i < 2; $i++) {
												
						if ($i== 0) {
							
							$courses = Course::with('faculties')
											 ->whereNotIn("code", 
											 	[ Course::COURSE_SCI_CODE, 
											 	  Course::COURSE_MPP_CODE,
											 	  Course::COURSE_FPP_CODE,
											 	  Course::COURSE_CRS_CODE,		
											 	]
											  )
											 ->orderByRaw("RAND()")
											 ->limit( $block->num_mpp_courses )
											 ->get();
						} else {
							
							$courses = Course::with("faculties")
								->where("code", Course::COURSE_MPP_CODE)
								->get();
							
						}
										 
						foreach ($courses as $c) {
							$section = new Section();
							$section->track = ($i == 0 ? Section::TRACK_MPP : Section::TRACK_FPP);
							$section->id_block = $block->id_block;
							$section->id_course = $c->id_course;
							$section->id_faculty = $c->faculties->first()->id_faculty;
							$section->capacity = Section::DEFAULT_CAPACITY;
							$section->save();						
						}
					}					
				}
				
				// Handle next blocks
				else if ($algorithm_type == Schedule::ALGORITHM_MUM_DEFAULT && $b >= 4 ||
						 $algorithm_type == Schedule::ALGORITHM_ONLY_COMPUTER_SCIENCE && $b >=3) {
						
					if ($block->num_fpp_courses == $block->num_mpp_courses) {
						
							$courses = Course::with('faculties')
											 ->whereNotIn("code", 
											 	[ Course::COURSE_SCI_CODE, 
											 	  Course::COURSE_MPP_CODE,
											 	  Course::COURSE_FPP_CODE,
											 	  Course::COURSE_CRS_CODE,		
											 	]
											  )
											 ->orderByRaw("RAND()")
											 ->limit( $block->num_mpp_courses )
											 ->get();
											 
							for ($i=0; $i < 2; $i++) {
								foreach ($courses as $c) {
									$section = new Section();
									$section->track = ($i == 0 ? Section::TRACK_MPP : Section::TRACK_FPP);
									$section->id_block = $block->id_block;
									$section->id_course = $c->id_course;
									$section->id_faculty = $c->faculties->first()->id_faculty;
									$section->capacity = Section::DEFAULT_CAPACITY;
									$section->save();						
								}
							}

					} else {
					
						for ($i=0; $i < 2; $i++) {
													
							if ($i== 0) {
								
								$courses = Course::with('faculties')
												 ->whereNotIn("code", 
												 	[ Course::COURSE_SCI_CODE, 
												 	  Course::COURSE_MPP_CODE,
												 	  Course::COURSE_FPP_CODE,
												 	  Course::COURSE_CRS_CODE,		
												 	]
												  )
												 ->orderByRaw("RAND()")
												 ->limit( $block->num_mpp_courses )
												 ->get();
							} else {
								
								$courses = Course::with('faculties')
												 ->whereNotIn("code", 
												 	[ Course::COURSE_SCI_CODE, 
												 	  Course::COURSE_MPP_CODE,
												 	  Course::COURSE_FPP_CODE,
												 	  Course::COURSE_CRS_CODE,
												 	]
												  )							
												 ->orderByRaw("RAND()")
												 ->limit( $block->num_fpp_courses )
												 ->get();
							}
											 
							foreach ($courses as $c) {
								$section = new Section();
								$section->track = ($i == 0 ? Section::TRACK_MPP : Section::TRACK_FPP);
								$section->id_block = $block->id_block;
								$section->id_course = $c->id_course;
								$section->id_faculty = $c->faculties->first()->id_faculty;
								$section->capacity = Section::DEFAULT_CAPACITY;
								$section->save();						
							}
						}
					}
				}
				
				$b++;
			}

			// Last MPP course should be Carrer Strategies						
			$section = Section::where("track", Section::TRACK_MPP)
							  ->orderBy('id_section', 'desc')
							  ->first();
							  
			$section->id_course = $crs_course->id_course;
			$section->save();

			// Update the generated date
			$schedule->generated_date = date("Y-m-d H:i:s");
			$schedule->save();
						
		} catch (Exception $e) {
			$jsonRet['return'] = 99;
			$jsonRet['messages'][] = $e->getMessage();
		}
		
		return $jsonRet;
	 }

	/**
	 * View/Render the Calendar 
	 * 
	 * @author Fantastic Five
	 */
	 public function view ($id_schedule, $id_person = NULL) {

		// Getting Schedule from DB
		$schedule = Schedule::with("entry")
							->find($id_schedule);
		if ( !$schedule ) {
			return Redirect::route('admin.schedule.list')->withErrors('Schedule not found.');
		}
				
		// Adding data in the view context
		$this->data['schedule'] = & $schedule;
	 	
		// Redirects to the view layer
		return View::make('calendar.grid')->with($this->data);
	 }
		
}