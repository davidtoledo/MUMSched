<?php

/**
 * FacultyCourse ORM Class
 *
 * @author Fantastic Five
 */
class FacultyCourse extends Eloquent {
	
	protected $table = 'faculty_course';
	protected $primaryKey = 'id_fc';
	public $timestamps = FALSE;
	
	// Relationship with Course
	public function course() {
		return $this->hasOne('Course', 'id_course', 'id_course');
	}

	// Relationship with SystemUser
	public function faculty() {
		return $this->hasOne('SystemUser', 'id_user', 'id_faculty');
	}
	
}