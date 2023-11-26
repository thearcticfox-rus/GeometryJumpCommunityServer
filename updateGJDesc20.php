<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require_once "lib/GJPCheck.php";
$GJPCheck = new GJPCheck();
require_once "lib/exploitPatch.php";

//here im getting all the data
$levelDesc = ExploitPatch::remove($_POST["levelDesc"]);
$levelID = ExploitPatch::remove($_POST["levelID"]);
$accountID = GJPCheck::getAccountIDOrDie();

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
$query = $db->prepare("UPDATE levels SET levelDesc=:levelDesc WHERE levelID=:levelID AND accountID=:accountID");
$query->execute([':levelID' => $levelID, ':accountID' => $accountID, ':levelDesc' => $levelDesc]);
echo 1;
