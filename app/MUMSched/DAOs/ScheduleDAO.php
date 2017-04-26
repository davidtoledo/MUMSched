<?php

namespace MUMSched\DAOs;
use Illuminate\Support\Facades\DB;

/**
 * Data Access Object for Schedule
 *
 * @author Fantastic Five
 */
class ScheduleDAO {

	/**
	 * Returns a list of schedules
	 * 
	 * @author Fantastic Five
	 */
	public static function getScheduleList() {
		$users = \Schedule::with("entry")
						  ->get();
		return $users;
	}

	/**
	 * Return a Schedule by ID
	 * 
	 * @author Fantastic Five
	 */
	public static function getScheduleByID($id) {
		$schedule = \Schedule::find($id);
		return $schedule;
	}
	
	public static function saveSchedule($schedule) {
		return $schedule->save();
	}
	
	/**
	 * Delete Schedule
	 * 
	 * @author Fantatisc Five
	 */
	public static function deleteSchedule($id) {
				
		$queries = [
		   'DELETE FROM student_section 
			WHERE id_section IN (SELECT id_block FROM block WHERE id_entry IN 
								   (SELECT id_entry FROM entry WHERE id_entry IN
					 				  (SELECT id_entry FROM schedule WHERE id_schedule = ?
									   )
									)
								)',

			'DELETE FROM section 
			 WHERE id_block IN (SELECT id_block FROM block WHERE id_entry IN 
								 (SELECT id_entry FROM entry WHERE id_entry IN
					 				(SELECT id_entry FROM schedule WHERE id_schedule = ?
									) 
								 ) 
							   )',
							   
			'DELETE FROM schedule WHERE  id_schedule = ?',			
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