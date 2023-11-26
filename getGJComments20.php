<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/exploitPatch.php";
require_once "lib/mainLib.php";
$gs = new mainLib();

$commentstring = "";
$userstring = "";
$users = array();

$binaryVersion = isset($_POST['binaryVersion']) ? ExploitPatch::remove($_POST["binaryVersion"]) : 0;
$gameVersion = isset($_POST['gameVersion']) ? ExploitPatch::remove($_POST["gameVersion"]) : 0;
$mode = isset($_POST["mode"]) ? ExploitPatch::remove($_POST["mode"]) : 0;
$count = (isset($_POST["count"]) AND is_numeric($_POST["count"])) ? ExploitPatch::remove($_POST["count"]) : 10;
$page = isset($_POST['page']) ? ExploitPatch::remove($_POST["page"]) : 0;

$commentpage = $page*$count;

if($mode==0)
	$modeColumn = "commentID";
else
	$modeColumn = "likes";

if(isset($_POST['levelID'])){
	$filterColumn = 'levelID';
	$filterToFilter = '';
	$displayLevelID = false;
	$filterID = ExploitPatch::remove($_POST["levelID"]);
	$userListJoin = $userListWhere = $userListColumns = "";
}
else
	exit(-1);

$countquery = "SELECT count(*) FROM comments $userListJoin WHERE ${filterToFilter}${filterColumn} = :filterID $userListWhere";
$countquery = $db->prepare($countquery);
$countquery->execute([':filterID' => $filterID]);
$commentcount = $countquery->fetchColumn();
if($commentcount == 0){
	exit("-2");
}


$query = "SELECT comments.levelID, comments.commentID, comments.timestamp, comments.comment, comments.accountID, comments.likes, comments.isSpam, accounts.userName, accounts.icon, accounts.color1, accounts.color2, accounts.iconType FROM comments LEFT JOIN accounts ON comments.accountID = accounts.accountID ${userListJoin} WHERE comments.${filterColumn} = :filterID ${userListWhere} ORDER BY comments.${modeColumn} DESC LIMIT ${count} OFFSET ${commentpage}";
$query = $db->prepare($query);
$query->execute([':filterID' => $filterID]);
$result = $query->fetchAll();
$visiblecount = $query->rowCount();

foreach($result as &$comment1) {
	if($comment1["commentID"]!=""){
		$uploadDate = date("d/m/Y G.i", $comment1["timestamp"]);
		$commentText = $comment1["comment"];
		if($displayLevelID) $commentstring .= "1~".$comment1["levelID"]."~";
		$commentstring .= "2~".$commentText."~3~".$comment1["accountID"]."~4~".$comment1["likes"]."~5~0~7~".$comment1["isSpam"]."~9~".$uploadDate."~6~".$comment1["commentID"];
		if ($comment1['userName']) {
			if(!in_array($comment1["accountID"], $users)){
				$users[] = $comment1["accountID"];
				$userstring .=  $comment1["accountID"] . ":" . $comment1["userName"] . ":" . $comment1["accountID"] . "|";
			}
			$commentstring .= "|";
		}
	}
}

$commentstring = substr($commentstring, 0, -1);
echo $commentstring;
$userstring = substr($userstring, 0, -1);
echo "#$userstring";
echo "#${commentcount}:${commentpage}:${visiblecount}";
?>
