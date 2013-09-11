<?
if (!isset($_SESSION)) {
  session_start();
}
include '../FoodFunction.php';
if ( !(isset($_SESSION['UIDS']) && isset($_SESSION['USERNAME'])  && authenIdUser($_SESSION['UIDS'],$_SESSION['USERNAME'])) ) {
	header ("Location: ../login.php?ref=".$_SERVER['PHP_SELF']);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Profile</title>
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

<form action="" method="post">
<div>
	  <table align="center">
      <?
	$ids = $_SESSION['UIDS'];
	$nameArray = split(",|and",$ids);
	include '../connectdb.php'; 
	foreach($nameArray as $id){
	if ($id!=""){
		$strSQL = "SELECT * FROM iusers Where UIDS=$id";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rows = array();
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
?>
	    <tr class="labelF">
	      <td align="right" class="labelF">ชื่อ :</td>
	      <td class="labelF"><input name="" type="hidden" id="id" value="<?=$id?>">
	        <?
            echo $row['NAME'];
			?></td>
        	
        </tr>

	    <tr>
	      <td align="right" class="labelF">Username :</td>
	      <td class="labelF"><?
            echo $row['USERNAME'];
			?></td>
        </tr>
	    
	    <tr>
	      <td align="right" class="labelF">เพศ :</td>
	      <td class="labelF"><?
            echo $row['GENDER'];
			?></td>
        </tr>
	    <tr>
	      <td align="right" class="labelF">วันเกิด :</td>
	      <td class="labelF"><?
            echo $row['BIRTHDATE'];
			?></td>
        </tr>
	    <tr>
	      <td height="36" align="right" valign="middle" class="labelF">E-mail :</td>
	      <td height="36" valign="middle" class="labelF"><?
            echo $row['EMAIL'];
			?></td>
        </tr>
<?
		}
	}
}
?>
    </table>
</div>
	<footer><center>
        <input type="button" value="Edit Profile" onclick="location.href='edit_profile.php'">
        <input type="button" value="Change Password" onclick="location.href='change_pass.php'">
        </center>
	</footer>
</form>
</body>
</html>