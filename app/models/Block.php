<?php

/**
 * Block ORM Class
 *
 * @author Fantastic Five
 */
class Block extends Eloquent {
	
	protected $table = 'block';
	protected $primaryKey = 'id_block';
	public $timestamps = FALSE;
	
	// Relationship with Entry
	public function entry() {
		return $this->belongsTo('Entry', 'id_entry', 'id_entry');
	}		

	// Relationship with Section
	public function sections() {
		return $this->hasMany('Section', 'id_block', 'id_block');
	}		

}