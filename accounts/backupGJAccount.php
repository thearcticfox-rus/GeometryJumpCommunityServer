<?php
chdir(dirname(__FILE__));
set_time_limit(0);
ini_set("memory_limit","128M");
ini_set("post_max_size","50M");
ini_set("upload_max_filesize","50M");
include "../config/security.php";
include "../lib/connection.php";
require "../lib/generatePass.php";
require_once "../lib/exploitPatch.php";
//here im getting all the data
$userName = ExploitPatch::remove($_POST["userName"]);
$password = !empty($_POST["password"]) ? $_POST["password"] : "";
$saveData = ExploitPatch::remove($_POST["saveData"]);

if(empty($_POST["accountID"])) {
	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName");
	$query->execute([':userName' => $userName]);
	$accountID = $query->fetchColumn();
} else {
	$accountID = ExploitPatch::remove($_POST["accountID"]);
}

if(!is_numeric($accountID)){
	exit("-1");
}

$pass = 0;
if(!empty($_POST["password"])) $pass = GeneratePass::isValid($accountID, $_POST["password"]);
elseif(!empty($_POST["gjp2"])) $pass = GeneratePass::isGJP2Valid($accountID, $_POST["gjp2"]);
if ($pass == 1) {
	$saveDataArr = explode(";",$saveData); //splitting ccgamemanager and cclocallevels
	$saveData = str_replace("-","+",$saveDataArr[0]); //decoding
	$saveData = str_replace("_","/",$saveData);
	$saveData = base64_decode($saveData);
	$saveData = gzdecode($saveData);
	$saveData = gzencode($saveData); //encoding back
	$saveData = base64_encode($saveData);
	$saveData = str_replace("+","-",$saveData);
	$saveData = str_replace("/","_",$saveData);
	$saveData = $saveData . ";" . $saveDataArr[1]; //merging ccgamemanager and cclocallevels
	$query = $db->prepare("UPDATE `accounts` SET `saveData` = :saveData WHERE userName = :userName");
	$query->execute([':saveData' => $saveData, ':userName' => $userName]);
	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName LIMIT 1");
	$query->execute([':userName' => $userName]);
	$result = $query->fetchAll();
	$result = $result[0];
	$extID = $result["extID"];
	echo "1";
}
else
{
	echo -1;
}
?>
