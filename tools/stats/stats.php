<h1>Levels</h1>
<table border="1">
<tr><th>Difficulty</th><th>Total</th><th>Unrated</th><th>Rated</th><th>Featured</th></tr>
<?php
include "../../lib/connection.php";
include "../../lib/mainLib.php";
$gs = new mainLib();

$start_time = microtime(true);

function genLvlRow($params, $params2, $params3, $params4){
	include "../../lib/connection.php";
	$query = $db->prepare("SELECT count(*) FROM levels ".$params4." ".$params2);
	$query->execute();
	$row = "<tr><td>$params3</td><td>".$query->fetchColumn()."</td>";
	$query = $db->prepare("SELECT count(*) FROM levels WHERE starStars = 0 ".$params." ".$params2);
	$query->execute();
	$row .= "<td>".$query->fetchColumn()."</td>";
	$query = $db->prepare("SELECT count(*) FROM levels WHERE starStars <> 0 ".$params." ".$params2);
	$query->execute();
	$row .= "<td>".$query->fetchColumn()."</td>";
	$query = $db->prepare("SELECT count(*) FROM levels WHERE starFeatured <> 0 ".$params." ".$params2);
	$query->execute();
	$row .= "<td>".$query->fetchColumn()."</td></tr>";
	return $row;
}

function generateQuery($groupBy, $requirements){
	$queryString = "
		SELECT total.${groupBy}, total.amount AS total, unrated.amount AS unrated, rated.amount AS rated, featured.amount AS featured
		FROM(
			(SELECT ${groupBy}, count(*) AS amount FROM levels WHERE ${requirements} GROUP BY(${groupBy})) total
			JOIN
			(SELECT ${groupBy}, count(*) AS amount FROM levels WHERE ${requirements} AND starStars = 0 GROUP BY(${groupBy})) unrated
			ON total.${groupBy} = unrated.${groupBy}
			JOIN
			(SELECT ${groupBy}, count(*) AS amount FROM levels WHERE ${requirements} AND starStars <> 0 GROUP BY(${groupBy})) rated
			ON total.${groupBy} = rated.${groupBy}
			JOIN
			(SELECT ${groupBy}, count(*) AS amount FROM levels WHERE ${requirements} AND starFeatured <> 0 GROUP BY(${groupBy})) featured
			ON total.${groupBy} = featured.${groupBy}
		) GROUP BY(total.${groupBy})
	";
	return $queryString;
}

function fetchQuery($db, $groupBy, $requirements){
	$query = $db->prepare(generateQuery($groupBy, $requirements));
	$query->execute();
	return $query->fetchAll();
}


echo genLvlRow("","","Total", "");
foreach(fetchQuery($db, 'starAuto', 'starAuto = 1') as &$row){
	$diffName = $gs->getDifficulty(50, 1, 0);
	echo "<tr><td>${diffName}</td><td>${row['total']}</td><td>${row['unrated']}</td><td>${row['rated']}</td><td>${row['featured']}</td></tr>";
}

foreach(fetchQuery($db, 'starDifficulty', 'starAuto = 0 AND starDemon = 0') as &$row){
	$diffName = $gs->getDifficulty($row['starDifficulty'], 0, 0);
	echo "<tr><td>${diffName}</td><td>${row['total']}</td><td>${row['unrated']}</td><td>${row['rated']}</td><td>${row['featured']}</td></tr>";
}

foreach(fetchQuery($db, 'starDemon', 'starDemon = 1') as &$row){
	$diffName = $gs->getDifficulty(50, 0, 1);
	echo "<tr><td>${diffName}</td><td>${row['total']}</td><td>${row['unrated']}</td><td>${row['rated']}</td><td>${row['featured']}</td></tr>";
}
?>
<h1>Accounts</h1>
<table border="1">
<tr><th>Type</th><th>Count</th>
<?php
$query = $db->prepare("SELECT count(*) FROM accounts");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Registered</td><td>$thing</td></tr>";
$sevendaysago = time() - 604800;
$query = $db->prepare("SELECT count(*) FROM accounts WHERE lastPlayed > :lastPlayed");
$query->execute([':lastPlayed' => $sevendaysago]);
$thing = $query->fetchColumn();
echo "<tr><td>Active</td><td>$thing</td></tr>";
?>
</table>
<?php
echo (microtime(true) - $start_time);