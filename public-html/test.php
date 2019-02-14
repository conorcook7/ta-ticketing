<?php
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

print_r($_SERVER);
echo $hostname;
?>
