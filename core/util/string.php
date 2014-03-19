<?php 
function stringify($obj){
	if(is_bool($obj)) return $obj?'TRUE':'FALSE';
	else if(is_null($obj)) return "NULL";
	else if(is_array($obj)) return json_encode($obj, 128);
	else return $obj;
}
?>