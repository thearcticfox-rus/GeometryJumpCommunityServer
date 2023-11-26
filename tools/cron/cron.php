<?php
chdir(dirname(__FILE__));
include "fixcps.php";
ob_flush();
flush();
include "autoban.php";
ob_flush();
flush();
echo "CRON done";
?>
