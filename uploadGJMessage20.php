<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/GJPCheck.php";
require_once "lib/exploitPatch.php";

$gameVersion =  ExploitPatch::remove($_POST["gameVersion"]);
$binaryVersion =  ExploitPatch::remove($_POST["binaryVersion"]);
$subject =  ExploitPatch::remove($_POST["subject"]);
$toAccountID =  ExploitPatch::number($_POST["toAccountID"]);
$body =  ExploitPatch::remove($_POST["body"]);
$accountID =  GJPCheck::getAccountIDOrDie();
if($accountID == $toAccountID){
	exit("-1");
}
$query3 = "SELECT userName FROM accounts WHERE accountID = :accountID ORDER BY userName DESC";
$query3 = $db->prepare($query3);
$query3->execute([':accountID' => $accountID]);
$userName = $query3->fetchColumn();
//continuing the accounts system
$accountID = ExploitPatch::remove($_POST["accountID"]);
$register = 1;
$uploadDate = time();

$blocked = $db->query("SELECT ID FROM `blocks` WHERE person1 = $toAccountID AND person2 = $accountID")->fetchAll(PDO::FETCH_COLUMN);
$mSOnly = $db->query("SELECT mS FROM `accounts` WHERE accountID = $toAccountID AND mS > 0")->fetchAll(PDO::FETCH_COLUMN);
$friend = $db->query("SELECT ID FROM `friendships` WHERE (person1 = $accountID AND person2 = $toAccountID) || (person2 = $accountID AND person1 = $toAccountID)")->fetchAll(PDO::FETCH_COLUMN);

$query = $db->prepare("INSERT INTO messages (subject, body, accountID, userName, toAccountID, timestamp)
VALUES (:subject, :body, :accountID, :userName, :toAccountID, :uploadDate)");

if (!empty($mSOnly[0]) and $mSOnly[0] == 2) {
    echo -1;
} else {
    if (empty($blocked[0]) and (empty($mSOnly[0]) || !empty($friend[0]))) {
        $query->execute([':subject' => $subject, ':body' => $body, ':accountID' => $accountID, ':userName' => $userName, ':toAccountID' => $toAccountID, ':uploadDate' => $uploadDate]);
        echo 1;
    } else {
        echo -1;
    }
}
?>