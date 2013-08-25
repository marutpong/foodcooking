<?php
$usernamews = "TEST"; /// workspace
$passwordwp = "123456789"; //password
$hostname = "//localhost/XE";
$objConnect = oci_connect($usernamews, $passwordwp, $hostname,'AL32UTF8');
$table = "IUSERS"; //Table name

?>