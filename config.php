<?php

function __autoload($classname){
	switch($classname[0])
	{
		case 'C':
			include_once("c/$classname.php");
			break;
		case 'M':
			include_once("m/$classname.php");
			break;
	}
}

define('BASE_URL', '/');
define('BASE_LAYOUT', 'v/v_main.php');
define('TITLE', 'Tasklist');

define('MYSQL_SERVER', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', '');
define('MYSQL_DB', 'tasklist');

