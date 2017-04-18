<?php

namespace MUMSched\DAOs;
use Illuminate\Support\Facades\DB;

/**
 * Data Access Object for Block
 *
 * @author Fantastic Five
 */
class BlockDAO {

	/**
	 * Returns a list of Block
	 * 
	 * @author Fantastic Five
	 */
	public static function getBlockList() {
		$blocks = \Block::get();
		return $blocks;
	}

	/**
	 * Return a Block by ID
	 * 
	 * @author Fantastic Five
	 */
	public static function getBlockByID($id) {
		$blocks = \Block::find($id);
		return $blocks;
	}
	
	public static function saveBlock($block) {
		return $block->save();
	}
	
	/**
	 * Delete Block
	 * 
	 * @author Fantatisc Five
	 */
	public static function deleteBlock($id) {
				
		$queries = [
			'DELETE FROM entry WHERE  id_block = ?',		
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
	
}