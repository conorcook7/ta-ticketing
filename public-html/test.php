<?php
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

printr($_SERVER, 1);
echo $hostname;
?>
