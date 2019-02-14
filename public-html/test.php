<?php
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

echo $_SERVER['REMOTE_USER'];
echo $hostname;
?>
