<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Edit User</title>
	<meta charset="UTF-8" />
	<link href="css/flexigrid2.css" rel="stylesheet" type="text/css">
	<link href="css/mystyle.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="js/jquery.numeric.js"></script>
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />
	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
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
	if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['gender']) && isset($_POST['birthdate']) && $_POST['confirm']==2) {
	$count = 0;
	$num = count($_POST['id']);
	include 'connectDB.php'; 
	
		$total = 0;
		if(isset($_POST['username'])){
			$sql = "select * from iusers where name = '$username'";
			$strSQL = $sql;
			$objParse = oci_parse($objConnect, $strSQL);
			$objExecute = oci_execute($objParse, OCI_DEFAULT);
			$total = oci_fetch_all($objParse, $Result);
		}
	//for ($i=0;$i<$num;$i++){
		if (total==0){
			$strSQL = "UPDATE $table SET ";
			$strSQL .="NAME = '".$_POST["name"]."'";
			$strSQL .=", username = '".$_POST["username"]."' ";
			$strSQL .=", password = '".$_POST["password"]."' ";
			$strSQL .=", gender = '".$_POST["gender"]."' ";
			$strSQL .=", birthdate = to_date('".$_POST["birthdate"]."','dd/mm/yyyy') ";
			$strSQL .=" WHERE ID = ".$_POST["id"]." ";
			//echo $strSQL;
			$objParse = oci_parse($objConnect, $strSQL);
			$objExecute = oci_execute($objParse);
			if($objExecute){
				$count++;
			}
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
	  <table>
	    <tr class="labelF">
	      <td>ชื่อ :</td>
	      <td>Username :</td>
	      <td>Password :</td>
		  <td>เพศ :</td>
		  <td>วันเกิด :</td>
        </tr>
<?
	$ids = $_GET['ids'];
	$nameArray = split(",|and",$ids);
	include 'connectDB.php'; 
	foreach($nameArray as $id){
	if ($id!=""){
		$strSQL = "SELECT * FROM $table Where ID=$id";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rows = array();
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
?>
	    <tr>
			<td>
          	<input name="id" type="hidden" id="id" value="<?=$id?>">
          	<input name="name" type="text"  required class="input" id="name" tabindex="1" value="<?=$row['NAME']?>">
			</td>
	      	<td>
            <input name="username" type="number" readonly="readonly" required class="input number" id="username" tabindex="2" value="<?=$row['USERNAME']?>" >
            </td>
	      	<td>
            <input name="password" type="text" required class="input" id="password" tabindex="2" value="<?=$row['PASSWORD']?>">
            </td>
			<td>
            <select name="gender" id="gender"><option value="MALE">MALE</option><option value="FEMALE">FEMALE</option>
            </td>
			<td>
            <input name="birthdate" type="date" required class="input" id="birthdate" tabindex="2" value="<?=$row['BIRTHDATE']?>">
            </td>
        </tr>
<?
		}
	}
}
?>
    </table>
</div>
	<footer>
    	<input name="confirm" type="hidden" id="confirm" value="2">
		<input type="submit" class="button_sub" value="แก้ไข" tabindex="4">
	</footer>
</form>
<? }
} ?>
</body>
</html>