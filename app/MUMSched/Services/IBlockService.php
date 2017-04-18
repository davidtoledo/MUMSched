<?php

namespace MUMSched\Services;

/**
 * Interface class for BlockService
 *
 * @author Fantastic Five
 */
interface IBlockService {
	public static function getBlockList();
	public static function getBlockByID($id);
	public static function deleteBlock($id);	
}