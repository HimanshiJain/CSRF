<?php

	//if($_SERVER['HTTP_HOST']=="localhost:81") {
		defined('DB_SERVER') ? null : define('DB_SERVER', 'localhost');
		defined('DB_USER') ? null : define('DB_USER', 'root');
		defined('DB_PASS') ? null : define('DB_PASS', '');
		defined('DB_NAME') ? null : define('DB_NAME', 'csrf');
	/*} else {
		defined('DB_SERVER') ? null : define('DB_SERVER', $_SERVER['HTTP_HOST']);
		defined('DB_USER') ? null : define('DB_USER', '');
		defined('DB_PASS') ? null : define('DB_PASS', '');
		defined('DB_NAME') ? null : define('DB_NAME', '');
	}*/

?>