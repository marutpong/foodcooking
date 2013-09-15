<?php
include '../../connectDB.php';
$objConnect = oci_connect($username, $password, $hostname,'AL32UTF8');
$table = "ITOOLS"; //Table name
/*
	$strSQL = "INSERT INTO ITOOLS (TOOLNAME) VALUES ('xxxxxx') returning TID into :ID";
	$objParse = oci_parse($objConnect, $strSQL);
	oci_bind_by_name($objParse,":ID",$id,32);
	$objExecute = oci_execute($objParse);
	echo $id;
*/	
?>