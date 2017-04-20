<?php

namespace MUMSched\Services;

/**
 * Interface class for SectionService
 *
 * @author Fantastic Five
 */
interface ISectionService {
	public static function getSectionList();
	public static function getSectionByID($id);
	public static function deleteSection($id);	
}