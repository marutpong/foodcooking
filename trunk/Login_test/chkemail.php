<?php
$total = 0;
if (isset($_GET['email'])){
	include 'connectdb.php';
	$email=$_GET['email'];
	$strSQL = "SELECT * FROM IUSERS WHERE EMAIL='$email'";
	$objParse = oci_parse($objConnect, $strSQL);
	oci_execute($objParse, OCI_DEFAULT);
	$total = oci_fetch_all($objParse, $Result);
}
//echo $total;
if ($total==0){ echo 'true';}
else { echo 'false';}
	
?>