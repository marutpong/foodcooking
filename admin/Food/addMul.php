<?
if (!isset($_SESSION)) {
  session_start();
}
include('../../FoodFunction.php');
include 'connectDB.php'; 
$rows = optionIngredient("");
$rowsTool = optionTool("");
$rowsUser = optionUser("");
$rowsFoodtype = optionFoodType("");
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Add Food</title>
	<meta charset="UTF-8" />
	<script type="text/javascript" src="../../core/js/jquery-1.6.4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../../core/css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="../../core/css/mystyle.css">
    <script src="../../core/js/jquery-2.0.0.min.js"></script>
    <script src="../../core/js/jquery-ui-1.10.3.js"></script>
	<script type="text/javascript" src="../../core/js/jquery.numeric.js"></script>
    <script src="../../core/js/combobox.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#name').focus();
		$( ".combobox" ).combobox();
		$( "#foodtype" ).combobox();
		$('#addmore').click(function () {
			var htmlStr = '<tr>\
              <td width="200"><select class="labelF combobox" id="combobox" name="ingredient[]" >\
                <option value=""></option><? echo $rows;?></select>\
                <input name="newingredient[]" type="hidden" id="newingredient[]"></td>\
              <td><input name="quantity[]" type="number"   class="input number" id="quantity[]" min="0" step="any" tabindex="1" required \
            onFocus="checkNum(this)" size="10" placeholder="จำนวน" style="width:60px;"></td>\
              <td><input name="unit[]" type="text" readonly  required class="input unit" id="unit[]" tabindex="1" size="10" placeholder="หน่วย" style="width:100px;"></td>\
              <td><div class="remove" onClick="removeOb(this)"><img src="../../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>\
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
            <td><div class="remove" onClick="removeOb(this)"><img src="../../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>\
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
	$picture = uploadImage("../../files/",$_FILES["picture"]);
// Food Type ///
	if ( isset($_POST['foodtype']) && !empty($_POST['foodtype']) ) {
		$foodtypeID = $_POST['foodtype'];
	} else if ( isset($_POST['newfoodtype']) && !empty($_POST['newfoodtype']) ){
		$foodtypeID = insertFoodType($_POST['newfoodtype'],'');
	}
if (isset($_POST['name']) 
	&& isset($_POST['method']) 
	&& !empty($foodtypeID) 
	&& $_POST['confirm']==1){
	
	if (isset($_SESSION["UIDS"])) {
		$owner = $_SESSION["UIDS"];
	} else if (isset($_POST['owner'])){
		$owner = $_POST['owner'];
	}
	
	$name = $_POST['name'];
	$method = $_POST['method'];
	$views = 0;
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
	      <td><input name="name" type="text"  autofocus autocomplete="on" class="input" id="name" tabindex="1" size="50" required ></td>
        </tr>
	    <tr>
	      <td align="right" valign="top"><span class="labelF">รูปภาพ :</span></td>
	      <td><span class="labelF">
	        <input name="picture" type="file"  class="input" id="picture" tabindex="2" size="50" >
	      </span></td>
        </tr>
	    <tr>
	      <td align="right" valign="top" class="labelF">วิธีทำ :</td>
	      <td bgcolor="white"><script type="text/javascript" src="../../core/js/nicEdit-latest.js"></script>
	        <script type="text/javascript">
//<![CDATA[
bkLib.onDomLoaded(function() {
new nicEditor().panelInstance('area1');
new nicEditor({fullPanel : true}).panelInstance('area2');
new nicEditor({iconsPath : '../nicEditorIcons.gif'}).panelInstance('area3');
new nicEditor({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','html','image']}).panelInstance('area4');
new nicEditor({maxHeight : 100}).panelInstance('area5');
});
//]]>
            </script>
	        <textarea name="method" cols="50" rows="10" class="mytextarea" id="area1" tabindex="2" ></textarea></td>
        </tr>
        <? 
			if (isset($_SESSION["UIDS"])){
				echo '<input name="owner" type="hidden" value="'.$_SESSION["UIDS"].'">';
			} else {
		?>
	    <tr>
	      <td align="right" valign="top" class="labelF">เจ้าของ :</td>
	      <td><select class="labelF" id="owner" name="owner" required >
	        <option value=""></option>
	        <? echo $rowsUser;?>
          </select>
          </td>
        </tr>
        <? }?>
	    <tr>
	      <td align="right" valign="top" class="labelF">ประเภท :</td>
	      <td><select class="labelF" id="foodtype" name="foodtype" required>
	        <option value=""></option>
	        <? echo $rowsFoodtype;?>
          </select><input name="newfoodtype" type="hidden"></td>
        </tr>
    </table>
    <table width="500">
      <tr>
        <td width="75" valign="top" class="labelF">ส่วนผสม :</td>
        <td width="425"><div>
          <table width="420" border="0" id="addIngre">
            <tr>
              <td width="200"><select class="labelF combobox" id="combobox" name="ingredient[]" >
                <option value=""></option><? echo $rows;?>
              </select>
                <input name="newingredient[]" type="hidden" id="newingredient[]"></td>
              <td><input name="quantity[]" type="number"   class="input number" id="quantity[]" min="0" step="any" tabindex="1" 
            onFocus="checkNum(this)" size="10" placeholder="จำนวน" style="width:60px;" required></td>
              <td><input name="unit[]" type="text"  class="input unit" id="unit[]" placeholder="หน่วย" tabindex="1" size="10" readonly style="width:100px;" required></td>
              <td><div class="remove" onClick="removeOb(this)"><img src="../../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>
            </tr>
          </table>
        </div></td>
        </tr>
    </table>
    <div class="button_addmore" id="addmore" tabindex="4" ><img src="../../core/css/images/add.png" width="16" height="16">เพิ่มส่วนผสม</div>
</div>

<table>
      <tr>
        <td valign="top" class="labelF">อุปกรณ์ :</td>
        <td><table id="addTool">
          <tr>
            <td width="200"><select class="labelF combobox" id="tool[]" name="tool[]">
              <option value=""></option>
              <? echo $rowsTool;?></select>
              <input name="newtool[]" type="hidden" id="newtool[]"></td>
            <td><div class="remove" onClick="removeOb(this)"><img src="../../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>
            </tr>
        </table></td>
      </tr>
    </table>
    <div class="button_addmore" id="addToolMore" tabindex="4" ><img src="../../core/css/images/add.png" width="16" height="16">เพิ่มอุปกรณ์</div>

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
