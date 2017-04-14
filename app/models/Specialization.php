<?php

/**
 * Specialization ORM Class
 *
 * @author Fantastic Five
 */
class Specialization extends Eloquent {
	
	protected $table = 'specialization';
	protected $primaryKey = 'id_specialization';
	public $timestamps = FALSE;
}