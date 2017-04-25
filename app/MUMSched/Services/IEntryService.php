<?php

namespace MUMSched\Services;

/**
 * Interface class for EntryService
 *
 * @author Fantastic Five
 */
interface IEntryService {
	public static function getEntryList();
	public static function getEntryByID($id);
	public static function deleteEntry($id);
	public static function getEntriesList();
}