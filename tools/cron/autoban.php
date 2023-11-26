<hr>
<?php
include "../../lib/connection.php";
echo "Initializing autoban<br>";
ob_flush();
flush();
$query = $db->prepare("
	SELECT 10+IFNULL(FLOOR(coins.coins*1.25),0) as coins, 3+IFNULL(FLOOR(levels.demons*1.0625),0) as demons, 200+FLOOR((IFNULL(levels.stars,0)+IFNULL(mappacks.stars,0))) as stars FROM
		(SELECT SUM(coins) as coins FROM levels WHERE starCoins <> 0) coins
	JOIN
		(SELECT SUM(starDemon) as demons, SUM(starStars) as stars FROM levels) levels
    JOIN
		(SELECT SUM(stars) as stars FROM mappacks) mappacks
	");
$query->execute();
$levelstuff = $query->fetch();
$stars = $levelstuff['stars']; $coins = $levelstuff['coins']; $demons = $levelstuff['demons']; 
$query = $db->prepare("UPDATE accounts SET isBanned = '1' WHERE stars > :stars OR demons > :demons OR userCoins > :coins OR stars < 0 OR demons < 0 OR coins < 0 OR userCoins < 0");
$query->execute([':stars' => $stars, ':demons' => $demons, ':coins' => $coins]);
$query = $db->prepare("SELECT accountID, userName FROM accounts WHERE stars > :stars OR demons > :demons OR userCoins > :coins OR stars < 0 OR demons < 0 OR coins < 0 OR userCoins < 0");
$query->execute([':stars' => $stars, ':demons' => $demons, ':coins' => $coins]);
$result = $query->fetchAll();
foreach($result as $account){
	echo "Banned ".htmlspecialchars($account["userName"],ENT_QUOTES)." - ".$account["accountID"]."<br>";
}
echo "<hr>Autoban finished";
ob_flush();
flush();
//done
//echo "<hr>Banned everyone with over $stars stars and over $coins user coins and over $demons demons!<hr>done";
?>
<hr>
