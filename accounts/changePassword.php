<?php
include "../lib/connection.php";
include_once "../config/security.php";
require "../lib/generatePass.php";
require_once "../lib/exploitPatch.php";
$userName = ExploitPatch::remove($_POST["userName"]);
$oldpass = $_POST["oldpassword"];
$newpass = $_POST["newpassword"];
$salt = "";
if($userName != "" AND $newpass != "" AND $oldpass != ""){
$pass = GeneratePass::isValidUsrname($userName, $oldpass);
if ($pass == 1) {
	//creating pass hash
	$passhash = password_hash($newpass, PASSWORD_DEFAULT);
	$query = $db->prepare("UPDATE accounts SET password=:password WHERE userName=:userName");	
	$query->execute([':password' => $passhash, ':userName' => $userName]);
	GeneratePass::assignGJP2($accid, $newpass);
	echo "Password changed. <a href='..'>Go back to tools</a>";
}else{
	echo "Invalid old password or nonexistent account. <a href='changePassword.php'>Try again</a>";

}
}else{
	echo '<form action="changePassword.php" method="post">Username: <input type="text" name="userName"><br>Old password: <input type="password" name="oldpassword"><br>New password: <input type="password" name="newpassword"><br><input type="submit" value="Change"></form>';
}
?>