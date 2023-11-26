<?php
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require "../lib/generatePass.php";

if($_POST["userName"] != ""){
	//here im getting all the data
	$userName = ExploitPatch::remove($_POST["userName"]);
	$password = ExploitPatch::remove($_POST["password"]);
	$email = ExploitPatch::remove($_POST["email"]);
	//checking if username is within the GD length limit
	if(strlen($userName) > 20)
		exit("-4");
	//checking if name is taken
	$query2 = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
	$query2->execute([':userName' => $userName]);
	$regusrs = $query2->fetchColumn();
	if ($regusrs > 0) {
		echo "-2";
	}else{
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$gjp2 = GeneratePass::GJP2hash($password);
		$query = $db->prepare("INSERT INTO accounts (userName, password, email, registerDate, gjp2)
		VALUES (:userName, :password, :email, :time, :gjp)");
		$query->execute([':userName' => $userName, ':password' => $hashpass, ':email' => $email, ':time' => time(), ':gjp' => $gjp2]);
		echo "1";
	}
}
?>
