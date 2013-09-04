<?php
include 'connectdb.php';
if(isset($_POST["username"]) && isset($_POST["password"])){
$username = $_POST["username"];
$password = $_POST["password"];
$total = 0;
$strSql = "SELECT * FROM iusers WHERE USERNAME = '".$username."' AND PASSWORD = '".$password."'";

$objParse = oci_parse($objConnect, $strSql);
oci_execute($objParse, OCI_DEFAULT);
$total = oci_fetch_all($objParse, $Result);


if($total>0){
	echo "sukseed";
}else{
	echo "can't";
}
}
else echo "no input";
?>