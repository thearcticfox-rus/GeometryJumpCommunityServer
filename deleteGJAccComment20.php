<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/GJPCheck.php";
require_once "lib/exploitPatch.php";

$commentID = ExploitPatch::remove($_POST["commentID"]);
$accountID = GJPCheck::getAccountIDOrDie();

if($gs->checkPermission($accountID, "actionDeleteComment") == 1) {
	$query = $db->prepare("DELETE FROM acccomments WHERE commentID = :commentID LIMIT 1");
	$query->execute([':commentID' => $commentID]);
}else{
	$query = $db->prepare("DELETE FROM acccomments WHERE commentID=:commentID AND accountID=:accountID LIMIT 1");
	$query->execute([':accountID' => $accountID, ':commentID' => $commentID]);
}
echo "1";