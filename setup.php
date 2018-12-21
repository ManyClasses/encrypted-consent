<?php

include('config.php');

// connect to sqlite database
$db = new SQLite3($DB_NAME.".sqlite");

// check if table exists
$table_exists_query = $db->query("SELECT * FROM sqlite_master WHERE name='".$TABLE_NAME."' AND type='table';");
if(!($res = $table_exists_query->fetchArray())){
	// create data to populate table
	$consentdata = array();
	$consentkeys = range(0, 10**($KEY_LENGTH-1));
	shuffle($consentkeys);
	for($i = 0; $i < count($consentkeys); $i++){
		$consentdata[] = array(
			'key' => str_pad(strval($consentkeys[$i]), $KEY_LENGTH, '0'),
			'consent' => rand(0,1),
			'used' => 0
		);
	}

	// create table
	$db->exec("CREATE TABLE IF NOT EXISTS ".$TABLE_NAME." (
		id INTEGER PRIMARY KEY,
		key VARCHAR(255),
		consent TINYINT,
		used TINYINT
	)");

	// add values
	$insert = "INSERT INTO ".$TABLE_NAME." (key, consent, used) VALUES (:key, :consent, :used)";
	$statement = $db->prepare($insert);
	$statement->bindParam(':key',$key);
	$statement->bindParam(':consent',$consent);
	$statement->bindParam(':used',$used);
	foreach($consentdata as $item){
		$key = $item['key'];
		$consent = $item['consent'];
		$used = $item['used'];

		$statement->execute();
	}

	$success_query = $db->query("SELECT COUNT(key) as count FROM ".$TABLE_NAME.";");
	$nrows = $success_query->fetchArray()['count'];
	echo "Created database with ".$nrows." keys";
	
}


	
?>