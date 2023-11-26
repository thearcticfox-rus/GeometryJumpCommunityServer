<?php
error_reporting(E_ALL);
chdir(dirname(__FILE__));
echo "Please wait...<br>";
ob_flush();
flush();
$people = array();
include "../../lib/connection.php";
$query = $db->prepare("UPDATE accounts
	LEFT JOIN
	(
	    SELECT accountsTable.accountID, (IFNULL(starredTable.starred, 0) + IFNULL(featuredTable.featured, 0)) as CP FROM (
            SELECT accountID FROM accounts
        ) AS accountsTable
        LEFT JOIN
        (
	        SELECT count(*) as starred, accountID FROM levels WHERE starStars != 0 GROUP BY(accountID) 
	    ) AS starredTable ON accountsTable.accountID = starredTable.accountID
	    LEFT JOIN
	    (
	        SELECT count(*) as featured, accountID FROM levels WHERE starFeatured != 0 GROUP BY(accountID) 
	    ) AS featuredTable ON accountsTable.accountID = featuredTable.accountID
	) calculated
	ON accounts.accountID = calculated.accountID
	SET accounts.creatorPoints = IFNULL(calculated.CP, 0)");
$query->execute();
/*
	DONE
*/
foreach($people as $account => $cp){
	echo "$account now has $cp creator points... <br>";
	$query4 = $db->prepare("UPDATE accounts SET creatorPoints = (creatorpoints + :creatorpoints) WHERE accountID=:accountID");
	$query4->execute([':accountID' => $account, ':creatorpoints' => $cp]);
}
echo "<hr>Done!";
?>
