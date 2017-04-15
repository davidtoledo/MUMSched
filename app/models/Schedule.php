<?php

/**
 * Schedule ORM Class
 *
 * @author Fantastic Five
 */
class Schedule extends Eloquent {
		
	// Status
	const STATUS_DRAFT = "D";
	const STATUS_OK = "O";
	
	// Algorithm Type
	const ALGORITHM_MUM_DEFAULT = 1;
	const ALGORITHM_ONLY_COMPUTER_SCIENCE = 2;
	
	// Block Order
	const BLOCK_ORDER_DEFAULT = 1;
	const BLOCK_ORDER_RANDOM = 2;
	
	protected $table = 'schedule';
	protected $primaryKey = 'id_schedule';
	public $timestamps = FALSE;
	
	// Relationship with Entry
	public function entry() {
		return $this->hasOne('Entry', 'id_entry', 'id_entry');
	}		
	
}