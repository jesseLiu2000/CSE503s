<?php
$mysqli = new mysqli('localhost', 'jesse', '123', '503s1');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>