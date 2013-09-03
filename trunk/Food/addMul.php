<!DOCTYPE HTML>
<html>
<head>
	<title>Add Food</title>
	<meta charset="UTF-8" />
	<script type="text/javascript" src="../core/js/jquery-1.6.4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../core/css/jquery-ui.css">
	<link href="../core/css/mystyle.css" rel="stylesheet" type="text/css">
    <script src="../core/js/jquery-2.0.0.min.js"></script>
    <script src="../core/js/jquery-ui-1.10.3.js"></script>
	<script type="text/javascript" src="../core/js/jquery.numeric.js"></script>
    <script src="../core/js/combobox.js"></script>
 	<?
		include 'connectDB.php'; 
		include('../FoodFunction.php');
		$rows = optionIngredient("");
		$rowsTool = optionTool("");
		$rowsUser = optionUser("");
		$rowsFoodtype = optionFoodType("");
	?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#name').focus();
		$( ".combobox" ).combobox();
		$( "#foodtype" ).combobox();
		$('#addmore').click(function () {
			var htmlStr = '<tr>\
              <td width="263"><select class="labelF combobox" id="combobox" name="ingredient[]">\
                <option value=""></option><? echo $rows;?></select>\
                <input name="newingredient[]" type="hidden" id="newingredient[]"></td>\
              <td><input name="quantity[]" type="number"  required class="input number" id="quantity[]" min="0" tabindex="1" \
            onFocus="checkNum(this)" size="10" placeholder="จำนวน"></td>\
              <td><input name="unit[]" type="text" disabled  required class="input unit" id="unit[]" tabindex="1" size="10" placeholder="หน่วย"></td>\
              <td><div class="remove" onClick="removeOb(this)"><img src="../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>\
            </tr>';
			$('#addIngre').append(htmlStr);
			$( ".combobox" ).combobox();
		});
		$('#addToolMore').click(function () {
			var htmlStr = '<tr>\
            <td width="260"><select class="labelF combobox" id="tool[]" name="tool[]" >\
              <option value=""></option>\
              <? echo $rowsTool;?></select>\
              <input name="newtool[]" type="hidden" id="newtool[]"></td>\
            <td><div class="remove" onClick="removeOb(this)"><img src="../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>\
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
<?
/// Upload picture ///
	$picture = uploadImage("files/",$_FILES["picture"]);
// Food Type ///
	if ( isset($_POST['foodtype']) && !empty($_POST['foodtype']) ) {
		$foodtypeID = $_POST['foodtype'];
	} else if ( isset($_POST['newfoodtype']) && !empty($_POST['newfoodtype']) ){
		$foodtypeID = insertFoodType($_POST['newfoodtype'],'');
	}
if (isset($_POST['name']) 
	&& isset($_POST['method']) 
	&& isset($_POST['views']) 
	&& isset($_POST['owner']) 
	&& !empty($foodtypeID) 
	&& $_POST['confirm']==1){
		
	$name = $_POST['name'];
	$method = $_POST['method'];
	$views = $_POST['views'];
	$owner = $_POST['owner'];
///// Insert Food ////
	if($fid = insertFood($name,$picture,$method,$views,$owner,$foodtypeID)){
		$count=1;	
/////// Add INGREDIENT  ////////
		if ( isset($_POST['ingredient']) && isset($_POST['quantity']) && isset($_POST['newingredient']) && (is_numeric($fid)) ){
			$ingredient = $_POST['ingredient'];
			$newIG = $_POST['newingredient'];
			$quantity = $_POST['quantity'];
			$num = count($_POST['ingredient']);
			for ($i=0;$i<$num;$i++){
				if (is_numeric($_POST['quantity'][$i])){	
					$theIngreID = "";
					if ( empty($ingredient[$i]) && !empty($newIG[$i]) ) {			
						$theIngreID = insertIngredient($newIG[$i],$_POST['unit'][$i]);
					} else if (!empty($ingredient[$i])){
						$theIngreID = $ingredient[$i];
					}
					insertContain($fid,$theIngreID,$quantity[$i]);
				}
			}
		}
/////// Add Tool ////////
		if ( isset($_POST['tool']) &&  isset($_POST['newtool'])){
			$tool = $_POST['tool'];
			$newtool = $_POST['newtool'];
			$num = count($_POST['tool']);
			for ($i=0;$i<$num;$i++){
				$theToolID = "";
				if ( empty($tool[$i]) && !empty($newtool[$i]) ) {
					$theToolID =  insertTool($newtool[$i]);
				} else if (!empty($tool[$i])){
					$theToolID = $tool[$i];
				}
				if (is_numeric($theToolID)){
					insertUse($fid,$theToolID);
				}
			}
		}
		$message = 'Add Succesful '.$count.' items<P><a href="addMul.php"  class="button_addmore">Add more Food</a>';
	} else {
		$message =  'Unsuccessful, some input are incorect.';
	}
	echo '<br><br><br><center><div class="textC1">'.$message.'</div></center>';
} else {
?>
<div style="width:400">
<form action="" method="post" enctype="multipart/form-data">
<div>
    <table id="dynamic_tb">
	    <tr class="labelF">
	      <td align="right" valign="top">ชื่ออาหาร :</td>
	      <td><input name="name" type="text"  required autofocus autocomplete="on" class="input" id="name" tabindex="1" size="50" ></td>
        </tr>
	    <tr>
	      <td align="right" valign="top"><span class="labelF">รูปภาพ :</span></td>
	      <td><span class="labelF">
	        <input name="picture" type="file"  class="input" id="picture" tabindex="2" size="50" >
	      </span></td>
        </tr>
	    <tr>
	      <td align="right" valign="top" class="labelF">วิธีทำ :</td>
	      <td><textarea name="method" cols="50" rows="10" required class="input" id="method" tabindex="2"></textarea>
          <input name="views" type="hidden" required class="input number" id="views" tabindex="2" value="0"></td>
        </tr>
	    <tr>
	      <td align="right" valign="top" class="labelF">เจ้าของ :</td>
	      <td><select class="labelF" id="owner" name="owner" required>
	        <option value=""></option>
	        <? echo $rowsUser;?>
          </select></td>
        </tr>
	    <tr>
	      <td align="right" valign="top" class="labelF">ประเภท :</td>
	      <td><select class="labelF" id="foodtype" name="foodtype" >
	        <option value=""></option>
	        <? echo $rowsFoodtype;?>
          </select><input name="newfoodtype" type="hidden"></td>
        </tr>
    </table>
    <table>
      <tr>
        <td valign="top" class="labelF">ส่วนผสม :</td>
        <td><div>
          <table border="0" id="addIngre">
            <tr>
              <td width="263"><select class="labelF combobox" id="combobox" name="ingredient[]">
                <option value=""></option><? echo $rows;?>
              </select>
                <input name="newingredient[]" type="hidden" id="newingredient[]"></td>
              <td><input name="quantity[]" type="number"  required class="input number" id="quantity[]" min="0" tabindex="1" 
            onFocus="checkNum(this)" size="10" placeholder="จำนวน"></td>
              <td><input name="unit[]" type="text" disabled  required class="input unit" id="unit[]" tabindex="1" size="10" placeholder="หน่วย"></td>
              <td><div class="remove" onClick="removeOb(this)"><img src="../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>
            </tr>
          </table>
        </div></td>
        </tr>
    </table>
    <div class="button_addmore" id="addmore" tabindex="4" ><img src="../core/css/images/add.png" width="16" height="16">เพิ่มส่วนผสม</div>
</div>

<table>
      <tr>
        <td valign="top" class="labelF">อุปกรณ์ :</td>
        <td><table id="addTool">
          <tr>
            <td width="260"><select class="labelF combobox" id="tool[]" name="tool[]" >
              <option value=""></option>
              <? echo $rowsTool;?></select>
              <input name="newtool[]" type="hidden" id="newtool[]"></td>
            <td><div class="remove" onClick="removeOb(this)"><img src="../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>
            </tr>
        </table></td>
      </tr>
    </table>
    <div class="button_addmore" id="addToolMore" tabindex="4" ><img src="../core/css/images/add.png" width="16" height="16">เพิ่มอุปกรณ์</div>

	<footer>
	  <p>
	    <input name="confirm" type="hidden" value="1">
	    <br>
<center><input type="submit" class="button_sub" value="เพิ่ม" tabindex="4"></center>
      </p>
</footer>
</form>
</div>
<? }
 ?>
</body>
</html>
