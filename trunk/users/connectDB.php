<?php
$username = "TEST"; /// workspace
$password = "123456789"; //password
$hostname = "//localhost/XE";
$objConnect = oci_connect($username, $password, $hostname,'AL32UTF8');
$table = "IUSERS"; //Table name

?>