<?php

namespace MUMSched\Services;
use MUMSched\DAOs\BlockDAO;

/**
 * Service class for Block
 *
 * @author Fantastic Five
 */
class BlockService implements IBlockService {

	public static function getBlockList() {
		return BlockDAO::getBlockList();
	}
	
	public static function getBlockByID($id) {
		return BlockDAO::getBlockByID($id);
	}

	public static function deleteBlock($id) {
		return BlockDAO::deleteBlock($id);
	}	
	
	public static function saveBlock($block) {
		return BlockDAO::saveBlock($block);
	}
}