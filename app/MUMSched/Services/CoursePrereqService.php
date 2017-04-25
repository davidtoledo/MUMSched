<?php

namespace MUMSched\Services;
use MUMSched\DAOs\CourseDAO;
use MUMSched\DAOs\PrerequisiteCourseDAO;

/**
 * Service class for Course
 *
 * @author Fantastic Five
 */
class CoursePrereqService implements ICoursePrereqService {

	// public static function getCourseList() {
		// return CourseDAO::getCourseList();
	// }
// 	
	// public static function getCourseByID($id) {
		// return CourseDAO::getCourseByID($id);
	// }
	
	public static function getCourseByIDWithPrerequisites($id) {
		return CourseDAO::getCourseByIDWithPrerequisites($id);
	}	

	// public static function deleteCourse($id) {
		// return CourseDAO::deleteCourse($id);
	// }
		
	public static function getCoursePrerequisite($id_course){
		return PrerequisiteCourseDAO::getPrerequisiteByID($id_course);
	}
	
	public static function savePrerequisite($prerequisite){
		return PrerequisiteCourseDAO::savePrerequisite($prerequisite);
	}
	
	public static function deletePrerequisite($id_prerequisite){
		return PrerequisiteCourseDAO::deletePrerequisite($id_prerequisite);
	}
	
}