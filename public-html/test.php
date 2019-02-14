<?php
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

print_r($_SERVER, 1);
echo $hostname;
?>
