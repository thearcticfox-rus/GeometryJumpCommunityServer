<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/GJPCheck.php";
require_once "lib/exploitPatch.php";

$commentID = ExploitPatch::remove($_POST["commentID"]);
$accountID = GJPCheck::getAccountIDOrDie();

$query = $db->prepare("DELETE FROM comments WHERE commentID=:commentID AND accountID=:accountID LIMIT 1");
$query->execute([':commentID' => $commentID, ':accountID' => $accountID]);
if($query->rowCount() == 0){
	$query = $db->prepare("SELECT accounts.accountID FROM comments INNER JOIN levels ON levels.levelID = comments.levelID INNER JOIN accounts ON levels.accountID = accounts.accountID WHERE commentID = :commentID");
	$query->execute([':commentID' => $commentID]);
	$creatorAccID = $query->fetchColumn();
	if($creatorAccID == $accountID){
		$query = $db->prepare("DELETE FROM comments WHERE commentID=:commentID LIMIT 1");
		$query->execute([':commentID' => $commentID]);
	}
}
echo "1";
