<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require "../lib/generatePass.php";
require_once "../lib/exploitPatch.php";
include_once "../config/security.php";
$password = !empty($_POST["password"]) ? $_POST["password"] : "";

if(empty($_POST["accountID"])) {
	$userName = ExploitPatch::remove($_POST["userName"]);
	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName");
	$query->execute([':userName' => $userName]);
	$accountID = $query->fetchColumn();
} else {
	$accountID = ExploitPatch::remove($_POST["accountID"]);
}

$pass = 0;
if(!empty($_POST["password"])) $pass = GeneratePass::isValid($accountID, $_POST["password"]);
elseif(!empty($_POST["gjp2"])) $pass = GeneratePass::isGJP2Valid($accountID, $_POST["gjp2"]);
if ($pass == 1) {

	if (!is_numeric($accountID)){
		exit("-1");
	}

	$query = $db->prepare("SELECT saveData FROM accounts WHERE accountID = :accountID AND saveData IS NOT NULL");
	$query->execute([':accountID' => $accountID]);
	if($query->rowCount() == 0){
		exit("-1");
	}

	$query = $db->prepare("SELECT saveData FROM accounts WHERE accountID = :accountID");
	$query->execute([':accountID' => $accountID]);
	$result = $query->fetchAll();
	$result = $result[0];
	$saveData = $result["saveData"];

	echo $saveData.";21;30;a;a";
}else{
	echo -2;
}
?>
