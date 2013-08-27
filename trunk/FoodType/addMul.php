<!DOCTYPE HTML>
<html>
<head>
<title>Add FoodType</title>
<meta charset="UTF-8" />
<link href="css/flexigrid2.css" rel="stylesheet" type="text/css">
<link href="css/mystyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/jquery.numeric.js"></script>
<script type="text/javascript">
$(document).ready(function() {
		$('#name[0]').focus();
		$('#addmore').click(function () {
			var htmlStr = '<tr>\
				<td><input name="name[]" type="text" required  class="input" id="name[]" tabindex="1" onfocus="javascript:checkNum(this)"></td>\
				<td><input name="quantity[]" type="number" required class="input number" id="quantity[]" tabindex="2" size="10" onfocus="javascript:checkNum(this)"></td>\
				<td><input name="unit[]" type="text" required class="input" id="unit[]" tabindex="2"></td>\
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
if (isset($_POST['typename']) && isset($_POST['description']) && $_POST['confirm']==1){
	$typename = $_POST['typename'];
	$description = $_POST['description'];
	$count = 0;
	$num = count($_POST['typename']);
	include 'connectDB.php'; 
	for ($i=0;$i<$num;$i++){
			
			$sql = "INSERT INTO $table (TYPENAME, DESCRIPTION) VALUES ('$typename[$i]','$description[$i]')";
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
		echo '<a href="addMul.php"  class="button_addmore">Add more Ingredient</a>';
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
	      <td>ชื่อประเภท :</td>
	      <td>คำอธิบาย :</td>
        </tr>
	    <tr>
	      <td><input name="typename[]" type="text"  required class="input" id="typename[]" tabindex="1" ></td>
	      <td><input name="description[]" type="text" required class="input" id="description[]" tabindex="2"></td>
        </tr>
    </table>
	  <div class="button_addmore" id="addmore" tabindex="4" ><img src="css/images/add.png" width="16" height="16"> add more</div>
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
