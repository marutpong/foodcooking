<!DOCTYPE HTML>
<html>
<head>
<title>Add Ingredient</title>
<meta charset="UTF-8" />
<link href="../core/css/flexigrid2.css" rel="stylesheet" type="text/css">
<link href="../core/css/mystyle.css" rel="stylesheet" type="text/css">

 	<?
		include 'connectDB.php'; 
		$strSQL = "SELECT * FROM IFOODS";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rows="";
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			$rows.= '<option value="'.$row['FID'].'">'.$row['NAME'].'</option>';
		}
		
		$strSQL = "SELECT * FROM IINGREDIENT";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rowsIngre="";
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			$rowsIngre.= '<option value="'.$row['IID'].'">'.$row['NAME'].'</option>';
		}
	?>
    
<script type="text/javascript" src="../core/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../core/js/jquery.numeric.js"></script>
<script type="text/javascript">
$(document).ready(function() {
		$('#name[0]').focus();
		$('#addmore').click(function () {
			var htmlStr = ' <table border="0">\
          <tr>\
            <td><select class="labelF" id="combobox" name="ingredient[]" onChange="getUnit(this)" required>\
              <option value=""></option>\
              <? echo $rowsIngre;?></select></td>\
            <td><input name="quantity[]" type="number"  required class="input number" id="quantity[]" tabindex="1" size="10" \
            onFocus="checkNum(this)"></td>\
            <td><input name="unit[]" type="text"  required disabled class="input unit" id="unit[]" tabindex="1" size="10"></td>\
          </tr>\
        </table>';
			$('#addIngre').append(htmlStr);
		});
		
});


		var checkNum = function(evt) {
		$(evt).numeric({ negative: false }, function() { 
			alert("No negative values"); this.value = ""; this.focus(); 
		});
		}
		var getUnit = function(evt) {
			var url = 'getunit.php?id='+$(evt).val();
			$.get(url, function(data) {
				$(evt).parent().next().next().find("input").val(data);
			});
		}
</script>
</head>
<body>
<?
if (isset($_POST['food']) && isset($_POST['ingredient']) && isset($_POST['quantity']) && $_POST['confirm']==1){
	$food = $_POST['food'];
	$ingredient = $_POST['ingredient'];
	$quantity = $_POST['quantity'];
	$count = 0;
	$num = count($_POST['ingredient']);
	include 'connectDB.php'; 
	for ($i=0;$i<$num;$i++){
		if (is_numeric($_POST['food']) && is_numeric($_POST['ingredient'][$i]) && is_numeric($_POST['quantity'][$i]) ){	
			$sql = "INSERT INTO $table (FID, IID, QUANTITY) VALUES ('$food','$ingredient[$i]','$quantity[$i]')";
			$strSQL = $sql;
			//echo $sql;
			$objParse = oci_parse($objConnect , $strSQL);
			$objExecute = oci_execute($objParse);
			if($objExecute){
				$count++;
			}
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
  <p class="labelF">รายการอาหาร : 
    <select class="labelF" id="food" name="food" required>
      <option value=""></option>
      <? echo $rows;?>
    </select>
  </p>
  <table>
    <tr>
      <td valign="top" class="labelF">ส่วนผสม :</td>
      <td><div id="addIngre">
        <table border="0">
          <tr>
            <td><select class="labelF" id="combobox" name="ingredient[]" onChange="getUnit(this)" required>
              <option value=""></option>
              <? echo $rowsIngre;?>
            </select></td>
            <td><input name="quantity[]" type="number"  required class="input number" id="quantity[]" tabindex="1" size="10" 
            onFocus="checkNum(this)"></td>
            <td><input name="unit[]" type="text"  required disabled class="input unit" id="unit[]" tabindex="1" size="10"></td>
          </tr>
        </table>
      </div></td>
    </tr>
  </table>
  <div class="button_addmore" id="addmore" tabindex="4" ><img src="../core/css/images/add.png" width="16" height="16">เพิ่มส่วนผสม</div>
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
