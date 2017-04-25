<?php

/**
 * Section ORM Class
 *
 * @author Fantastic Five
 */
class Section extends Eloquent {
	
	const TRACK_MPP = "MPP";
	const TRACK_FPP = "FPP";
	const TRACK_US = "US";
	const DEFAULT_CAPACITY = 30;
	
	protected $table = 'section';
	protected $primaryKey = 'id_section';
	public $timestamps = FALSE;
	
	// Relationship with Course
	public function course() {
		return $this->hasOne('Course', 'id_course', 'id_course');
	}
	
	// Relationship with Block
	public function block() {
		return $this->hasOne('Block', 'id_block', 'id_block');
	}
	
	// Relationship with Faculty
	public function faculty() {
		return $this->hasOne('SystemUser', 'id_user', 'id_faculty');
	}
	
	// Relationship with StudentSection
	public function students() {
		return $this->hasMany('StudentSection', 'id_section', 'id_section');
	}
	
}