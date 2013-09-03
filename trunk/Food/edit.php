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
                <option value=""></option><? echo $rows;?></select></td>\
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
	print_r ($_POST['newfoodtype']);
	$picture = uploadImage("files/",$_FILES["picture"]);

	if (isset($_POST['name']) 
	&& isset($_POST['fid']) 
	&& isset($_POST['method']) 
	&& isset($_POST['views']) 
	&& isset($_POST['owner']) 
	&& isset($_POST['foodtype']) 
	&& $_POST['confirm']==2){

	include 'connectDB.php'; 
/*
		if (is_numeric($_POST['views'])){
			$strSQL = "UPDATE $table SET ";
			$strSQL .="FOODNAME = '".$_POST["name"]."'";
			if (!empty($picture)){
				$strSQL .=", PICTURE = '".$_POST["picture"]."' ";
			}
			$strSQL .=", METHOD = '".$_POST["method"]."' ";
			$strSQL .=", VIEWS = '".$_POST["views"]."' ";
			$strSQL .=", UIDS = '".$_POST["owner"]."' ";
			$strSQL .=", TYPEID = '".$_POST["foodtype"]."' ";
			$strSQL .=" WHERE FID = '".$_POST["fid"]."' ";
			$objParse = oci_parse($objConnect, $strSQL);
			$objExecute = oci_execute($objParse);
			if($objExecute){
				$count++;
			}
		}
*/
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
<div>
  <table id="dynamic_tb">
    <tr class="labelF">
      <td align="right" valign="top">ชื่ออาหาร :</td>
      <td><input name="name" type="text" autofocus  required class="input" id="name" tabindex="1" autocomplete="on" value="<? echo $row['FOODNAME']; ?>" size="50" ></td>
    </tr>
    <tr>
      <td align="right" valign="top"><span class="labelF">รูปภาพ :</span></td>
      <td><span class="labelF">
        <input name="picture" type="text"  required class="input" id="picture" tabindex="2" value="<? echo $row['PICTURE']; ?>" size="50">
      </span></td>
    </tr>
    <tr>
      <td align="right" valign="top" class="labelF">วิธีทำ :</td>
      <td><textarea name="method" cols="50" rows="10" required class="input" id="method" tabindex="2"><? echo $row['METHOD']; ?></textarea>
        <input name="views" type="hidden" required class="input number" id="views" tabindex="2" value="0"></td>
    </tr>
    <tr>
      <td align="right" valign="top" class="labelF">เจ้าของ :</td>
      <td><select class="labelF" id="owner" name="owner" required>
        <option value=""></option>
        <? echo optionUser($row['UIDS']);?>
      </select></td>
    </tr>
    <tr>
      <td align="right" valign="top" class="labelF">ประเภท :</td>
      <td><select class="labelF" id="foodtype" name="foodtype" >
        <option value=""></option>
        <? echo optionFoodType($row['TYPEID']);?>
      </select>
        <input name="newfoodtype" type="hidden"></td>
    </tr>
  </table>
  <table>
    <tr>
      <td valign="top" class="labelF">ส่วนผสม :</td>
      <td><div>
        <table border="0" id="addIngre">
        <?
		$strSQL = "SELECT * FROM ICONTAIN NATURAL JOIN IINGREDIENT Where FID=".$row['FID'];
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		while ($rowContain = oci_fetch_array($objParse, OCI_BOTH)) {
		?>
          <tr>
            <td width="263"><select class="labelF combobox" id="combobox" name="ingredient[]" >
              <option value=""></option>
              <? echo optionIngredient($rowContain['IID']);?>
            </select>
              <input name="newingredient[]" type="hidden" id="newingredient[]">
            </td>
            <td><input name="quantity[]" type="number"  required class="input number" id="quantity[]" min="0" tabindex="1" 
            onFocus="checkNum(this)" size="10" placeholder="จำนวน" value="<? echo $rowContain['QUANTITY']; ?>">
            </td>
            <td><input name="unit[]" type="text" disabled  required class="input unit" id="unit[]" tabindex="1" size="10" placeholder="หน่วย" value="<? echo $rowContain['UNIT']; ?>">
            </td>
            <td><div class="remove" onClick="removeOb(this)" id="<? echo $rowContain['IID']; ?>"><img src="../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div>
            </td>
          </tr>
          <? }
		  ?>
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
        <?
		$strSQL = "SELECT * FROM IUSE Where FID=".$row['FID'];
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		while ($rowTool = oci_fetch_array($objParse, OCI_BOTH)) {
		?>
      <tr>
        <td width="260"><select class="labelF combobox" id="tool[]" name="tool[]" >
          <option value=""></option>
          <? echo optionTool($rowTool['TID']);?>
        </select>
          <input name="newtool[]" type="hidden" id="newtool[]"></td>
        <td><div class="remove" onClick="removeOb(this)"><img src="../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>
      </tr>
      <? } ?>
    </table></td>
  </tr>
</table>
<div class="button_addmore" id="addToolMore" tabindex="4" ><img src="../core/css/images/add.png" width="16" height="16">เพิ่มอุปกรณ์</div>
<footer></footer>
<?
		}
	}
}
?>
</div>
	<footer><center>
	  <input name="fid" type="hidden" id="fid" value="<? echo $row['FID']; ?>">
    	<input name="confirm" type="hidden" id="confirm" value="2">
		<input type="submit" class="button_sub" value="แก้ไข" tabindex="4">
        </center>
	</footer>
</form>
<? }
} ?>
</body>
</html>