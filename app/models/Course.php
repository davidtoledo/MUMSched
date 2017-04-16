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
	
}