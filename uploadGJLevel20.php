<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/GJPCheck.php";
require_once "lib/exploitPatch.php";
require_once "lib/mainLib.php";
$gs = new mainLib();
//here im getting all the data
$gjp = ExploitPatch::remove($_POST["gjp"]);
$gameVersion = ExploitPatch::remove($_POST["gameVersion"]);
$userName = ExploitPatch::charclean($_POST["userName"]);
$levelID = ExploitPatch::remove($_POST["levelID"]);
$levelName = ExploitPatch::charclean($_POST["levelName"]);
//TODO: move description fixing code to a function
$levelDesc = ExploitPatch::remove($_POST["levelDesc"]);
$rawDesc = str_replace('-', '+', $levelDesc);
$rawDesc = str_replace('_', '/', $rawDesc);
$rawDesc = base64_decode($rawDesc);
if (strpos($rawDesc, '<c') !== false) {
	$tags = substr_count($rawDesc, '<c');
	if ($tags > substr_count($rawDesc, '</c>')) {
		$tags = $tags - substr_count($rawDesc, '</c>');
		for ($i = 0; $i < $tags; $i++) {
			$rawDesc .= '</c>';
		}
		$levelDesc = str_replace('+', '-', base64_encode($rawDesc));
		$levelDesc = str_replace('/', '_', $levelDesc);
	}
}
$levelVersion = ExploitPatch::remove($_POST["levelVersion"]);
$levelLength = ExploitPatch::remove($_POST["levelLength"]);
$audioTrack = ExploitPatch::remove($_POST["audioTrack"]);

$binaryVersion = !empty($_POST["binaryVersion"]) ? ExploitPatch::remove($_POST["binaryVersion"]) : 0;

$original = !empty($_POST["original"]) ? ExploitPatch::remove($_POST["original"]) : 0;
$twoPlayer = !empty($_POST["twoPlayer"]) ? ExploitPatch::remove($_POST["twoPlayer"]) : 0;
$songID = !empty($_POST["songID"]) ? ExploitPatch::remove($_POST["songID"]) : 0;
$objects = !empty($_POST["objects"]) ? ExploitPatch::remove($_POST["objects"]) : 0;
$coins = !empty($_POST["coins"]) ? ExploitPatch::remove($_POST["coins"]) : 0;
$requestedStars = !empty($_POST["requestedStars"]) ? ExploitPatch::remove($_POST["requestedStars"]) : 0;
$levelString = ExploitPatch::remove($_POST["levelString"]);
//TODO: optionally utilize the 1.9 parameter instead
$levelInfo = !empty($_POST["levelInfo"]) ? ExploitPatch::remove($_POST["levelInfo"]) : "";

if(isset($_POST["password"])){
	$password = ExploitPatch::remove($_POST["password"]);
}else{
	$password = 1;
	if($gameVersion > 17){
		$password = 0;
	}
}
$hostname = $gs->getIP();
$accountID = GJPCheck::getAccountIDOrDie();
$uploadDate = time();
$query = $db->prepare("SELECT count(*) FROM levels WHERE uploadDate > :time AND (accountID = :accountID OR hostname = :ip)");
$query->execute([':time' => $uploadDate - 60, ':accountID' => $accountID, ':ip' => $hostname]);
if($query->fetchColumn() > 0){
	exit("-1");
}
$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, password, original, twoPlayer, songID, objects, coins, requestedStars, levelString, levelInfo, uploadDate, accountID, updateDate, hostname)
VALUES (:levelName, :gameVersion, :binaryVersion, :userName, :levelDesc, :levelVersion, :levelLength, :audioTrack, :password, :original, :twoPlayer, :songID, :objects, :coins, :requestedStars, :levelString, :levelInfo, :uploadDate, :accountID, :uploadDate, :hostname)");


if($levelString != "" AND $levelName != ""){
	$querye=$db->prepare("SELECT levelID FROM levels WHERE levelName = :levelName AND accountID = :accountID");
	$querye->execute([':levelName' => $levelName, ':accountID' => $accountID]);
	$levelID = $querye->fetchColumn();
	$lvls = $querye->rowCount();
	if($lvls==1){
		$query = $db->prepare("UPDATE levels SET levelName=:levelName, gameVersion=:gameVersion,  binaryVersion=:binaryVersion, userName=:userName, levelDesc=:levelDesc, levelVersion=:levelVersion, levelLength=:levelLength, audioTrack=:audioTrack, password=:password, original=:original, twoPlayer=:twoPlayer, songID=:songID, objects=:objects, coins=:coins, requestedStars=:requestedStars, levelString=:levelString, levelInfo=:levelInfo, updateDate=:uploadDate, hostname=:hostname WHERE levelName=:levelName AND accountID=:accountID");	
		$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':levelString' => $levelString, ':levelInfo' => $levelInfo, ':levelName' => $levelName, ':accountID' => $accountID, ':uploadDate' => $uploadDate, ':hostname' => $hostname]);
		echo $levelID;
	}else{
		$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':levelString' => $levelString, ':levelInfo' => $levelInfo, ':uploadDate' => $uploadDate, ':accountID' => $accountID, ':hostname' => $hostname]);
		$levelID = $db->lastInsertId();
		echo $levelID;
	}
}else{
	echo -1;
}
?>
