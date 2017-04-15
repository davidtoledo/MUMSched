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
			'DELETE FROM schedule     WHERE  id_schedule = ?',			
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