<?php

/**
 * FacultySpecialization ORM Class
 *
 * @author Fantastic Five
 */
class FacultySpecialization extends Eloquent {
	
	protected $table = 'faculty_specialization';
	protected $primaryKey = 'id_fs';
	public $timestamps = FALSE;
	
	// Relationship with Specialization
	public function specialization() {
		return $this->hasOne('Specialization', 'id_specialization', 'id_specialization');
	}

	// Relationship with SystemUser
	public function faculty() {
		return $this->hasOne('SystemUser', 'id_user', 'id_faculty');
	}
	
}