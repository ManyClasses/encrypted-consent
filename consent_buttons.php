<?php

include('config.php');

ini_set("display_errors",1);
error_reporting(E_ALL);

// Set the content-type
header('Content-Type: text/html');

echo("
<!DOCTYPE html>
<html>
<head>
<style>
label {
    font-family: \"LatoWeb\",\"Helvetica Neue\",Helvetica,Arial,sans-serif;
	font-size:16px;
	font-weight:400;
	line-height:24px;
}
</style>
</head>

<body>
");

// connect to database
$db = new PDO("mysql:host=$SERVERNAME;port=$PORT;dbname=$DBNAME", $USERNAME, $PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// check if table exists
$res = $db->query("SHOW TABLES LIKE '".$TABLE_NAME."';");
if($res->rowCount() == 0){
	echo("<p>Error. Please alert your instructor.</p>");
} else {
	echo("
	<table>
	<tr>
	<td>
	<label><input type=\"radio\" name=\"choice\" value=\"consent\"  onclick=\"myFunction('consent')\">I agree to participate and I authorize the release of these student records.</label>
	</td></tr>
	<tr><td style=\"padding-bottom:20px;\">
	<label><input type=\"radio\" name=\"choice\" value=\"dissent\"  onclick=\"myFunction('dissent')\">I do not agree to participate.</label>
	</td></tr>
	<tr><td style=\"border:solid 2px #44697D;text-align: center;\">
	<span style=\"font-size:42px;font-family:Helvetica,Arial,sans-serif;\" id=\"Value\">&nbsp;</span>
	</td></tr>
	</table>
	");
}
echo("</body>");

$consentVal_query = $db->query("SELECT codekey FROM ".$TABLE_NAME." WHERE used = 0 AND consent = 1 LIMIT 1;");
if($res = $consentVal_query->fetch(PDO::FETCH_ASSOC)){
	$consentVal = $res['codekey'];
	$db->exec("UPDATE ".$TABLE_NAME." SET used = 1 WHERE codekey = '".$consentVal."';");
} else {

}
$dissentVal_query = $db->query("SELECT codekey FROM ".$TABLE_NAME." WHERE used = 0 AND consent = 0 LIMIT 1;");
if($res = $dissentVal_query->fetch(PDO::FETCH_ASSOC)){
	$dissentVal = $res['codekey'];
	$db->exec("UPDATE ".$TABLE_NAME." SET used = 1 WHERE codekey = '".$dissentVal."';");
} else {

}

// Echo a script
echo("
<script>
function myFunction(choice) {
	if (choice == 'consent') {
		document.getElementById(\"Value\").innerHTML = \"".$consentVal."\";
	} else {
		document.getElementById(\"Value\").innerHTML = \"".$dissentVal."\";
	}
}
</script>

");
// Close the HTML
echo("
</html>
");
	
?>