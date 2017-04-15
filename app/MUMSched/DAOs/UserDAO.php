<?php

namespace MUMSched\DAOs;
use Illuminate\Support\Facades\DB;

/**
 * Data Access Object for System User
 *
 * @author Fantastic Five
 */
class UserDAO {

	/**
	 * Checks and returns an user by login
	 * 
	 * @author Fantastic Five
	 * 
	 */
	public static function getUserByLogin($login, $passwd) {
		
		$user = \SystemUser::where("username", $login)
		  				   ->where("password", $passwd)
						   ->first();

		return $user;
	}

	/**
	 * Returns a list of users
	 * 
	 * @author Fantastic Five
	 */
	public static function getUserList() {
		$users = \SystemUser::all();
		return $users;
	}

	/**
	 * Return a User by ID
	 * 
	 * @author Fantastic Five
	 */
	public static function getUserByID($id) {
		$user = \SystemUser::with("specializations")
						   ->find($id);
		return $user;
	}

	/**
	 * Return a User by Username
	 * 
	 * @author Fantastic Five
	 */
	public static function getUserByUsername($username) {
		$user = \SystemUser::where("username", $username)->first();
		return $user;
	}
	
	public static function saveUser($user) {
		return $user->save();
	}
	
	/**
	 * Delete User
	 * 
	 * @author Fantatisc Five
	 */
	public static function deleteUser($id) {
		
		// Avoid delete Admin Master
		if ($id == 1) {
			return new \Exception("You cannot remove the Admin Master.");
		}
		
		$queries = [
			'DELETE FROM faculty_specialization     WHERE  id_faculty = ?',
			'DELETE FROM system_user                WHERE  id_user = ?',			
		];
		
		try	{
			
			foreach ($queries as $query) {
				DB::delete($query, [
					$id
				]);
			}
			
			DB::commit();
			return TRUE;
		}
		catch (\Exception $e)
		{
			DB::rollback();
			return $e;
		}
		
	}
	
	public static function getUserWithSpecializations($id_user) {
		
		$user = \SystemUser::with("specializations")
			       	       ->find($id_user);
			      	      
		return $user;
	}
	
	/**
	 * Delete a Faculty Specialization Association
	 *
	 * @author Fantastic Five
	 */
	public static function deleteFacultySpecialization($id) {
		
		$queries = [
			'DELETE FROM faculty_specialization WHERE id_fs = ?',
		];
		
		try	{
			
			foreach ($queries as $query) {
				DB::delete($query, [
					$id
				]);
			}
			DB::commit();
			return TRUE;
		}
		catch (\Exception $e)
		{
			DB::rollback();
			return $e;
		}
	}			
	
	/**
	 * Get a Faculty Specialization Association
	 *
	 * @author Fantastic Five
	 */
	public static function getFacultySpecialization($id_user, $id_specialization) {
		
		$fs = \FacultySpecialization::where("id_faculty", $id_user)
						   			->where("id_specialization", $id_specialization)
						   			->first();
		return ($fs);
	}
	
	
}