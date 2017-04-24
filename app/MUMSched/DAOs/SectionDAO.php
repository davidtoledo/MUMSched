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
	
	/**
	 * Returns a list of Sections
	 * 
	 * @author Fantastic Five
	 */
	public static function getSectionList() {
		$sections = \Section::get();
		return $sections;
	}

	/**
	 * Returns a list of Sections
	 * 
	 * @author Fantastic Five
	 */
	public static function getSectionList($idBlock) {
		$sections = \Section::get();
		return $sections;
	}
	
	/**
	 * Return a Section by ID
	 * 
	 * @author Fantastic Five
	 */
	public static function getSectionByID($id) {
		$section = \Section::find($id);
		return $section;
	}
	
	public static function saveSection($section) {
		return $section->save();
	}
	
	/**
	 * Delete Section
	 * 
	 * @author Fantatisc Five
	 */
	public static function deleteSection($id) {
				
		$queries = [
			'DELETE FROM student_section 
					WHERE  id_section = ?',
			'DELETE FROM section WHERE  id_section = ?',
				
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