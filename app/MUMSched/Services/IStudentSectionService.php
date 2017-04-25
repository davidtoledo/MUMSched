<?php

namespace MUMSched\Services;

/**
 * Interface class for SectionService
 *
 * @author Fantastic Five
 */
interface IStudentSectionService {
	public static function getSectionList();
	public static function getSectionByID($id);
	public static function deleteSection($id);	
	public static function getSectionsByStudent($studentID);
}