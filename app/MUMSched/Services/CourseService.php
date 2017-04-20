<?php

namespace MUMSched\Services;
use MUMSched\DAOs\CourseDAO;

/**
 * Service class for Course
 *
 * @author Fantastic Five
 */
class CourseService implements ICourseService {

	public static function getCourseList() {
		return CourseDAO::getCourseList();
	}
	
	public static function getCourseByID($id) {
		return CourseDAO::getCourseByID($id);
	}

	public static function deleteCourse($id) {
		return CourseDAO::deleteCourse($id);
	}	
	public static function getCoursePrerequisite($id_course){
		return PrerequisiteCourseDAO::getPrerequisiteByID($id_course);
	}
	public static function savePrerequisite($prerequisite){
		return PrerequisiteCourseDAO::savePrerequisite($prerequisite);
	}
	public static function deletePrerequisite($id_course){
		return PrerequisiteCourseDAO::deletePrerequisite($id_course);
	}
	
	
	
	
	
}