<?
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
function getSingleRow($strSQL){
	include '../connectDB.php';
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	return(oci_fetch_array($objParse, OCI_BOTH));
}
if (is_numeric($_GET['foodid'])){
	$strSQLlike = "SELECT COUNT(FID) as \"LIKE\" FROM IFAVORITE WHERE FID = ".$_GET['foodid'];
	//echo $strSQLlike;
	$rowlike = getSingleRow($strSQLlike);
	$data = $rowlike['LIKE'];
	echo "data: {$data}\n\n";
	flush();
}
?>
