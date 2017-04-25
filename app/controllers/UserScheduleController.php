<?php

use MUMSched\Services\UserService;
use MUMSched\Services\ScheduleService;

/**
 * User Schedule Controller
 *
 * @author Fantastic Five
 */
class UserScheduleController extends BaseController {
		
	/**
	 * List User Schedules
	 *
	 * @author Fantastic Five
	 */
	public function showList($id_user) {
		
		// Get schedules
		$schedules = ScheduleService::getScheduleList();
	
		$user = SystemUser::find($id_user);
		
		$this->data['schedules'] = & $schedules;
		$this->data['user'] = & $user;
		
		return View::make('admin.user.list-schedule')->with($this->data);
		
		
	}
	
	
}