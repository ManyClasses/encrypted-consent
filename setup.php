<?php

ini_set('memory_limit','256M');

include('config.php');
include('add_keys.php');

ini_set("display_errors",1);
error_reporting(E_ALL);

// connect to sql database
$db = new PDO("mysql:host=$SERVERNAME;port=$PORT;dbname=$DBNAME", $USERNAME, $PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// check if table exists
$res = $db->query("SHOW TABLES LIKE '".$TABLE_NAME."';");
if($res->rowCount() == 0){
	$num_rows = add_keys($KEY_LENGTH, $db, $TABLE_NAME);
	echo "Created table with ".$num_rows." keys.";
} else {
	echo "No luck.";
}

?>