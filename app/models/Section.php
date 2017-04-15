<?php

/**
 * Section ORM Class
 *
 * @author Fantastic Five
 */
class Section extends Eloquent {
	
	const TRACK_MPP = "MPP";
	const TRACK_FPP = "FPP";
	const DEFAULT_CAPACITY = 30;
	
	protected $table = 'section';
	protected $primaryKey = 'id_section';
	public $timestamps = FALSE;
	
	// Relationship with Course
	public function course() {
		return $this->hasOne('Course', 'id_course', 'id_course');
	}
}