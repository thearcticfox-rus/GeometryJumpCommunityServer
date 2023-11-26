<?php
//header
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/GJPCheck.php";
require_once "lib/exploitPatch.php";
require_once "lib/mainLib.php";
$gs = new mainLib();
require "lib/generateHash.php";

//initializing variables
$lvlstring = ""; $userstring = ""; $songsstring = ""; $lvlsmultistring = []; $str = ""; $order = "uploadDate";
$orderenabled = true;
$params = array();
$gameVersion = ExploitPatch::number($_POST["gameVersion"]);
if(!is_numeric($gameVersion)){
	exit("-1");
}
$binaryVersion = ExploitPatch::number($_POST["binaryVersion"]);
if($binaryVersion > 27){
	$gameVersion++;
}
if(!empty($_POST["type"])){
	$type = ExploitPatch::number($_POST["type"]);
}else{
	$type = 0;
}
if(!empty($_POST["diff"])){
	$diff = ExploitPatch::numbercolon($_POST["diff"]);
}else{
	$diff = "-";
}


//ADDITIONAL PARAMETERS
$params[] = "levels.gameVersion <= '$gameVersion'";

if(!empty($_POST["featured"]) AND $_POST["featured"]==1){
	$params[] = "starFeatured = 1";
}
if(!empty($_POST["original"]) AND $_POST["original"]==1){
	$params[] = "original = 0";
}
if(!empty($_POST["coins"]) AND $_POST["coins"]==1){
		$params[] = "starCoins = 1 AND NOT levels.coins = 0";
}
if(!empty($_POST["uncompleted"]) AND $_POST["uncompleted"]==1){
	$completedLevels = ExploitPatch::numbercolon($_POST["completedLevels"]);
	$params[] = "NOT levelID IN ($completedLevels)";
}
if(!empty($_POST["song"])){
	if(empty($_POST["customSong"])){
		$song = ExploitPatch::number($_POST["song"]);
		$song = $song -1;
		$params[] = "audioTrack = '$song' AND songID = 0";
	}else{
		$song = ExploitPatch::number($_POST["song"]);
		$params[] = "songID = '$song'";
	}
}
if(!empty($_POST["twoPlayer"]) AND $_POST["twoPlayer"]==1){
	$params[] = "twoPlayer = 1";
}
if(!empty($_POST["star"])){
	$params[] = "NOT starStars = 0";
}
if(!empty($_POST["noStar"])){
	$params[] = "starStars = 0";
}
if(!empty($_POST["len"])){
	$len = ExploitPatch::numbercolon($_POST["len"]);
}else{
	$len = "-";
}
if($len != "-" AND !empty($len)){
	$params[] = "levelLength IN ($len)";
}

//DIFFICULTY FILTERS
switch($diff){
	case -1:
		$params[] = "starDifficulty = '0'";
		break;
	case -3:
		$params[] = "starAuto = '1'";
		break;
	case -2:
		$params[] = "starDemon = 1";
		break;
	case "-";
		break;
	default:
		if($diff){
			$diff = str_replace(",", "0,", $diff) . "0";
			$params[] = "starDifficulty IN ($diff) AND starAuto = '0' AND starDemon = '0'";
		}
		break;
}
//TYPE DETECTION
if(!empty($_POST["str"])){
	$str = ExploitPatch::remove($_POST["str"]);
}
if(isset($_POST["page"]) AND is_numeric($_POST["page"])){
	$offset = ExploitPatch::number($_POST["page"]) . "0";
}else{
	$offset = 0;
}
switch($type){
	case 0:
		$order = "likes";
		if(!empty($str)){
			if(is_numeric($str)){
				$params = array("levelID = '$str'");
			}else{
				$params[] = "levelName LIKE '%$str%'";
			}
		}
		break;
	case 1:
		$order = "downloads";
		break;
	case 2:
		$order = "likes";
		break;
	case 3: //TRENDING
		$uploadDate = time() - (7 * 24 * 60 * 60);
		$params[] = "uploadDate > $uploadDate ";
		$order = "likes";
		break;
	case 5:
		$params[] = "levels.accountID = '$str'";
		break;
	case 6: //featured
		$params[] = "NOT starFeatured = 0";
		$order = "rateDate DESC,uploadDate";
		break;
	case 7: //MAGIC
		$params[] = "objects > 9999";
		break;
	case 10: //MAP PACKS
	case 19: //unknown but same as map packs (on real GD type 10 has star rated filter and 19 doesn't)
		$order = false;
		$params[] = "levelID IN ($str)";
		break;
	case 11: //AWARDED
		$params[] = "NOT starStars = 0";
		$order = "rateDate DESC,uploadDate";
		break;
	case 12: //FOLLOWED
		$followed = ExploitPatch::numbercolon($_POST["followed"]);
		$params[] = "accounts.accountID IN ($followed)";
		break;
	case 13: //FRIENDS
		$accountID = GJPCheck::getAccountIDOrDie();
		$peoplearray = $gs->getFriends($accountID);
		$whereor = implode(",", $peoplearray);
		$params[] = "accounts.accountID IN ($whereor)";
		break;
}
//ACTUAL QUERY EXECUTION
$querybase = "FROM levels LEFT JOIN songs ON levels.songID = songs.ID LEFT JOIN accounts ON levels.accountID = accounts.accountID";
if(!empty($params)){
	$querybase .= " WHERE (" . implode(" ) AND ( ", $params) . ")";
}
$query = "SELECT levels.*, songs.ID, songs.name, songs.authorID, songs.authorName, songs.size, songs.isDisabled, songs.download, accounts.userName, accounts.accountID $querybase";
if($order){
	$query .= "ORDER BY $order DESC";
}
$query .= " LIMIT 10 OFFSET $offset";
//echo $query;
$countquery = "SELECT count(*) $querybase";
//echo $query;
$query = $db->prepare($query);
$query->execute();
//echo $countquery;
$countquery = $db->prepare($countquery);
$countquery->execute();
$totallvlcount = $countquery->fetchColumn();
$result = $query->fetchAll();
$levelcount = $query->rowCount();
foreach($result as &$level1) {
	if($level1["levelID"]!=""){
		$lvlsmultistring[] = ["levelID" => $level1["levelID"], "stars" => $level1["starStars"], 'coins' => $level1["starCoins"]];
		$lvlstring .= "1:".$level1["levelID"].":2:".$level1["levelName"].":5:".$level1["levelVersion"].":6:".$level1["accountID"].":8:10:9:".$level1["starDifficulty"].":10:".$level1["downloads"].":12:".$level1["audioTrack"].":13:".$level1["gameVersion"].":14:".$level1["likes"].":17:".$level1["starDemon"].":25:".$level1["starAuto"].":18:".$level1["starStars"].":19:".$level1["starFeatured"].":45:".$level1["objects"].":3:".$level1["levelDesc"].":15:".$level1["levelLength"].":30:".$level1["original"].":31:".$level1['twoPlayer'].":37:".$level1["coins"].":38:".$level1["starCoins"].":39:".$level1["requestedStars"].":46:1:47:2:35:".$level1["songID"]."|";
		if($level1["songID"]!=0){
			$song = $gs->getSongString($level1);
			if($song){
				$songsstring .= $song . "~:~";
			}
		}
		$userstring .= $gs->getUserString($level1)."|";
	}
}
$lvlstring = substr($lvlstring, 0, -1);
$userstring = substr($userstring, 0, -1);
$songsstring = substr($songsstring, 0, -3);
echo $lvlstring."#".$userstring;
echo "#".$songsstring;
echo "#".$totallvlcount.":".$offset.":10";
echo "#";
echo GenerateHash::genMulti($lvlsmultistring);
?>
