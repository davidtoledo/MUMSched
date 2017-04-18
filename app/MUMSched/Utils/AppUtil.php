<?php
namespace MUMSched\Utils;

/**
 * APP Utility Class
 *
 * @author Fantastic Five
 */
class AppUtil {
		
	// US date format to MySql format
	public static function date2db($str) {
		$date = date('Y-m-d', strtotime(str_replace('-', '/', $str)));		
		return $date;
	}	
 
}