<?php

namespace MUMSched\Services;
use MUMSched\DAOs\ScheduleDAO;

/**
 * Service class for Schedule
 *
 * @author Fantastic Five
 */
class ScheduleService {

	public static function getScheduleList() {
		return ScheduleDAO::getScheduleList();
	}
	
	public static function getScheduleByID($id) {
		return ScheduleDAO::getScheduleByID($id);		
	}

	public static function deleteSchedule($id) {
		return ScheduleDAO::deleteSchedule($id);
	}
	
	public static function saveSchedule($schedule) {
		return ScheduleDAO::saveSchedule($schedule);
	}
	
}