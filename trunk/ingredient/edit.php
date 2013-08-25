<!DOCTYPE HTML>
<html>
<head>
<title>Add Ingredient</title>
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
	if (isset($_POST['iid']) && isset($_POST['name']) && isset($_POST['quantity']) && isset($_POST['unit']) && $_POST['confirm']==2) {
	$count = 0;
	$num = count($_POST['iid']);
	include 'connectDB.php'; 
	for ($i=0;$i<$num;$i++){
		if (is_numeric($_POST['quantity'][$i])){
			$strSQL = "UPDATE $table SET ";
			$strSQL .="NAME = '".$_POST["name"][$i]."'";
			$strSQL .=", QUANTITY = '".$_POST["quantity"][$i]."' ";
			$strSQL .=", UNIT = '".$_POST["unit"][$i]."' ";
			$strSQL .=" WHERE IID = '".$_POST["iid"][$i]."' ";
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
	      <td>ชื่อส่วนผสม :</td>
	      <td>จำนวน :</td>
	      <td>หน่วย :</td>
        </tr>
<?
	$ids = $_GET['ids'];
	$nameArray = split(",|and",$ids);
	include 'connectDB.php'; 
	foreach($nameArray as $id){
	if ($id!=""){
		$strSQL = "SELECT * FROM $table Where IID=$id";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rows = array();
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
?>
	    <tr>
			<td>
          	<input name="iid[]" type="hidden" id="iid[]" value="<?=$id?>">
          	<input name="name[]" type="text"  required class="input" id="name[]" tabindex="1" value="<?=$row['NAME']?>">
			</td>
	      	<td>
            <input name="quantity[]" type="number" required class="input number" id="quantity[]" tabindex="2" value="<?=$row['QUANTITY']?>" size="10" onfocus="javascript:checkNum(this)">
            </td>
	      	<td>
            <input name="unit[]" type="text" required class="input" id="unit[]" tabindex="2" value="<?=$row['UNIT']?>">
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