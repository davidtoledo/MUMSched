<?php

/**
 * Student ORM Class
 *
 * @author Fantastic Five
 */
class Student extends SystemUser {
	
	// Relationship with StudentSection
	public function sections() {
		return $this->hasMany('StudentSection', 'id_student', 'id_student');
	}
}