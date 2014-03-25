<?php 
/**
 * Utility functions
 * @author yinli
 *
 */

/**
 * Return a string representation of any PHP type for output
 * @param mixed $obj
 * @param int $options
 * @return string
 * @see json_encode()
 */
function stringify($obj, $options=0){
	if(is_bool($obj)) return $obj?'TRUE':'FALSE';
	else if(is_null($obj)) return "NULL";
	else if(is_array($obj)) return json_encode($obj, $options);
	else return $obj;
}
?>