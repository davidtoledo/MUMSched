<?php

namespace MUMSched\Services;

/**
 * Interface class for ScheduleService
 *
 * @author Fantastic Five
 */
interface IScheduleService {
	
	public static function getScheduleList();
	public static function getScheduleByID($id);
	public static function deleteSchedule($id);
	public static function saveSchedule($schedule);
	public static function generate ($id_schedule, $algorithm_type, $block_order);
	
}