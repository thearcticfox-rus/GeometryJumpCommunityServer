<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/exploitPatch.php";
require_once "lib/GJPCheck.php";
$stars = 0;
$count = 0;
$xi = 0;
$lbstring = "";

if(!empty($_POST["accountID"])){
	$accountID = GJPCheck::getAccountIDOrDie();
}

$type = ExploitPatch::remove($_POST["type"]);
if($type == "top" OR $type == "creators" OR $type == "relative"){
	if($type == "top"){
		$query = $db->prepare("SELECT * FROM accounts WHERE isBanned = '0' AND gameVersion > 19 AND stars > 0 ORDER BY stars DESC LIMIT 100");
		$query->execute();
	}
	if($type == "creators"){
		$query = $db->prepare("SELECT * FROM accounts WHERE isCreatorBanned = '0' AND creatorPoints > 0 ORDER BY creatorPoints DESC LIMIT 100");
		$query->execute();
	}
	if($type == "relative"){
		$query = "SELECT * FROM accounts WHERE accountID = :accountID";
		$query = $db->prepare($query);
		$query->execute([':accountID' => $accountID]);
		$result = $query->fetchAll();
		$user = $result[0];
		$stars = $user["stars"];
		if($_POST["count"]){
			$count = ExploitPatch::remove($_POST["count"]);
		}else{
			$count = 50;
		}
		$count = floor($count / 2);
		$query = $db->prepare("SELECT	A.* FROM	(
			(
				SELECT	*	FROM accounts
				WHERE stars <= :stars
				AND isBanned = 0
				AND gameVersion > 19
				ORDER BY stars DESC
				LIMIT $count
			)
			UNION
			(
				SELECT * FROM accounts
				WHERE stars >= :stars
				AND isBanned = 0
				AND gameVersion > 19
				ORDER BY stars ASC
				LIMIT $count
			)
		) as A
		ORDER BY A.stars DESC");
		$query->execute([':stars' => $stars]);
	}
	$result = $query->fetchAll();
	if($type == "relative"){
		$user = $result[0];
		$extid = $user["accountID"];
		$e = "SET @rownum := 0;";
		$query = $db->prepare($e);
		$query->execute();
		$f = "SELECT rank, stars FROM (
							SELECT @rownum := @rownum + 1 AS rank, stars, accountID, isBanned
							FROM accounts WHERE isBanned = '0' AND gameVersion > 19 ORDER BY stars DESC
							) as result WHERE accountID=:extid";
		$query = $db->prepare($f);
		$query->execute([':extid' => $extid]);
		$leaderboard = $query->fetchAll();
		$leaderboard = $leaderboard[0];
		$xi = $leaderboard["rank"] - 1;
	}
	foreach($result as &$user) {
		$extid = $user["accountID"];
		$xi++;
		$lbstring .= "1:".$user["userName"].":2:".$user["accountID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":16:".$extid.":3:".$user["stars"].":8:".round($user["creatorPoints"],0,PHP_ROUND_HALF_DOWN).":4:".$user["demons"].":7:".$extid."|";
	}
}
if($type == "friends"){
	$query = "SELECT * FROM friendships WHERE person1 = :accountID OR person2 = :accountID";
	$query = $db->prepare($query);
	$query->execute([':accountID' => $accountID]);
	$result = $query->fetchAll();
	$people = "";
	foreach ($result as &$friendship) {
		$person = $friendship["person1"];
		if($friendship["person1"] == $accountID){
			$person = $friendship["person2"];
		}
		$people .= ",".$person;
	}
	$query = "SELECT * FROM accounts WHERE accountID IN (:accountID $people ) ORDER BY stars DESC";
	$query = $db->prepare($query);
	$query->execute([':accountID' => $accountID]);
	$result = $query->fetchAll();
	foreach($result as &$user){
		$extid = $user["accountID"];
		$xi++;
		$lbstring .= "1:".$user["userName"].":2:".$user["accountID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":16:".$extid.":3:".$user["stars"].":8:".round($user["creatorPoints"],0,PHP_ROUND_HALF_DOWN).":4:".$user["demons"].":7:".$extid."|";
	}
}
if($lbstring == ""){
	exit("-1");
}
$lbstring = substr($lbstring, 0, -1);
echo $lbstring;
?>