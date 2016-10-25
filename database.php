<?php
	// if (!defined ('_CONNECTED_')) {
		$db = new mysqli('localhost','cs143','','TEST');
		if ($db->connect_errno > 0) {
			die('Unable to connect to database [' . $db->connect_error . ']');
		}
	// 	define('_CONNECTED_',true);
	// }
?>