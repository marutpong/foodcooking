<!DOCTYPE HTML>
<html>
<head>
<title>Edit Food</title>
<meta charset="UTF-8" />
<link href="../core/css/mystyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../core/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../core/js/jquery.numeric.js"></script>
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
	if (isset($_POST['name']) 
	&& isset($_POST['picture']) 
	&& isset($_POST['method']) 
	&& isset($_POST['views']) 
	&& isset($_POST['owner']) 
	&& isset($_POST['foodtype']) 
	&& $_POST['confirm']==2){

	include 'connectDB.php'; 

		if (is_numeric($_POST['views'])){
			$strSQL = "UPDATE $table SET ";
			$strSQL .="FOODNAME = '".$_POST["name"]."'";
			$strSQL .=", PICTURE = '".$_POST["picture"]."' ";
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
	  <table align="center">
	    <tr class="labelF">
	      <td align="right" class="labelF">ชื่ออาหาร :</td>
	      <td><input name="name" type="text"  required class="input" id="name" tabindex="1" value="<?=$row['FOODNAME']?>">
          <input name="fid" type="hidden" id="fid" value="<?=$id?>"></td>
        </tr>
	    <tr>
	      <td align="right" class="labelF">รูปภาพ :</td>
	      <td><input name="picture" type="text" required class="input" id="picture" tabindex="2" value="<?=$row['PICTURE']?>"></td>
        </tr>
	    <tr>
	      <td align="right" class="labelF">วิธีทำ :</td>
	      <td><input name="method" type="text" required class="input" id="method" tabindex="2" value="<?=$row['METHOD']?>"></td>
        </tr>
	    <tr>
	      <td align="right" class="labelF">จำนวนคนดู :</td>
	      <td><input name="views" type="number" required class="input number" id="views" tabindex="2" value="<?=$row['VIEWS']?>" size="10" onFocus="javascript:checkNum(this)"></td>
        </tr>
	    <tr>
	      <td align="right" valign="top" class="labelF">เจ้าของ :</td>
	      <td><select class="labelF" id="owner" name="owner" onChange="getUnit(this)" required>
	        <option value=""></option>
	        <? 
		$strSQL2 = "SELECT * FROM IUSERS";
		$objParse2 = oci_parse($objConnect, $strSQL2);
		$objExecute2 = oci_execute($objParse2, OCI_DEFAULT);
		$rowsUser="";
		while ($row2 = oci_fetch_array($objParse2, OCI_BOTH)) {
			$selected = "";
			if ($row2['UIDS']==$row['UIDS']){ $selected = "selected"; }
			$rowsUser.= '<option value="'.$row2['UIDS'].'" '.$selected.'>'.$row2['NAME'].'</option>';
		}
		$strSQL3 = "SELECT * FROM IFOODTYPE";
		$objParse3 = oci_parse($objConnect, $strSQL3);
		$objExecute3 = oci_execute($objParse3, OCI_DEFAULT);
		$rowsFoodtype="";
		while ($row3 = oci_fetch_array($objParse3, OCI_BOTH)) {
			$selected = "";
			if ($row3['TYPEID']==$row['TYPEID']){ $selected = "selected"; }
			$rowsFoodtype.= '<option value="'.$row3['TYPEID'].'" '.$selected.'>'.$row3['TYPENAME'].'</option>';
		}
		
			echo $rowsUser;?>
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
	    <?
		}
	}
}
?>
</div>
	<footer><center>
    	<input name="confirm" type="hidden" id="confirm" value="2">
		<input type="submit" class="button_sub" value="แก้ไข" tabindex="4">
        </center>
	</footer>
</form>
<? }
} ?>
</body>
</html>