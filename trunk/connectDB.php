<?php
$username = "user"; /// workspace
$password = "pass"; //password
$hostname = "//localhost/XE";
$objConnect = oci_connect($username, $password, $hostname,'AL32UTF8');
$table = "IFOODS"; //Table name

?>