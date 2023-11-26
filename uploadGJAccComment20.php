<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/GJPCheck.php";
require_once "lib/exploitPatch.php";

$userName = ExploitPatch::remove($_POST["userName"]);
$comment = ExploitPatch::remove($_POST["comment"]);
$accountID = GJPCheck::getAccountIDOrDie();
$uploadDate = time();
//usercheck
if($accountID != "" AND $comment != ""){
	$decodecomment = base64_decode($comment);
	$query = $db->prepare("INSERT INTO acccomments (userName, comment, accountID, timeStamp)
										VALUES (:userName, :comment, :accountID, :uploadDate)");
	$query->execute([':userName' => $userName, ':comment' => $comment, ':accountID' => $accountID, ':uploadDate' => $uploadDate]);
	echo 1;
}else{
	echo -1;
}
?>
