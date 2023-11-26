<?php
function listdir($dir){
	$dirstring = "";
	$files = scandir($dir);
	foreach($files as $file) {
		if(pathinfo($file, PATHINFO_EXTENSION) == "php" AND $file != "index.php"){
			$dirstring .= "<li><a href='$dir/$file'>$file</a></li>";
		}
	}
	return $dirstring;
}
echo'</ul><h1>Upload related tools:</h1><ul>';
echo listdir(".");
echo "</ul><h1><a href='cron/cron.php'>The cron job (fixing CPs, autoban, etc.)</a></h1><ul>";
echo "</ul><h1>Stats related tools</h1><ul>";
echo listdir("stats");
?>