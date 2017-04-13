<?php

/**
 * Faculty ORM Class
 *
 * @author Fantastic Five
 */
class Faculty extends Eloquent {
	
	protected $table = 'system_user';
	protected $primaryKey = 'id_user';
	public $timestamps = FALSE;

}