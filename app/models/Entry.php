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
	
	// Relationship with Block
	public function blocks() {
		return $this->hasMany('Block', 'id_entry', 'id_entry');
	}

}