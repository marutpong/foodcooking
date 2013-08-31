<!DOCTYPE HTML>
<html>
<head>
	<title>Add Food</title>
	<meta charset="UTF-8" />
	<link href="../core/css/flexigrid2.css" rel="stylesheet" type="text/css">
	<link href="../core/css/mystyle.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../core/js/jquery-1.6.4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../core/css/jquery-ui.css">
    <script src="../core/js/jquery-2.0.0.min.js"></script>
    <script src="../core/js/jquery-ui-1.10.3.js"></script>
	<script type="text/javascript" src="../core/js/jquery.numeric.js"></script>
    <script src="../core/js/combobox.js"></script>
 	<?
		include 'connectDB.php'; 
		$strSQL = "SELECT * FROM IINGREDIENT";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rows="";
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			$rows.= '<option value="'.$row['IID'].'">'.$row['INNAME'].'</option>';
		}
		
		$strSQL = "SELECT * FROM ITOOLS";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rowsTool="";
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			$rowsTool.= '<option value="'.$row['TID'].'">'.$row['TOOLNAME'].'</option>';
		}
		
		$strSQL = "SELECT * FROM IUSERS";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rowsUser="";
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			$rowsUser.= '<option value="'.$row['UIDS'].'">'.$row['NAME'].'</option>';
		}
		$strSQL = "SELECT * FROM IFOODTYPE";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rowsFoodtype="";
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			$rowsFoodtype.= '<option value="'.$row['TYPEID'].'">'.$row['TYPENAME'].'</option>';
		}
	?>
<script type="text/javascript">
$(document).ready(function() {
		$('#name').focus();
		$( ".combobox" ).combobox();
		$('#addmore').click(function () {
			var htmlStr = '<tr>\
              <td width="263"><select class="labelF combobox" id="combobox" name="ingredient[]" onChange="getUnit(this)" required>\
                <option value=""></option><? echo $rows;?></select></td>\
              <td><input name="quantity[]" type="number"  required class="input number" id="quantity[]" min="0" tabindex="1" \
            onFocus="checkNum(this)" size="10"></td>\
              <td><input name="unit[]" type="text" disabled  required class="input unit" id="unit[]" tabindex="1" size="10"></td>\
              <td><div class="remove" onClick="removeOb(this)"><img src="../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>\
            </tr>';
			$('#addIngre').append(htmlStr);
			$( ".combobox" ).combobox();
		});
		$('#addToolMore').click(function () {
			var htmlStr = '<tr>\
            <td width="260"><select class="labelF combobox" id="tool[]" name="tool[]" required>\
              <option value=""></option>\
              <? echo $rowsTool;?></select></td>\
            <td><div class="remove" onClick="removeOb(this)"><img src="../core/css/images/close.png" width="16" height="16"></div></td>\
            </tr>';
			$('#addTool').append(htmlStr);
			$( ".combobox" ).combobox();
		});
		

	});
var checkNum = function(evt) { 
		$(evt).numeric({ negative: false }, function() { 
			alert("No negative values"); this.value = ""; this.focus();
			$('.unit').val("11");
		});
}
var removeOb = function(e) {
	$(e).parent().parent().remove();
};
var getUnit = function(evt) {
	/*var url = 'getunit.php?id='+$(evt).val();
	$.get(url, function(data) {
		$(evt).parent().next().next().find("input").val(data);
	});*/
}
</script>

  <style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
    /* support: IE7 */
    *height: 1.7em;
    *top: 0.1em;
	
  }
  .custom-combobox-input {
    margin: 0;
    padding: 0.3em;
  }
  </style>
</head>
<body>
<?
if (isset($_POST['name']) 
	&& isset($_POST['picture']) 
	&& isset($_POST['method']) 
	&& isset($_POST['views']) 
	&& isset($_POST['owner']) 
	&& isset($_POST['foodtype']) 
	&& $_POST['confirm']==1){
		
	$name = $_POST['name'];
	$picture = $_POST['picture'];
	$method = $_POST['method'];
	$views = $_POST['views'];
	$owner = $_POST['owner'];
	$foodtype = $_POST['foodtype'];
	include 'connectDB.php'; 
	if (is_numeric($_POST['views'])){	
			$sql = "INSERT INTO $table (FOODNAME, PICTURE, METHOD, VIEWS, UIDS, TYPEID) VALUES ('$name','$picture','$method','$views','$owner','$foodtype')";
			$strSQL = $sql;
			//echo $sq."<br>";
			$objParse = oci_parse($objConnect , $strSQL);
			$objExecute = oci_execute($objParse);
			if($objExecute){
				$count++;
			}
	}
	
	echo '<br><br><br><center><div class="textC1">';
	if($count){
		$strSQL = "SELECT * FROM IFOODS WHERE FOODNAME = '$name'";
		$objParse = oci_parse($objConnect, $strSQL);
    	$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$row = oci_fetch_array($objParse, OCI_BOTH);	   	
		$fid =  $row['FID'];
		//echo $fid;
		if ( isset($_POST['ingredient']) && isset($_POST['quantity']) && (is_numeric($fid)) ){
			$ingredient = $_POST['ingredient'];
			$quantity = $_POST['quantity'];
			$num = count($_POST['ingredient']);
			for ($i=0;$i<$num;$i++){
				if (is_numeric($_POST['quantity'][$i])){	
					$sql = "INSERT INTO ICONTAIN (FID, IID, QUANTITY) VALUES ('$fid','$ingredient[$i]','$quantity[$i]')";
					$strSQL = $sql;
					$objParse = oci_parse($objConnect , $strSQL);
					$objExecute = oci_execute($objParse);
				}
			}
		}
		if ( isset($_POST['tool']) && (is_numeric($fid)) ){
			$tool = $_POST['tool'];
			$num = count($_POST['tool']);
			for ($i=0;$i<$num;$i++){
				if (is_numeric($_POST['tool'][$i])){	
					$sql = "INSERT INTO IUSE (FID, TID) VALUES ('$fid','$tool[$i]')";
					$strSQL = $sql;
					$objParse = oci_parse($objConnect , $strSQL);
					$objExecute = oci_execute($objParse);
				}
			}
		}
		
		echo 'Add Succesful '.$count.' items<P>';
		echo '<a href="addMul.php"  class="button_addmore">Add more Food</a>';
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
	      <td align="right" valign="top">ชื่ออาหาร :</td>
	      <td><input name="name" type="text"  required autofocus autocomplete="on" class="input" id="name" tabindex="1" size="50"></td>
        </tr>
	    <tr>
	      <td align="right" valign="top"><span class="labelF">รูปภาพ :</span></td>
	      <td><span class="labelF">
	        <input name="picture" type="text"  required class="input" id="picture" tabindex="2" size="50">
	      </span></td>
        </tr>
	    <tr>
	      <td align="right" valign="top" class="labelF">วิธีทำ :</td>
	      <td><textarea name="method" cols="50" rows="10" required class="input" id="method" tabindex="2"></textarea>
          <input name="views" type="hidden" required class="input number" id="views" tabindex="2" value="0"></td>
        </tr>
	    <tr>
	      <td align="right" valign="top" class="labelF">เจ้าของ :</td>
	      <td><select class="labelF" id="owner" name="owner" onChange="getUnit(this)" required>
	        <option value=""></option>
	        <? echo $rowsUser;?>
          </select></td>
        </tr>
	    <tr>
	      <td align="right" valign="top" class="labelF">ประเภท :</td>
	      <td><select class="labelF" id="foodtype" name="foodtype" onChange="getUnit(this)" required>
	        <option value=""></option>
	        <? echo $rowsFoodtype;?>
          </select></td>
        </tr>
    </table>
    <table>
      <tr>
        <td valign="top" class="labelF">ส่วนผสม :</td>
        <td><div>
          <table border="0" id="addIngre">
            <tr>
              <td width="263"><select class="labelF combobox" id="combobox" name="ingredient[]" onChange="getUnit(this)" required>
                <option value=""></option><? echo $rows;?>
              </select></td>
              <td><input name="quantity[]" type="number"  required class="input number" id="quantity[]" min="0" tabindex="1" 
            onFocus="checkNum(this)" size="10"></td>
              <td><input name="unit[]" type="text" disabled  required class="input unit" id="unit[]" tabindex="1" size="10"></td>
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
            <td width="260"><select class="labelF combobox" id="tool[]" name="tool[]" required>
              <option value=""></option>
              <? echo $rowsTool;?></select></td>
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
<? } ?>
</body>
</html>
