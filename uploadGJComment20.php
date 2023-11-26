<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/GJPCheck.php";
require_once "lib/exploitPatch.php";
require_once "lib/commands.php";

$userName = !empty($_POST['userName']) ? ExploitPatch::remove($_POST['userName']) : "";
$gameVersion = !empty($_POST['gameVersion']) ? ExploitPatch::number($_POST['gameVersion']) : 0;
$comment = ExploitPatch::remove($_POST['comment']);
$levelID = ExploitPatch::number($_POST["levelID"]);

$accountID = GJPCheck::getAccountIDOrDie();
$uploadDate = time();
$decodecomment = base64_decode($comment);
if(Commands::doCommands($accountID, $decodecomment, $levelID)){
	exit("-1");
}
if($accountID != "" AND $comment != ""){
	$query = $db->prepare("INSERT INTO comments (userName, comment, levelID, accountID, timeStamp) VALUES (:userName, :comment, :levelID, :accountID, :uploadDate)");
	$query->execute([':userName' => $userName, ':comment' => $comment, ':levelID' => $levelID, ':accountID' => $accountID, ':uploadDate' => $uploadDate]);
	echo 1;
}else{
	echo -1;
}
?>
