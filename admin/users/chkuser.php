<?php
$total = 0;
if (isset($_GET['username'])){
	include 'connectDB.php';
	$username=$_GET['username'];
	$strSQL = "SELECT * FROM IUSERS WHERE username='$username'";
	$objParse = oci_parse($objConnect, $strSQL);
	oci_execute($objParse, OCI_DEFAULT);
	$total = oci_fetch_all($objParse, $Result);
} else {
	$total = 99;
}
//echo $total;
if ($total==0){ echo 'true';}
else { echo 'false';}
	
?>