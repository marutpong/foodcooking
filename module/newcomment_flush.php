<?
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$data ='';
?><?
	include '../connectDB.php';
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$strSQL = "SELECT * FROM 	(Select * from ICOMMENTS C JOIN IFOODS F ON C.FID=F.FID JOIN IUSERS U ON C.UIDS=U.UIDS ORDER BY C.STIME DESC) WHERE ROWNUM  <= 3";
	//echo $strSQL;
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$searchOB = array();
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
	$data.='<li class="c-icon"><p>'.$row['NAME'].' : '.$row['MESSAGE'].'</p><div class="row"><em class="post-date">'.str_replace('.000000', '',$row['STIME']).'</em><br><em class="mycomments">in : <a href="foodDetail.php?foodid='.$row['FID'].'" style="color:white;">'.$row['FOODNAME'].'</a></em></div></li>';
	}
echo "data: {$data}\n\n";
flush(); ?>
           