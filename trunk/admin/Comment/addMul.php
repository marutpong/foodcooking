<!DOCTYPE HTML>
<html>
<head>
<title>Add Ingredient</title>
<meta charset="UTF-8" />
<link href="../../core/css/flexigrid2.css" rel="stylesheet" type="text/css">
<link href="../../core/css/mystyle.css" rel="stylesheet" type="text/css">

 	<?
		include 'connectDB.php'; 
		$strSQL = "SELECT * FROM IUSERS";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rows="";
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			$rows.= '<option value="'.$row['UIDS'].'">'.$row['NAME'].'</option>';
		}
		
		$strSQL = "SELECT * FROM IFOODS";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rowsTools="";
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			$rowsTools.= '<option value="'.$row['FID'].'">'.$row['FOODNAME'].'</option>';
		}
	?>
    
<script type="text/javascript" src="../../core/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../../core/js/jquery.numeric.js"></script>
<script type="text/javascript">
$(document).ready(function() {
		$('#name[0]').focus();
		$('#addmore').click(function () {
			var htmlStr = '<tr>\
	      <td><select class="labelF" id="combobox" name="user[]" required>\
                <option value=""></option>\
                <? echo $rows;?></select></td>\
	      <td><select class="labelF" id="combobox" name="food[]" required>\
	        <option value=""></option>\
	        <? echo $rowsTools;?></select></td>\
        </tr>';
			$('#dynamic_tb').append(htmlStr);
		});

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
if (isset($_POST['user']) && isset($_POST['food']) && isset($_POST['message']) && $_POST['confirm']==1){
	$user = $_POST['user'];
	$food = $_POST['food'];
	$message = $_POST['message'];
	$count = 0;
	$num = count($_POST['user']);
	include 'connectDB.php';
	$now = time();
	$sysdate = date('d-m-Y H/i/s',time());
		if (is_numeric($_POST['user']) && is_numeric($_POST['food']) ){	
			$sql = "INSERT INTO $table (UIDS, FID, MESSAGE, STIME) VALUES ('$user','$food','$message',SYSDATE )";
			$strSQL = $sql;
			//echo $sql;
			$objParse = oci_parse($objConnect , $strSQL);
			$objExecute = oci_execute($objParse);
			if($objExecute){
				$count++;
			}
		
	}
	echo '<br><br><br><center><div class="textC1">';
	if($objExecute){
		echo 'Add Succesful '.$count.' items<P>';
		echo '<a href="addMul.php"  class="button_addmore">Add more</a>';
	} else {
		echo 'Unsuccessful, some input are incorect.';
	}
	echo '</div></center>';
} else {
?>
<div style="width:400">
<form action="" method="post">
<div>
    <table id="dynamic_tb">
	    <tr class="labelF">
	      <td class="labelF">User :</td>
	      <td><select class="labelF" id="combobox" name="user" required>
	        <option value=""></option>
	        <? echo $rows;?>
          </select></td>
        </tr>
	    <tr>
	      <td class="labelF">Food :</td>
	      <td><select class="labelF" id="food" name="food" required>
	        <option value=""></option>
	        <? echo $rowsTools;?>
          </select></td>
        </tr>
	    <tr>
	      <td class="labelF">Message :</td>
	      <td><textarea name="message" rows="5" id="message"></textarea></td>
        </tr>
    </table>
</div>
	<footer>
	  <p>
	    <input name="confirm" type="hidden" value="1">
	    <br>
<center><input type="submit" class="button_sub" value="เพิ่ม" tabindex="4"></center>
      </p>
</footer>
</form>
</div>
<? } ?>

</body>
</html>
