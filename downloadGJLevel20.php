<?php
chdir(dirname(__FILE__));
include "lib/connection.php";
require "lib/XORCipher.php";
require_once "lib/exploitPatch.php";
require_once "lib/mainLib.php";
$gs = new mainLib();
require "lib/generateHash.php";
require "lib/GJPCheck.php";
$gameVersion = ExploitPatch::remove($_POST["gameVersion"]);
if(empty($_POST["levelID"])){
	exit("-1");
}
$extras = !empty($_POST["extras"]) && $_POST["extras"];
$inc = !empty($_POST["inc"]) && $_POST["inc"];
$ip = $gs->getIP();
$levelID = ExploitPatch::remove($_POST["levelID"]);
$binaryVersion = !empty($_POST["binaryVersion"]) ? ExploitPatch::remove($_POST["levelID"]) : 0;
if(!is_numeric($levelID)){
	echo -1;
}else{
	//downloading the level
	$query=$db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
	$query->execute([':levelID' => $levelID]);
	$lvls = $query->rowCount();
	if($lvls!=0){
		$result = $query->fetch();
		//adding the download
		$query2=$db->prepare("UPDATE levels SET downloads = downloads + 1 WHERE levelID = :levelID");
		$query2->execute([':levelID' => $levelID]);
		//getting the days since uploaded... or outputting the date in Y-M-D format at least for now...
		$uploadDate = date("d-m-Y G-i", $result["uploadDate"]);
		$updateDate = date("d-m-Y G-i", $result["updateDate"]);
		//password xor
		$pass = $result["password"];
		$desc = $result["levelDesc"];
			$pass = "1";
		$xorPass = $pass;
		if($pass != 0) $xorPass = base64_encode(XORCipher::cipher($pass,26364));
		//submitting data
		$levelstring = $result["levelString"];
		if(substr($levelstring,0,3) == 'kS1'){
			$levelstring = base64_encode(gzcompress($levelstring));
			$levelstring = str_replace("/","_",$levelstring);
			$levelstring = str_replace("+","-",$levelstring);
		}
		$response = "1:".$result["levelID"].":2:".$result["levelName"].":3:".$desc.":4:".$levelstring.":5:".$result["levelVersion"].":6:".$result["accountID"].":8:10:9:".$result["starDifficulty"].":10:".$result["downloads"].":11:1:12:".$result["audioTrack"].":13:".$result["gameVersion"].":14:".$result["likes"].":17:".$result["starDemon"].":25:".$result["starAuto"].":18:".$result["starStars"].":19:".$result["starFeatured"].":45:".$result["objects"].":15:".$result["levelLength"].":30:".$result["original"].":31:".$result['twoPlayer'].":28:".$uploadDate. ":29:".$updateDate. ":35:".$result["songID"].":37:".$result["coins"].":38:".$result["starCoins"].":39:".$result["requestedStars"].":27:$xorPass";
		if($extras) $response .= ":26:" . $result["levelInfo"];
		//2.02 stuff
		$response .= "#" . GenerateHash::genSolo($levelstring) . "#";
		echo $response;
	}else{
		echo -1;
	}
}
?>
