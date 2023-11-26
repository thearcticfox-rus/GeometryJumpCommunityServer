<?php
require_once dirname(__FILE__)."/mainLib.php";

class GeneratePass
{
	public static function GJP2fromPassword($pass) {
		return sha1($pass . "mI29fmAnxgTs");
	}

	public static function GJP2hash($pass) {
		return password_hash(self::GJP2fromPassword($pass), PASSWORD_DEFAULT);
	}

	public static function assignGJP2($accid, $pass) {
		include dirname(__FILE__)."/connection.php";

		$query = $db->prepare("UPDATE accounts SET gjp2 = :gjp2 WHERE accountID = :id");
		$query->execute(["gjp2" => self::GJP2hash($pass), ":id" => $accid]);
	}

	public static function attemptsFromIP() {
		include dirname(__FILE__)."/connection.php";
		$gs = new mainLib();
		$ip = $gs->getIP();
		$newtime = time() - (60*60);
		$query6 = $db->prepare("SELECT count(*) FROM actions WHERE type = '6' AND timestamp > :time AND value2 = :ip");
		$query6->execute([':time' => $newtime, ':ip' => $ip]);
		return $query6->fetchColumn();
	}

	public static function tooManyAttemptsFromIP() {
		return self::attemptsFromIP() > 7;
	}

	public static function logInvalidAttemptFromIP($accid) {
		include dirname(__FILE__)."/connection.php";
		$gs = new mainLib();
		$ip = $gs->getIP();
		$query6 = $db->prepare("INSERT INTO actions (type, value, timestamp, value2) VALUES 
													('6',:accid,:time,:ip)");
		$query6->execute([':accid' => $accid, ':time' => time(), ':ip' => $ip]);
	}

	public static function isGJP2Valid($accid, $gjp2) {
		include dirname(__FILE__)."/connection.php";
		$gs = new mainLib();

		if(self::tooManyAttemptsFromIP()) return -1;

		$userInfo = $db->prepare("SELECT gjp2 FROM accounts WHERE accountID = :accid");
		$userInfo->execute([':accid' => $accid]);
		if($userInfo->rowCount() == 0) return 0;

		$userInfo = $userInfo->fetch();
		if(!($userInfo['gjp2'])) return -2;

		if(password_verify($gjp2, $userInfo['gjp2'])) {
			return 1;
		} else {
			self::logInvalidAttemptFromIP($accid);
			return 0;
		}
		
	}

	public static function isGJP2ValidUsrname($userName, $gjp2) {
		include dirname(__FILE__)."/connection.php";
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :userName");
		$query->execute([':userName' => $userName]);
		if($query->rowCount() == 0){
			return 0;
		}
		$result = $query->fetch();
		$accID = $result["accountID"];
		return self::isGJP2Valid($accID, $gjp2);
		
	}

	public static function isValid($accid, $pass) {
		include dirname(__FILE__)."/connection.php";
		$gs = new mainLib();

		if(self::tooManyAttemptsFromIP()) return -1;

		$query = $db->prepare("SELECT accountID, password, gjp2 FROM accounts WHERE accountID = :accid");
		$query->execute([':accid' => $accid]);
		if($query->rowCount() == 0) return 0;
		
		$result = $query->fetch();
		if(password_verify($pass, $result["password"])){
			if(!$result["gjp2"]) self::assignGJP2($accid, $pass);
			return 1;
		} else {
			// Code to validate password hashes created prior to March 2017 has been removed.
			self::logInvalidAttemptFromIP($accid);
			return 0;
		}

	}
	public static function isValidUsrname($userName, $pass){
		include dirname(__FILE__)."/connection.php";
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :userName");
		$query->execute([':userName' => $userName]);
		if($query->rowCount() == 0){
			return 0;
		}
		$result = $query->fetch();
		$accID = $result["accountID"];
		return self::isValid($accID, $pass);
	}
}
?>