<?php
include '../connectDB.php';
$objConnect = oci_connect($username, $password, $hostname,'AL32UTF8');
$table = "ITOOLS"; //Table name

?>