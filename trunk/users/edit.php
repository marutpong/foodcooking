<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Edit User</title>
	<meta charset="UTF-8" />
	<link href="../core/css/flexigrid2.css" rel="stylesheet" type="text/css">
	<link href="../core/css/mystyle.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../core/js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="../core/js/jquery.numeric.js"></script>
    <link rel="stylesheet" type="text/css" href="../core/css/jquery-ui-1.10.3.css">
	<script src="../core/js/jquery-2.0.0.min.js"></script>
	<script src="../core/js/jquery-ui-1.10.3.js"></script>
	<script type="text/javascript" charset="UTF-8">
	$(document).ready(function() {
		$("#birthdate").datepicker({dateFormat: 'dd-mm-yy'});
		$("#chkusername").click(function(){
			var url = 'chkuser.php?username='+$("#username").val();
			var chk = $.get(url,function(data){
				if(data==1) {alert("Username นี้ถูกใช้ไปแล้ว");}
				else alert("สามารถใช้ Username นี้ได้");
			});
			
		});
	});
</script>
</head>
<body>
<?
	if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['gender']) && isset($_POST['birthdate']) && isset($_POST['email']) && $_POST['confirm']==2) {
	$count = 0;
	include 'connectDB.php'; 
	$id = $_POST['id'];
			$strSQL = "UPDATE $table SET ";
			$strSQL .="NAME = '".$_POST["name"]."'";
			$strSQL .=", password = '".$_POST["password"]."' ";
			$strSQL .=", gender = '".$_POST["gender"]."' ";
			$strSQL .=", birthdate = to_date('".$_POST["birthdate"]."','dd/mm/yyyy') ";
			$strSQL .=", email = '".$_POST["email"]."' ";
			$strSQL .=" WHERE UIDS = ".$_POST["id"]." ";
			//echo $strSQL;
			$objParse = oci_parse($objConnect, $strSQL);
			$objExecute = oci_execute($objParse);
			if($objExecute){
				$count++;
			}
		
	//}
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
	  <table align="center">
      <?
	$ids = $_GET['ids'];
	$nameArray = split(",|and",$ids);
	include 'connectDB.php'; 
	foreach($nameArray as $id){
	if ($id!=""){
		$strSQL = "SELECT * FROM $table Where UIDS=$id";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rows = array();
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
?>
	    <tr class="labelF">
	      <td align="right" class="labelF">ชื่อ :</td>
	      <td><input name="id" type="hidden" id="id" value="<?=$id?>">
	        <input name="name" type="text"  required class="input" id="name" tabindex="1" value="<?=$row['NAME']?>"></td>
        </tr>

	    <tr>
	      <td align="right" class="labelF">Username :</td>
	      <td><input name="username" type="text" readonly required class="input number" id="username" tabindex="2" value="<?=$row['USERNAME']?>" ></td>
        </tr>
	    <tr>
	      <td align="right" class="labelF">Password :</td>
	      <td><input name="password" type="password" required class="input" id="password" tabindex="2" value="<?=$row['PASSWORD']?>"></td>
        </tr>
	    <tr>
	      <td align="right" class="labelF">เพศ :</td>
	      <td><select name="gender" id="gender">
	        <option value="MALE">MALE</option>
	        <option value="FEMALE">FEMALE</option>
          </select></td>
        </tr>
	    <tr>
	      <td align="right" class="labelF">วันเกิด :</td>
	      <td><input name="birthdate" type="date" required class="input" id="birthdate" tabindex="2" value="<?=$row['BIRTHDATE']?>"></td>
        </tr>
	    <tr>
	      <td height="36" align="right" valign="middle" class="labelF">E-mail :</td>
	      <td height="36" valign="middle" class="labelF"><input name="email" type="email"  required class="input" id="email" tabindex="2" value="<?=$row['EMAIL']?>"></td>
        </tr>
<?
		}
	}
}
?>
    </table>
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