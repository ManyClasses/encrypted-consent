<?php

function add_keys($key_length, $db, $table){
    // create data to populate table
    $consentkeys = range(0, 10**($key_length)-1);
    shuffle($consentkeys);
    for($i = 0; $i < count($consentkeys); $i++){
		$consentkeys[$i] = str_pad(strval($consentkeys[$i]), $key_length, '0', STR_PAD_LEFT);		
	}
    // create table
    $db->exec("CREATE TABLE IF NOT EXISTS ".$table." (
        id INTEGER PRIMARY KEY AUTO_INCREMENT,
        codekey VARCHAR(255),
        consent TINYINT,
        used TINYINT
    )");

    // start transaction
    $db->exec("BEGIN;");

    // add values
    $insert = "INSERT INTO ".$table." (codekey, consent, used) VALUES (:key, floor(rand()*2), 0)";
    $statement = $db->prepare($insert);
    $statement->bindParam(':key', $key);
    for($i = 0; $i < count($consentkeys); $i++){
        $key = $consentkeys[$i];
        $statement->execute();
    }
    $db->exec("COMMIT;");

    $success_query = $db->query("SELECT COUNT(codekey) as count FROM ".$table.";");
    $nrows = $success_query->fetch(PDO::FETCH_ASSOC)['count'];
    return($nrows);
}

?>