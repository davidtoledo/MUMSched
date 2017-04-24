<?php

/**
 * Specialization ORM Class
 *
 * @author Fantastic Five
 */
class Prerequisite extends Eloquent {
	
	protected $table = 'prerequisite';
	protected $primaryKey = 'id_prerequisite';
	public $timestamps = FALSE;
	
	//Relationship with course
	public function course(){
		 return $this->hasOne('Course', 'id_course', 'id_course');
	}
}