<?php

namespace MUMSched\DAOs;
use Illuminate\Support\Facades\DB;

/**
 * Data Access Object for Prerequisite
 *
 * @author Fantastic Five
 */
class PrerequisiteCourseDAO {

	/**
	 * Returns a list of prerequisites
	 * 
	 * @author Fantastic Five
	 */
	public static function getPrerequisiteList() {
		$prerequisites = \Prerequisite::get();
		return $prerequisites;
	}

	/**
	 * Return a Prerequisite by ID
	 * 
	 * @author Fantastic Five
	 */
	public static function getPrerequisiteByID($id) {
		$prerequisites = \Prerequisite::find($id);
		return $prerequisites;
	}
	
	public static function savePrerequisite($prerequisite) {
		return $prerequisite->save();
	}
	
	/**
	 * Delete Prerequisite
	 * 
	 * @author Fantatisc Five
	 */
	public static function deletePrerequisite($id_prerequisite) {
				
		$queries = [
			'DELETE FROM prerequisite WHERE  id = ?',
				
		];
		
		try	{
			
			foreach ($queries as $query) {
				DB::delete($query, [
					$id_prerequisite
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