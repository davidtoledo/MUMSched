<?php

namespace MUMSched\Services;
use MUMSched\DAOs\UserDAO;

/**
 * Service class for System User
 *
 * @author Fantastic Five
 */
class UserService {

	public static function getUserByLogin($login, $passwd) {
		return UserDAO::getUserByLogin($login, $passwd);
	}

	public static function getUserList() {
		return UserDAO::getUserList();
	}
	
	public static function getUserByID($id) {
		return UserDAO::getUserByID($id);		
	}

	public static function getUserByUsername($username) {
		return UserDAO::getUserByUsername($username);		
	}

	public static function deleteUser($id) {
		return UserDAO::deleteUser($id);
	}
	
	public static function saveUser($user) {
		return UserDAO::saveUser($user);
	}

	public static function getUserWithSpecializations($id_user) {
		return UserDAO::getUserWithSpecializations($id_user);
	}

	public static function deleteFacultySpecialization($id) {
		return UserDAO::deleteFacultySpecialization($id);
	}

	public static function getFacultySpecialization($id_user, $id_specialization) {
		return UserDAO::getFacultySpecialization($id_user, $id_specialization);
	}
	
}