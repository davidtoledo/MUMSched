<?php

/**
 * Specialization ORM Class
 *
 * @author Fantastic Five
 */
class Prerequisite extends Eloquent {
	
	protected $table = 'prerequisite';
	protected $primaryKey = 'id';
	public $timestamps = FALSE;
	
	// Relationship with course
	public function course(){
		 return $this->hasOne('Course', 'id_course', 'id_course');
	}
	
	// Relationship with Prerequisite Course
	public function prerequisite(){
		 return $this->hasOne('Course', 'id_course', 'id_prerequisite');
	}
	
}