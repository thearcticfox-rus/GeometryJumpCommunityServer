<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/GJPCheck.php";
require_once "lib/exploitPatch.php";
require_once "lib/mainLib.php";

$levelID = ExploitPatch::remove($_POST["levelID"]);
$accountID = GJPCheck::getAccountIDOrDie();

if(!is_numeric($levelID)){
	exit("-1");
}

$query = $db->prepare("DELETE from levels WHERE levelID=:levelID AND accountID=:accountID AND starStars = 0 LIMIT 1");
$query->execute([':levelID' => $levelID, ':accountID' => $accountID]);
$query6 = $db->prepare("INSERT INTO actions (type, value, timestamp, value2) VALUES 
											(:type,:itemID, :time, :ip)");
$query6->execute([':type' => 8, ':itemID' => $levelID, ':time' => time(), ':ip' => $accountID]);
echo "1";
?>