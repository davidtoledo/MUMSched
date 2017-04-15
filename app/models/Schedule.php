<?php

/**
 * Schedule ORM Class
 *
 * @author Fantastic Five
 */
class Schedule extends Eloquent {
	
	const STATUS_DRAFT = "D";
	const STATUS_OK = "O";
	
	protected $table = 'schedule';
	protected $primaryKey = 'id_schedule';
	public $timestamps = FALSE;
	
	// Relationship with Entry
	public function entry() {
		return $this->hasOne('Entry', 'id_entry', 'id_entry');
	}		
	
}