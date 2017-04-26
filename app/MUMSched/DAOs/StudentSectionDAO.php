<?php

namespace MUMSched\DAOs;
use Illuminate\Support\Facades\DB;

/**
 * Data Access Object for StudentSection
 *
 * @author Fantastic Five
 */
class StudentSectionDAO {
	
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
	public static function getSectionsByStudentID($studentID) {
				$studentSections = \StudentSection::with("section")
							 ->with("student")
							 ->where("id_student", $studentID)
					  	     ->get();
		
		return $studentSections;
	}
	
	public static function getStudentSection($sectionID, $studentID) {
				$studentSection = \StudentSection::where("id_student", $studentID)
				->where("id_section", $sectionID)->first();
		
		return $studentSection;
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
					WHERE  id_ss = ?'
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