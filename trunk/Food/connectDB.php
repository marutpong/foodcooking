<?php
$username = "db_01"; /// workspace
$password = "psass"; //password
$hostname = "//localhost/XE";
$objConnect = oci_connect($username, $password, $hostname,'AL32UTF8');
$table = "IFOODS"; //Table name

?>