<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * User ORM Class
 *
 * @author Fantastic Five
 */
class SystemUser extends Eloquent implements UserInterface, RemindableInterface {

	// Types
	const TYPE_FACULTY = "F";
	const TYPE_STUDENT = "S";
	
	protected $table = 'system_user';
	protected $primaryKey = 'id_user';
	public $timestamps = FALSE;
	
	// Relationship with FacultySpecialization
	public function specializations() {
		return $this->hasMany('FacultySpecialization', 'id_faculty', 'id_user');
	}		

	protected $hidden = array(
		'password'
	);

	public static $passwordAttributes = array(
		'password'
	);

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier() {
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword() {
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken() {
		return $this->access_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param string $value
	 * @return void
	 */
	public function setRememberToken($value) {
		$this->access_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName() {
		return 'access_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail() {
		return $this->email;
	}	
}