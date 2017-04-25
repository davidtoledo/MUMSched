<?php

namespace MUMSched\Services;
use MUMSched\DAOs\ScheduleDAO;
use MUMSched\DAOs\SectionDAO;
use Schedule;
use Entry;
use Block;
use Course;
use Section;

/**
 * Service class for Schedule
 *
 * @author Fantastic Five
 */
class ScheduleService implements IScheduleService {
	
	static $sci_course;
	static $mpp_course;
	static $fpp_course;
	static $crs_course;

	public static function getEntryList() {
		return ScheduleDAO::getEntryList();
	}

	public static function getScheduleList() {
		return ScheduleDAO::getScheduleList();
	}
	
	public static function getScheduleByID($id) {
		return ScheduleDAO::getScheduleByID($id);		
	}

	public static function deleteSchedule($id) {
		return ScheduleDAO::deleteSchedule($id);
	}
	
	public static function saveSchedule($schedule) {
		return ScheduleDAO::saveSchedule($schedule);
	}
	
	public static function generate($id_schedule, $algorithm_type, $block_order) {
		
		$json = [
			'return' => 0,
			'messages' => [],
		];
		
		try {

			if ($algorithm_type == NULL || $block_order == NULL) {
				$json['return'] = 1;
				$json['messages'][] = "Invalid parameters (algorithm_type: " . $algorithm_type . ", block_order: " . $block_order . ")";
				return $json;
			}
			
			// Getting the Schedule
			$schedule = Schedule::find($id_schedule);
			if (!$schedule) {
				$json['return'] = 2;
				$json['messages'][] = "An error ocurred while trying to retrieve the schedule data!";
				return $json;
			}
			
			// Getting the Entry
			$entry = Entry::find($schedule->id_entry);
			if (!$entry) {
				$json['return'] = 3;
				$json['messages'][] = "An error ocurred while trying to retrieve the entry data!";
				return $json;
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
			if (!$blocks || sizeof ($blocks) < 8) {
				$json['return'] = 4;
				$json['messages'][] = "You don't have enough blocks in this entry to build a schedule!";
				return $json;
			}
			
			// Check if the main courses exist
			$tmp = self::verifyIfSciFppMppCrsCoursesExist();
			if ( $tmp !== TRUE) {
				return $tmp;
			}

			// Cleaning previous data
			$return = SectionDAO::deleteSectionsByEntry($entry->id_entry);
			
			if ($return !== TRUE) {	
				return Redirect::route('admin.schedule.list')
					->withErrors(['An error occurred while trying to delete:', 
					$return->getMessage()]
				);
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
						$section->id_course = self::$sci_course->id_course;
						$section->id_faculty = self::$sci_course->faculties->first()->id_faculty;
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
						$section->id_course = ($i == 0 ? self::$mpp_course->id_course : self::$fpp_course->id_course);
						
						$section->id_faculty = ($i == 0 ? self::$mpp_course->faculties->first()->id_faculty 
															: 
														  self::$fpp_course->faculties->first()->id_faculty
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
	  		
			if ($section) {
				$section->id_course = self::$crs_course->id_course;
				$section->save();
	
				// Update the generated date
				$schedule->generated_date = date("Y-m-d H:i:s");
				$schedule->save();
			}
						
		} catch (Exception $e) {
			$json['return'] = 99;
			$json['messages'][] = $e->getMessage();
		}
		
		return $json;
	}

	/*************************************************************
	 * 
	 * Check if courses exist
	 * 
	 * @author David Toledo Costa (david.oracle@gmail.com)
	 * 
	 */		
	public static function verifyIfSciFppMppCrsCoursesExist() {
		
		// Getting SCI course data
		self::$sci_course = Course::with("faculties")
								  ->where("code", Course::COURSE_SCI_CODE)
								  ->first();
							
		if (!self::$sci_course || sizeof (self::$sci_course->faculties) == 0) {
			$json['return'] = 5;
			$json['messages'][] = 'SCI course error. Please create a course with the code "' . Course::COURSE_SCI_CODE . '" and make sure there is at least one faculty assigned to teach this course.';
			return $json;
		}
		
		// Getting MPP course data
		self::$mpp_course = Course::with("faculties")
								  ->where("code", Course::COURSE_MPP_CODE)
								  ->first();
		
		if (!self::$mpp_course || sizeof(self::$mpp_course->faculties) == 0) {
			$json['return'] = 6;
			$json['messages'][] = 'MPP course error. Please create a course with the code "' . Course::COURSE_MPP_CODE . '" and make sure there is at least one faculty assigned to teach this course.';
			return $json;
		}

		// Getting FPP course data
		self::$fpp_course = Course::with("faculties")
								  ->where("code", Course::COURSE_FPP_CODE)
								  ->first();
		
		if (!self::$fpp_course || sizeof(self::$fpp_course->faculties) == 0) {
			$json['return'] = 7;
			$json['messages'][] = 'FPP course error. Please create a course with the code "' . Course::COURSE_FPP_CODE . '" and make sure there is at least one faculty assigned to teach this course.';
			return $json;
		}

		// Getting Carrer Strategies course data
		self::$crs_course = Course::with("faculties")
								  ->where("code", Course::COURSE_CRS_CODE)
								  ->first();
		
		if (!self::$crs_course || sizeof(self::$crs_course->faculties) == 0) {
			$json['return'] = 8;
			$json['messages'][] = 'Carrer Strategies course error. Please create a course with the code "' . Course::COURSE_CRS_CODE . '" and make sure there is at least one faculty assigned to teach this course.';
			return $json;
		}

		return TRUE;
	} 
}