<?php

function add_keys($key_length, $db, $table){
    // create data to populate table
    $consentdata = array();
    $consentkeys = range(0, 10**($key_length)-1);
    shuffle($consentkeys);
    for($i = 0; $i < count($consentkeys); $i++){
        $consentdata[] = array(
            'key' => str_pad(strval($consentkeys[$i]), $key_length, '0', STR_PAD_LEFT),
            'consent' => rand(0,1),
            'used' => 0
        );
    }

    // create table
    $db->exec("CREATE TABLE IF NOT EXISTS ".$table." (
        id INTEGER PRIMARY KEY,
        key VARCHAR(255),
        consent TINYINT,
        used TINYINT
    )");

    // start transaction
    $db->exec("BEGIN;");

    // add values
    $insert = "INSERT INTO ".$table." (key, consent, used) VALUES (:key, :consent, :used)";
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
    $db->exec("COMMIT;");

    $success_query = $db->query("SELECT COUNT(key) as count FROM ".$table.";");
    $nrows = $success_query->fetchArray()['count'];
    return($nrows);
}

?>