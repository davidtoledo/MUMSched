<?php

/**
 * Student ORM Class
 *
 * @author Fantastic Five
 */
class Student extends Eloquent {
	
	protected $table = 'system_user';
	protected $primaryKey = 'id_user';
	public $timestamps = FALSE;

}