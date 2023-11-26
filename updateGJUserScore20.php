<?php
ini_set("display_errors", 1);
include "lib/connection.php";
require_once "lib/GJPCheck.php";
require_once "lib/exploitPatch.php";
require_once "lib/mainLib.php";
$gs = new mainLib();

if(!isset($_POST["userName"]) OR !isset($_POST["stars"])
	OR !isset($_POST["demons"]) OR !isset($_POST["icon"]) OR !isset($_POST["color1"])
	OR !isset($_POST["color2"]))
{
	exit("-1");
}

$userName = ExploitPatch::charclean($_POST["userName"]);
$stars = ExploitPatch::remove($_POST["stars"]);
$demons = ExploitPatch::remove($_POST["demons"]);
$icon = ExploitPatch::remove($_POST["icon"]);
$color1 = ExploitPatch::remove($_POST["color1"]);
$color2 = ExploitPatch::remove($_POST["color2"]);

$gameVersion = !empty($_POST["gameVersion"]) ? ExploitPatch::remove($_POST["gameVersion"]) : 1;
$binaryVersion = !empty($_POST["binaryVersion"]) ? ExploitPatch::remove($_POST["binaryVersion"]) : 1;
$coins = !empty($_POST["coins"]) ? ExploitPatch::remove($_POST["coins"]) : 0;
$iconType = !empty($_POST["iconType"]) ? ExploitPatch::remove($_POST["iconType"]) : 0;
$userCoins = !empty($_POST["userCoins"]) ? ExploitPatch::remove($_POST["userCoins"]) : 0;
$accIcon = !empty($_POST["accIcon"]) ? ExploitPatch::remove($_POST["accIcon"]) : 0;
$accShip = !empty($_POST["accShip"]) ? ExploitPatch::remove($_POST["accShip"]) : 0;
$accBall = !empty($_POST["accBall"]) ? ExploitPatch::remove($_POST["accBall"]) : 0;
$accBird = !empty($_POST["accBird"]) ? ExploitPatch::remove($_POST["accBird"]) : 0;
$accDart = !empty($_POST["accDart"]) ? ExploitPatch::remove($_POST["accDart"]) : 0;
$accRobot = !empty($_POST["accRobot"]) ? ExploitPatch::remove($_POST["accRobot"]) : 0;
$accGlow = !empty($_POST["accGlow"]) ? ExploitPatch::remove($_POST["accGlow"]) : 0;

if(empty($_POST["accountID"])){
	exit("-1");
}

$accountID = GJPCheck::getAccountIDOrDie();
$uploadDate = time();
$hostname = $gs->getIP();

$query = $db->prepare("SELECT stars,coins,demons,userCoins FROM accounts WHERE accountID=:accountID LIMIT 1"); //getting differences
$query->execute([':accountID' => $accountID]);
$old = $query->fetch();

$query = $db->prepare("UPDATE accounts SET gameVersion=:gameVersion, userName=:userName, coins=:coins, stars=:stars, demons=:demons, icon=:icon, color1=:color1, color2=:color2, iconType=:iconType, userCoins=:userCoins, accIcon=:accIcon, accShip=:accShip, accBall=:accBall, accBird=:accBird, accDart=:accDart, accRobot=:accRobot, accGlow=:accGlow, lastPlayed=:uploadDate WHERE accountID=:accountID");
$query->execute([':gameVersion' => $gameVersion, ':userName' => $userName, ':coins' => $coins, ':stars' => $stars, ':demons' => $demons, ':icon' => $icon, ':color1' => $color1, ':color2' => $color2, ':iconType' => $iconType, ':userCoins' => $userCoins, ':accIcon' => $accIcon, ':accShip' => $accShip, ':accBall' => $accBall, ':accBird' => $accBird, ':accDart' => $accDart, ':accRobot' => $accRobot, ':accGlow' => $accGlow, ':uploadDate' => $uploadDate, ':accountID' => $accountID]);

$starsdiff = $stars - $old["stars"];
$coindiff = $coins - $old["coins"];
$demondiff = $demons - $old["demons"];
$ucdiff = $userCoins - $old["userCoins"];
$query2 = $db->prepare("INSERT INTO actions (type, value, timestamp, account, value2, value3, value4) 
									 VALUES ('9',:stars,:timestamp,:account,:coinsd, :demon, :usrco)"); //creating the action
$query2->execute([':timestamp' => time(), ':stars' => $starsdiff, ':account' => $accountID, ':coinsd' => $coindiff, ':demon' => $demondiff, ':usrco' => $ucdiff]);

echo $accountID;
?>