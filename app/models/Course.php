<?php

/**
 * Course ORM Class
 *
 * @author Fantastic Five
 */
class Course extends Eloquent {
	
	const COURSE_SCI_CODE = "SCI";
	const COURSE_MPP_CODE = "401";
	const COURSE_FPP_CODE = "390";
	const COURSE_CRS_CODE = "CRS";
	
	protected $table = 'course';
	protected $primaryKey = 'id_course';
	public $timestamps = FALSE;
	
	// Relationship with FacultyCourse
	public function faculties() {
		return $this->hasMany('FacultyCourse', 'id_course', 'id_course');
	}

	// Relationship with Specialization
	public function specialization() {
		return $this->hasOne('Specialization', 'id_specialization', 'id_specialization');
	}
	
	//Relationship with Prerequisite
	public function prerequisites(){
		return $this->hasMany('Prerequisite','id_prerequisite','id_prerequisite');
	}
	
	//Relationship with Sections
	public function sections(){
		return $this->hasMany('Section','id_section','id_section');
	}
	
}