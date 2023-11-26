<?php
chdir(dirname(__FILE__));
require_once "lib/GJPCheck.php";
require_once "lib/exploitPatch.php";
require_once "lib/mainLib.php"; //this is connection.php too
$gs = new mainLib();

$accountID = GJPCheck::getAccountIDOrDie();

if ($gs->checkPermission($accountID,"actionRequestMod")) { // checks if they have mod
	exit("1");
}else{
	exit("-1");
}
?>
