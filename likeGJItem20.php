<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/exploitPatch.php";
require_once "lib/mainLib.php";
$gs = new mainLib();

if(!isset($_POST['itemID']))
	exit(-1);

$type = isset($_POST['type']) ? $_POST['type'] : 1;
$itemID = ExploitPatch::remove($_POST['itemID']);
$isLike = isset($_POST['like']) ? $_POST['like'] : 1;
$ip = $gs->getIP();

switch($type){
	case 1:
		$table = "levels";
		$column = "levelID";
		break;
	case 2:
		$table = "comments";
		$column = "commentID";
		break;
	case 3:
		$table = "acccomments";
		$column = "commentID";
		break;
}

$query=$db->prepare("SELECT likes FROM $table WHERE $column = :itemID LIMIT 1");
$query->execute([':itemID' => $itemID]);
$likes = $query->fetchColumn();
if($isLike == 1)
	$sign = "+";
else
	$sign = "-";

$query=$db->prepare("UPDATE $table SET likes = likes $sign 1 WHERE $column = :itemID");
$query->execute([':itemID' => $itemID]);
echo "1";
?>