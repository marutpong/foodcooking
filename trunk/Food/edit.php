<!DOCTYPE HTML>
<html>
<head>
<title>Edit Food</title>
<meta charset="UTF-8" />
<link href="css/mystyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/jquery.numeric.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#name').focus();
	});
	var checkNum = function(evt) {
		$(evt).numeric({ negative: false }, function() { 
			alert("No negative values"); this.value = ""; this.focus(); 
		});
	}
</script>
</head>
<body>
<?
	if (isset($_POST['fid']) && isset($_POST['name']) && isset($_POST['picture']) && isset($_POST['method']) && isset($_POST['views']) && $_POST['confirm']==2) {
	$count = 0;
	$num = count($_POST['fid']);
	include 'connectDB.php'; 
	for ($i=0;$i<$num;$i++){
		if (is_numeric($_POST['views'][$i])){
			$strSQL = "UPDATE $table SET ";
			$strSQL .="NAME = '".$_POST["name"][$i]."'";
			$strSQL .=", PICTURE = '".$_POST["picture"][$i]."' ";
			$strSQL .=", METHOD = '".$_POST["method"][$i]."' ";
			$strSQL .=", VIEWS = '".$_POST["views"][$i]."' ";
			$strSQL .=" WHERE FID = '".$_POST["fid"][$i]."' ";
			$objParse = oci_parse($objConnect, $strSQL);
			$objExecute = oci_execute($objParse);
			if($objExecute){
				$count++;
			}
		}
	}
	echo '<br><center><div class="textC1">';
	if($count){
		echo 'Edited '.$count.' items.';
	} else {
		echo 'Edit Unsuccessful, some input are incorect.';
	}
	echo '</div></center>';
} else {
	
if (isset($_GET['ids']) && $_GET['confirm']==1) {
?>
<form action="" method="post">
<div>
	  <table>
	    <tr class="labelF">
	      <td>ชื่ออาหาร :</td>
	      <td>รูปภาพ :</td>
	      <td>วิธีทำ :</td>
		  <td>จำนวนคนดู :</td>
        </tr>
<?
	$ids = $_GET['ids'];
	$nameArray = split(",|and",$ids);
	include 'connectDB.php'; 
	foreach($nameArray as $id){
	if ($id!=""){
		$strSQL = "SELECT * FROM $table Where FID=$id";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rows = array();
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
?>
	    <tr>
			<td>
          	<input name="fid[]" type="hidden" id="fid[]" value="<?=$id?>">
          	<input name="name[]" type="text"  required class="input" id="name[]" tabindex="1" value="<?=$row['NAME']?>">
			</td>
	      	<td>
            <input name="picture[]" type="text" required class="input" id="picture[]" tabindex="2" value="<?=$row['PICTURE']?>">
            </td>
			<td>
            <input name="method[]" type="text" required class="input" id="method[]" tabindex="2" value="<?=$row['METHOD']?>">
            </td>
			<td>
            <input name="views[]" type="number" required class="input number" id="views[]" tabindex="2" value="<?=$row['VIEWS']?>" size="10" onfocus="javascript:checkNum(this)">
            </td>
        </tr>
<?
		}
	}
}
?>
    </table>
</div>
	<footer>
    	<input name="confirm" type="hidden" id="confirm" value="2">
		<input type="submit" class="button_sub" value="แก้ไข" tabindex="4">
	</footer>
</form>
<? }
} ?>
</body>
</html>