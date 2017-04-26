<?php

namespace MUMSched\Services;
use MUMSched\DAOs\EntryDAO;

/**
 * Service class for Entry
 *
 * @author Fantastic Five
 */
class EntryService implements IEntryService {

	public static function getEntryList() {
		return EntryDAO::getEntryList();
	}
	
	public static function getEntryByID($id) {
		return EntryDAO::getEntryByID($id);
	}

	public static function deleteEntry($id) {
		return EntryDAO::deleteEntry($id);
	}
	
	public static function getEntriesList() {
		return EntryDAO::getEntriesList();
	}	
	
	public static function saveEntry($entry) {
		return EntryDAO::saveEntry($entry);
	}	
	
}