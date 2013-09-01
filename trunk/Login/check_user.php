<?php
include 'connectdb.php';
$username = strtoupper($_POST["username"]);
$password = $_POST["password"];
$strSql = "SELECT * FROM FEED_USER WHERE USERNAME = '".$username."' AND PASSWORD = '".$password."'";
$objParse = oci_parse($objConnect, $strSql);
$objExecute = oci_execute($objParse, OCI_DEFAULT);
if($objExecute){
	oci_commit($objConnect);
}
$found = oci_fetch_all($objParse, $result);
if($found>0){
	echo "<script>window.top.window.showWarning('1');</script>";
}else{
	echo "<script>window.top.window.showWarning('0');</script>";
}
?>