<? session_start();
?>
<?php

include 'connectdb.php';
if(isset($_POST["username"]) && isset($_POST["password"])){
$username = $_POST["username"];
$password = $_POST["password"];

$_SESSION['user'] = $_POST["username"];

$total = 0;
$strSql = "SELECT * FROM iusers WHERE USERNAME = '".$username."' AND PASSWORD = '".$password."'";

$objParse = oci_parse($objConnect, $strSql);
oci_execute($objParse, OCI_DEFAULT);
$total = oci_fetch_all($objParse, $Result);


if($total>0){
	
	include ('show_pro.php');
	echo "congreturation";		
	
	
}else{
	echo "can't";
}

}
else echo "no input";


?>