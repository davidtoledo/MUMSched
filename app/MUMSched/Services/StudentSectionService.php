<?php

namespace MUMSched\Services;
use MUMSched\DAOs\StudentSectionDAO;

/**
 * Service class for StudentSection
 *
 * @author Fantastic Five
 */
class StudentSectionService implements IStudentSectionService {

	public static function getSectionList() {
		return StudentSectionDAO::getSectionList();
	}
	
	public static function getSectionByID($id) {
		return StudentSectionDAO::getSectionByID($id);
	}

	public static function deleteSection($id) {
		return StudentSectionDAO::deleteSection($id);
	}
	
	public static function getSectionsByStudent($studentID){
		return StudentSectionDAO::getSectionsByStudentID($studentID);
	}
	
	public static function getStudentSection($sectionID,$studentID){
		return StudentSectionDAO::getStudentSection($sectionID,$studentID);
	}
	
}