<?php

/**
 * Entry ORM Class
 *
 * @author Fantastic Five
 */
class Entry extends Eloquent {
	
	protected $table = 'entry';
	protected $primaryKey = 'id_entry';
	public $timestamps = FALSE;

}