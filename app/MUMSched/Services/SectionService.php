<?php

namespace MUMSched\Services;
use MUMSched\DAOs\SectionDAO;

/**
 * Service class for Section
 *
 * @author Fantastic Five
 */
class SectionService implements ISectionService {

	public static function getSectionList() {
		return SectionDAO::getSectionList();
	}
	public static function getSectionListByBlockID($idBlock) {
		return SectionDAO::getSectionList();
	}
	
	public static function getSectionByID($id) {
		return SectionDAO::getSectionByID($id);
	}

	public static function deleteSection($id) {
		return SectionDAO::deleteSection($id);
	}
	
	public static function saveSection($section) {
		return SectionDAO::saveSection($section);
	}
}