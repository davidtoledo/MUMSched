<?php

namespace MUMSched\Services;

/**
 * Interface class for EntryService
 *
 * @author Fantastic Five
 */
interface ICourseService {
	public static function getCourseList();
	public static function getCourseByID($id);
	public static function deleteCourse($id);	
}