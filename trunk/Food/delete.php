<!DOCTYPE HTML>
<html>
<head>
<title>Simple Login Form</title>
<meta charset="UTF-8" />
<script type="text/javascript" src="../core/js/jquery-1.6.4.min.js"></script>
<link href="../core/css/mystyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
		$(document).ready(function() {
			$('#name').focus();

		});
	</script>
</head>

<body>
<?
if (isset($_GET['ids']) && $_GET['confirm']==1) {
	$ids = $_GET['ids'];
	$nameArray = split(",|and",$ids);
	$count = 0;
	include 'connectDB.php'; 
	foreach($nameArray as $id){
		if ($id!=""){
			$strSQL = "DELETE FROM $table WHERE FID = '" . $id. "' ";
			$objParse = oci_parse($objConnect , $strSQL);
			$objExecute = oci_execute($objParse);
			if($objExecute){
				$count++;
			}
		}
	}
	echo '<center><div class="textC1"><br>';
	if ($count){
		echo 'Deleted '.$count.' items.'; 
	} else {
		echo 'Deleted unsuccessful.'; 
	}
	echo '</div></center>';
}

?>
</body>
</html>
