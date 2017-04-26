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
	public static function getStudentSection($sectionID,$studentID);
	public static function save($studentSection);
}