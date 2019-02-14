<?php
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

echo "<p> user: " . $_SERVER['REMOTE_USER'];
echo $hostname;
?>
