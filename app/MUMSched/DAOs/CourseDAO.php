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

	/**
	 * Return a Course by ID with prerequisites
	 * 
	 * @author Fantastic Five
	 */
	public static function getCourseByIDWithPrerequisites($id) {
		
		$courses = \Course::with("prerequisites")
						  ->find($id);
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
			'DELETE FROM faculty_course WHERE  id_course = ?',
			'DELETE FROM section        WHERE  id_course = ?',
			'DELETE FROM course         WHERE  id_course = ?',		
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
	
	
	public static function getCourseWithPrerequisite($id_course){
			$course = \SystemUser::with("prerequisites")
			       	       ->find($id_course);
			      	      
		return $course;
	}
	
}