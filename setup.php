<?php

include('config.php');
include('add_keys.php');

ini_set("display_errors",1);
error_reporting(E_ALL);

// connect to sqlite database
$db = new PDO("mysql:host=$SERVERNAME;port=$PORT;dbname=$DBNAME", $USERNAME, $PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// check if table exists
$table_exists_query = $db->query("SELECT * FROM sqlite_master WHERE name='".$TABLE_NAME."' AND type='table';");
if(!($res = $table_exists_query->fetchArray())){
	$num_rows = add_keys($KEY_LENGTH, $db, $TABLE_NAME);
	echo "Created table with ".$num_rows." keys.";
}


	
?>