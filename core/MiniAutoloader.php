<?php

require_once(__DIR__.'/util/string.php');

function mini_autoloader($class_name) 
{
	//class directories
	$directorys = array(
		__DIR__.'/',
		__DIR__.'/auth/',
		__DIR__.'/protocol/',
	);
	
	foreach($directorys as $directory)
	{
		if(file_exists($directory.$class_name . '.php'))
		{
			require_once($directory.$class_name . '.php');
			return;
		}
	}
}
spl_autoload_register('mini_autoloader');
