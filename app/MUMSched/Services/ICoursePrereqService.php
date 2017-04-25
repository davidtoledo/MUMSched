<?php

namespace MUMSched\Services;

/**
 * Interface class for CourseService
 *
 * @author Fantastic Five
 */
interface ICoursePrereqService {
	public static function getCoursePrerequisite($id_course);
	public static function savePrerequisite($prerequisite);
	public static function deletePrerequisite($id_prerequisite);
}