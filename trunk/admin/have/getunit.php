<?php
if (isset($_GET['id'])){
	include 'connectDB.php';
	$id=$_GET['id'];
	$strSQL = "SELECT * FROM IINGREDIENT WHERE IID=$id";
	$objParse = oci_parse($objConnect, $strSQL);
	oci_execute($objParse, OCI_DEFAULT);
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		echo $row['UNIT'];
	}
}
?>