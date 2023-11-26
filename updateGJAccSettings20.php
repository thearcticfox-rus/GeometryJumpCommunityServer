<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/GJPCheck.php";
require_once "lib/exploitPatch.php";

$accountID = GJPCheck::getAccountIDOrDie();
$mS = ExploitPatch::remove($_POST["mS"]);
$frS = ExploitPatch::remove($_POST["frS"]);
$youtubeurl = ExploitPatch::remove($_POST["yt"]);

$query = $db->prepare("UPDATE accounts SET mS=:mS, frS=:frS, youtubeurl=:youtubeurl WHERE accountID=:accountID");
$query->execute([':mS' => $mS, ':frS' => $frS, ':youtubeurl' => $youtubeurl, ':accountID' => $accountID]);
echo 1;
?>