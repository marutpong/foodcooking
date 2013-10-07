<?
		include '../connectDB.php';
    	$strSQL = "SELECT * FROM $table";
		//echo $strSQL;
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rows = array();
		$tmp = array();
		$shop=array();
		$j=1;
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			$tmp = array();
			array_push($tmp,$row['SHOPNAME'],(double)$row['LATITUDE'],(double)$row['LONGITUDE'],$j);
			array_push($shop,$tmp);
			$j++;
		}
		echo json_encode($shop)."<br>";
?>
<script type="text/javascript">
  var i;
  var a=<?php echo json_encode($shop); ?>;
  document.write(a);
    //var locations = new Array();
	var b=a;
</script>