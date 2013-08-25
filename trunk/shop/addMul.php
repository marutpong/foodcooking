<!DOCTYPE HTML>
<html>
<head>
<title>Add Ingredient</title>
<meta charset="UTF-8" />
<link href="css/flexigrid2.css" rel="stylesheet" type="text/css">
<link href="css/mystyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/jquery.numeric.js"></script>
<script type="text/javascript">
$(document).ready(function() {
		$('#name[0]').focus();
		$('#addmore').click(function () {
			var htmlStr = ' <tr>\
	      <td><input name="name[]" type="text"  required class="input number" id="name[]" tabindex="2" ></td>\
	      <td><input name="latitude[]" type="number" required class="input" id="latitude[]" tabindex="2" size="10" onfocus="javascript:checkNum(this)"></td>\
		  <td><input name="longitude[]" type="number" required class="input" id="longitude[]" tabindex="2" size="10" onfocus="javascript:checkNum(this)"></td>\
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
if ( isset($_POST['name']) && isset($_POST['latitude']) && isset($_POST['longitude']) && $_POST['confirm']==1){
	$name = $_POST['name'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$count = 0;
	$num = count($_POST['name']);
	include 'connectDB.php'; 
	for ($i=0;$i<$num;$i++){
		if (is_numeric($_POST['latitude'][$i]) && is_numeric($_POST['longitude'][$i])){	
			$sql = "INSERT INTO $table (NAME, LATITUDE, LONGITUDE) VALUES ('$name[$i]','$latitude[$i]','$longitude[$i]')";
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
	     
	      <td>ชื่อร้านค้า:</td>
	      <td>ละติจูด :</td>
		  <td>ลองจิจูด :</td>
        </tr>
	    <tr>
	  
	      <td><input name="name[]" type="text"  required class="input number" id="name[]" tabindex="2" ></td>
	      <td><input name="latitude[]" type="number" required class="input" id="latitude[]" tabindex="2" size="10" onfocus="javascript:checkNum(this)"></td>
		  <td><input name="longitude[]" type="number" required class="input" id="longitude[]" tabindex="2" size="10" onfocus="javascript:checkNum(this)"></td>
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