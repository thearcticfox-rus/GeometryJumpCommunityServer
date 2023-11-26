<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/exploitPatch.php";
require_once "lib/mainLib.php";
$gs = new mainLib();
$commentstring = "";
$accountID = ExploitPatch::remove($_POST["accountID"]);
$page = ExploitPatch::remove($_POST["page"]);
$commentpage = $page*10;
$query = "SELECT comment, accountID, likes, isSpam, commentID, timestamp FROM acccomments WHERE accountID = :accountID ORDER BY timeStamp DESC LIMIT 10 OFFSET $commentpage";
$query = $db->prepare($query);
$query->execute([':accountID' => $accountID]);
$result = $query->fetchAll();
if($query->rowCount() == 0){
	exit("#0:0:0");
}
$countquery = $db->prepare("SELECT count(*) FROM acccomments WHERE accountID = :accountID");
$countquery->execute([':accountID' => $accountID]);
$commentcount = $countquery->fetchColumn();
foreach($result as &$comment1) {
	if($comment1["commentID"]!=""){
		$uploadDate = date("d/m/Y G:i", $comment1["timestamp"]);
		$commentstring .= "2~".$comment1["comment"]."~3~".$comment1["accountID"]."~4~".$comment1["likes"]."~5~0~7~".$comment1["isSpam"]."~9~".$uploadDate."~6~".$comment1["commentID"]."|";
	}
}
$commentstring = substr($commentstring, 0, -1);
echo $commentstring;
echo "#".$commentcount.":".$commentpage.":10";
?>