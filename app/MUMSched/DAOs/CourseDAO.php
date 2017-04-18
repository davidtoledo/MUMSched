<?php

namespace MUMSched\DAOs;
use Illuminate\Support\Facades\DB;

/**
 * Data Access Object for Course
 *
 * @author Fantastic Five
 */
class CourseDAO {

	/**
	 * Returns a list of courses
	 * 
	 * @author Fantastic Five
	 */
	public static function getCourseList() {
		$courses = \Course::get();
		return $courses;
	}

	/**
	 * Return a Course by ID
	 * 
	 * @author Fantastic Five
	 */
	public static function getCourseByID($id) {
		$courses = \Course::find($id);
		return $courses;
	}
	
	public static function saveCourse($course) {
		return $course->save();
	}
	
	/**
	 * Delete Course
	 * 
	 * @author Fantatisc Five
	 */
	public static function deleteCourse($id) {
				
		$queries = [
			'DELETE FROM course WHERE  id_course = ?',		
		];
		
		try	{
			
			foreach ($queries as $query) {
				DB::delete($query, [
					$id
				]);
			}
			
			DB::commit();
			return TRUE;
		}
		catch (\Exception $e)
		{
			DB::rollback();
			return $e;
		}
		
	}	
	
}