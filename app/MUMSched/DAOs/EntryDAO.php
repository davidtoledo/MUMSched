<?php

namespace MUMSched\DAOs;
use Illuminate\Support\Facades\DB;

/**
 * Data Access Object for Entry
 *
 * @author Fantastic Five
 */
class EntryDAO {

	/**
	 * Returns a list of Entries
	 * 
	 * @author Fantastic Five
	 */
	public static function getEntryList() {
		$entries = \Entry::get();
		return $entries;
	}

	/**
	 * Return a Entry by ID
	 * 
	 * @author Fantastic Five
	 */
	public static function getEntryByID($id) {
		$entry = \Entry::find($id);
		return $entry;
	}
	
	public static function saveEntry($entry) {
		return $entry->save();
	}
	
	/**
	 * Delete Entry
	 * 
	 * @author Fantatisc Five
	 */
	public static function deleteEntry($id) {
				
		$queries = [
			'DELETE FROM entry WHERE  id_entry = ?',		
		];
		
		try	{
			
			foreach ($queries as $query) {
				DB::delete($query, [
					$id
				]);
			}
			
			DB::commit();
			return TRUE;
		}
		catch (\Exception $e)
		{
			DB::rollback();
			return $e;
		}
		
	}	
	
}