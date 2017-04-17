<?php

namespace MUMSched\DAOs;
use Illuminate\Support\Facades\DB;

/**
 * Data Access Object for Section
 *
 * @author Fantastic Five
 */
class SectionDAO {
	
	/**
	 * Delete Section by Block
	 * 
	 * @author Fantatisc Five
	 */
	public static function deleteSectionsByEntry($id) {
				
		$queries = [
			'DELETE FROM section 
			 WHERE id_block IN (SELECT id_block FROM block WHERE id_entry = ?)',
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