<?php

/**
 * Student ORM Class
 *
 * @author Fantastic Five
 */
class Student extends SystemUser {
	
	protected $table = 'system_user';
	protected $primaryKey = 'id_user';
	public $timestamps = FALSE;

}