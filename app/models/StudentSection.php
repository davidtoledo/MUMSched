<?php

/**
 * StudentSection ORM Class
 *
 * @author Fantastic Five
 */
class StudentSection extends Eloquent {
	
	protected $table = 'student_section';
	protected $primaryKey = 'id_ss';
	public $timestamps = FALSE;
	
	// Relationship with student
	public function student() {
		return $this->hasOne('Student', 'id_user', 'id_user');
	}
	
	// Relationship with Section
	public function section() {
		return $this->hasOne('Section', 'id_section', 'id_section');
	}
	
}