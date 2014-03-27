<?php 
/**
 * Utility functions
 * @author yinli
 *
 */

namespace MiniApi\Utils;

class MiniUtils{

	/**
	 * Return a string representation of any PHP type for output
	 * @param mixed $obj
	 * @param int $options
	 * @return string
	 * @see json_encode()
	 */
	public static function stringify($obj, $options=0){
		if(is_bool($obj)) return $obj?'TRUE':'FALSE';
		else if(is_null($obj)) return "NULL";
		else if(is_array($obj)) return json_encode($obj, $options);
		else return $obj;
	}
}
?>