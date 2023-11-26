<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/GJPCheck.php";
require_once "lib/exploitPatch.php";

$accountID = GJPCheck::getAccountIDOrDie();
$messageID = ExploitPatch::remove($_POST["messageID"]);

$query=$db->prepare("SELECT accountID, toAccountID, timestamp, userName, messageID, subject, isNew, body FROM messages WHERE messageID = :messageID AND (accountID = :accountID OR toAccountID = :accountID) LIMIT 1");
$query->execute([':messageID' => $messageID, ':accountID' => $accountID]);
$result = $query->fetch();
if($query->rowCount() == 0){
	exit("-1");
}
if(empty($_POST["isSender"])){
	$query=$db->prepare("UPDATE messages SET isNew=1 WHERE messageID = :messageID AND toAccountID = :accountID");
	$query->execute([':messageID' => $messageID, ':accountID' =>$accountID]);
	$accountID = $result["accountID"];
	$isSender = 0;
}else{
	$isSender = 1;
	$accountID = $result["toAccountID"];
}
$query=$db->prepare("SELECT userName,accountID FROM accounts WHERE accountID = :accountID");
$query->execute([':accountID' => $accountID]);
$result12 = $query->fetch();
$uploadDate = date("d/m/Y G.i", $result["timestamp"]);
echo "6:".$result12["userName"].":3:".$result12["accountID"].":2:".$result12["accountID"].":1:".$result["messageID"].":4:".$result["subject"].":8:".$result["isNew"].":9:".$isSender.":5:".$result["body"].":7:".$uploadDate."";
?>