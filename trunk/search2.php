<?
if (!isset($_SESSION)) {
  session_start();
}
/*	include('FoodFunction.php');
//	include 'connectDB.php'; 
	$rows = optionIngredient("");
	$rowsTool = optionTool("");
	$rowsUser = optionUser("");
	$rowsFoodtype = optionFoodType("");
	*/
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Search Food</title>
	<meta charset="UTF-8" />
	<script type="text/javascript" src="core/js/jquery-1.6.4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="core/css/jquery-ui.css">
	<link href="core/css/mystyle.css" rel="stylesheet" type="text/css">
    <script src="core/js/jquery-2.0.0.min.js"></script>
    <script src="core/js/jquery-ui-1.10.3.js"></script>
	<script type="text/javascript" src="core/js/jquery.numeric.js"></script>
    <script src="core/js/combobox.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#name').focus();
		$( ".combobox" ).combobox();
		$( "#foodtype" ).combobox();
		$('#addmore').click(function () {
			var htmlStr = '<tr>\
              <td width="200"><select class="labelF combobox" id="combobox" name="ingredient[]">\
                <option value=""></option><? echo $rows;?></select>\
                <input name="newingredient[]" type="hidden" id="newingredient[]"></td>\
              <td><input name="quantity[]" type="number"  required class="input number" id="quantity[]" min="0" step="any" tabindex="1" \
            onFocus="checkNum(this)" size="10" placeholder="จำนวน"></td>\
              <td><input name="unit[]" type="text" readonly  required class="input unit" id="unit[]" tabindex="1" size="10" placeholder="หน่วย"></td>\
              <td><div class="remove" onClick="removeOb(this)"><img src="core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>\
            </tr>';
			$('#addIngre').append(htmlStr);
			$( ".combobox" ).combobox();
		});
		$('#addToolMore').click(function () {
			var htmlStr = '<tr>\
            <td width="200"><select class="labelF combobox" id="tool[]" name="tool[]" >\
              <option value=""></option>\
              <? echo $rowsTool;?></select>\
              <input name="newtool[]" type="hidden" id="newtool[]"></td>\
            <td><div class="remove" onClick="removeOb(this)"><img src="core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>\
            </tr>';
			$('#addTool').append(htmlStr);
			$( ".combobox" ).combobox();
		});
		

	});
var checkNum = function(evt) { 
		$(evt).numeric({ negative: false }, function() { 
			alert("No negative values"); this.value = ""; this.focus();
		});
}
var removeOb = function(e) {
	var ob = $(e).parent().parent();
	ob.hide('slow', function(){ ob.remove();
	 } );
	//$(e).parent().parent().remove();
};
</script>
</head>
<body>
<p>
  <?
$password = $_POST['pass'];
echo hash("sha512", $password);
echo "<br>";
echo sha1($password); 
echo "<br>";
echo md5($password); 
?>
</p>
<form name="form1" method="post" action="">
  <input name="pass" type="text" id="pass" value="<?=$_POST['pass']?>" autofocus>
</form>
<p>&nbsp;</p>

<?
 print_r ( $_SESSION["RESULT"]);
 echo "<br>";
 print_r ( $_SESSION["INPUT"]);
?>
</body>
</html>
