<?php

namespace MUMSched\Services;
use MUMSched\DAOs\UserDAO;

/**
 * Service class for System User
 *
 * @author Fantastic Five
 */
class UserService {


	/**
	 * Checks and returns an user by login
	 * 
	 * @author Fantastic Five
	 * 
	 */
	public static function getUserByLogin($login, $passwd) {
		return UserDAO::getUserByLogin($login, $passwd);
	}

	/**
	 * Returns a list of users
	 * 
	 * @author Fantastic Five 
	 */
	public static function getUserList() {
		return UserDAO::getUserList();
	}
	
	/**
	 * Get User by ID
	 * 
	 * @author Fantatisc Five
	 */
	public static function getUserByID($id) {
		return UserDAO::getUserByID($id);		
	}

	/**
	 * Get User by Username
	 * 
	 * @author Fantatisc Five
	 */
	public static function getUserByUsername($username) {
		return UserDAO::getUserByUsername($username);		
	}

	/**
	 * Delete User
	 * 
	 * @author Fantatisc Five
	 */
	public static function deleteUser($id) {
		return UserDAO::deleteUser($id);
	}
	
	public static function saveUser($user) {
		return UserDAO::saveUser($user);
	}
	
}
