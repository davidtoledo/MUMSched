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
	
}