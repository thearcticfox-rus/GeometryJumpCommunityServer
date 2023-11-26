<?php
class Commands {
	public static function ownCommand($comment, $command, $accountID, $targetExtID){
		require_once "mainLib.php";
		$gs = new mainLib();
		$commandInComment = strtolower("!".$command);
		$commandInPerms = ucfirst(strtolower($command));
		$commandlength = strlen($commandInComment);
		if(substr($comment,0,$commandlength) == $commandInComment AND (($gs->checkPermission($accountID, "command".$commandInPerms."All") OR ($targetExtID == $accountID AND $gs->checkPermission($accountID, "command".$commandInPerms."Own"))))){
			return true;
		}
		return false;
	}
	public static function doCommands($accountID, $comment, $levelID) {
		if(!is_numeric($accountID)) return false;

		include dirname(__FILE__)."/connection.php";
		require_once "exploitPatch.php";
		require_once "mainLib.php";
		$gs = new mainLib();
		$commentarray = explode(' ', $comment);
		$uploadDate = time();
		//LEVELINFO
		$query2 = $db->prepare("SELECT accountID FROM levels WHERE levelID = :levelID");
		$query2->execute([':levelID' => $levelID]);
		$targetExtID = $query2->fetchColumn();
		//ADMIN COMMANDS
		if(substr($comment,0,5) == '!rate' AND $gs->checkPermission($accountID, "commandRate")){
			$starStars = $commentarray[2];
			if($starStars == ""){
				$starStars = 0;
			}
			$starCoins = $commentarray[3];
			$starFeatured = $commentarray[4];
			$diffArray = $gs->getDiffFromName($commentarray[1]);
			$starDemon = $diffArray[1];
			$starAuto = $diffArray[2];
			$starDifficulty = $diffArray[0];
			$query = $db->prepare("UPDATE levels SET starStars=:starStars, starDifficulty=:starDifficulty, starDemon=:starDemon, starAuto=:starAuto, rateDate=:timestamp WHERE levelID=:levelID");
			$query->execute([':starStars' => $starStars, ':starDifficulty' => $starDifficulty, ':starDemon' => $starDemon, ':starAuto' => $starAuto, ':timestamp' => $uploadDate, ':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :levelID)");
			$query->execute([':value' => $commentarray[1], ':timestamp' => $uploadDate, ':levelID' => $accountID, ':value2' => $starStars, ':levelID' => $levelID]);
			if($starFeatured != ""){
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :levelID)");
				$query->execute([':value' => $starFeatured, ':timestamp' => $uploadDate, ':levelID' => $accountID, ':levelID' => $levelID]);	
				$query = $db->prepare("UPDATE levels SET starFeatured=:starFeatured WHERE levelID=:levelID");
				$query->execute([':starFeatured' => $starFeatured, ':levelID' => $levelID]);
			}
			if($starCoins != ""){
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('3', :value, :levelID, :timestamp, :levelID)");
				$query->execute([':value' => $starCoins, ':timestamp' => $uploadDate, ':levelID' => $accountID, ':levelID' => $levelID]);
				$query = $db->prepare("UPDATE levels SET starCoins=:starCoins WHERE levelID=:levelID");
				$query->execute([':starCoins' => $starCoins, ':levelID' => $levelID]);
			}
			return true;
		}
		if(substr($comment,0,8) == '!feature' AND $gs->checkPermission($accountID, "commandFeature")){
			$query = $db->prepare("UPDATE levels SET starFeatured='1' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :levelID)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':levelID' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if(substr($comment,0,12) == '!verifycoins' AND $gs->checkPermission($accountID, "commandVerifycoins")){
			$query = $db->prepare("UPDATE levels SET starCoins='1' WHERE levelID = :levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('3', :value, :levelID, :timestamp, :levelID)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':levelID' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if(substr($comment,0,6) == '!delet' AND $gs->checkPermission($accountID, "commandDelete")){
			if(!is_numeric($levelID)){
				return false;
			}
			$query = $db->prepare("DELETE from levels WHERE levelID=:levelID LIMIT 1");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('4', :value, :levelID, :timestamp, :levelID)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':levelID' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if(substr($comment,0,7) == '!setacc' AND $gs->checkPermission($accountID, "commandSetacc")){
			$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName OR accountID = :userName LIMIT 1");
			$query->execute([':userName' => $commentarray[1]]);
			if($query->rowCount() == 0){
				return false;
			}
			$targetAcc = $query->fetchColumn();
			//var_dump($result);
			$query = $db->prepare("SELECT accountID FROM accounts WHERE accountID = :accountID LIMIT 1");
			$query->execute([':accountID' => $targetAcc]);
			$accountID = $query->fetchColumn();
			$query = $db->prepare("UPDATE levels SET accountID=:accountID, userName=:userName WHERE levelID=:levelID");
			$query->execute([':accountID' => $targetAcc, ':accountID' => $accountID, ':userName' => $commentarray[1], ':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('5', :value, :levelID, :timestamp, :levelID)");
			$query->execute([':value' => $commentarray[1], ':timestamp' => $uploadDate, ':levelID' => $accountID, ':levelID' => $levelID]);
			return true;
		}

		
	//NON-ADMIN COMMANDS
		if(self::ownCommand($comment, "rename", $accountID, $targetExtID)){
			$name = ExploitPatch::remove(str_replace("!rename ", "", $comment));
			$query = $db->prepare("UPDATE levels SET levelName=:levelName WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID, ':levelName' => $name]);
			$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('6', :value, :timestamp, :levelID, :levelID)");
			$query->execute([':value' => $name, ':timestamp' => $uploadDate, ':levelID' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if(self::ownCommand($comment, "pass", $accountID, $targetExtID)){
			$pass = ExploitPatch::remove(str_replace("!pass ", "", $comment));
			if(is_numeric($pass)){
				$pass = sprintf("%06d", $pass);
				if($pass == "000000"){
					$pass = "";
				}
				$pass = "1".$pass;
				$query = $db->prepare("UPDATE levels SET password=:password WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID, ':password' => $pass]);
				$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('7', :value, :timestamp, :levelID, :levelID)");
				$query->execute([':value' => $pass, ':timestamp' => $uploadDate, ':levelID' => $accountID, ':levelID' => $levelID]);
				return true;
			}
		}
		if(self::ownCommand($comment, "song", $accountID, $targetExtID)){
			$song = ExploitPatch::remove(str_replace("!song ", "", $comment));
			if(is_numeric($song)){
				$query = $db->prepare("UPDATE levels SET songID=:song WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID, ':song' => $song]);
				$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('8', :value, :timestamp, :levelID, :levelID)");
				$query->execute([':value' => $song, ':timestamp' => $uploadDate, ':levelID' => $accountID, ':levelID' => $levelID]);
				return true;
			}
		}
		if(self::ownCommand($comment, "description", $accountID, $targetExtID)){
			$desc = base64_encode(ExploitPatch::remove(str_replace("!description ", "", $comment)));
			$query = $db->prepare("UPDATE levels SET levelDesc=:desc WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID, ':desc' => $desc]);
			$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('9', :value, :timestamp, :levelID, :levelID)");
			$query->execute([':value' => $desc, ':timestamp' => $uploadDate, ':levelID' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		return false;
	}
}
?>
