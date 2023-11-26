<?php
include "../lib/connection.php";
require "../lib/generatePass.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
//here im getting all the data
$ip = $gs->getIP();
$userName = ExploitPatch::remove($_POST["userName"]);
//registering
$query = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :userName");
$query->execute([':userName' => $userName]);
if($query->rowCount() == 0){
	exit("-1");
}
$id = $query->fetchColumn();

$pass = 0;
if(!empty($_POST["password"])) $pass = GeneratePass::isValidUsrname($userName, $_POST["password"]);
elseif(!empty($_POST["gjp2"])) $pass = GeneratePass::isGJP2ValidUsrname($userName, $_POST["gjp2"]);
if ($pass == 1) { //success
	//logging
	$query6 = $db->prepare("INSERT INTO actions (type, value, timestamp, value2) VALUES 
												('2',:username,:time,:ip)");
	$query6->execute([':username' => $userName, ':time' => time(), ':ip' => $ip]);
	//result
	echo $id.",".$id;
}elseif ($pass == -1){ //failure
	echo -12;
}else{
	echo -1;
}
?>