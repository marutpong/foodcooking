<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Add User</title>
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
		var checkUser = 1;
		$("#birthdate").datepicker({dateFormat: 'dd-mm-yy'});
		$("#addUser").submit(function(e) {
			var rt = false;
			var url = 'chkuser.php?username='+$("#username").val();
			$.get(url,function(data){
				if(data==0) {
					rt = true;
				} else {
					alert("Username already used,Please try again.");
				}
				checkUser=data;
			});
			if (checkUser==0){
				return true;	
			} else {
				return false;
			}
        });
	});
//var checkNum = function(evt) {
//		$(evt).numeric({ negative: false }, function() { 
//			alert("No negative values"); this.value = ""; this.focus(); 
//		});
//}

</script>
</head>
<body>
<?
if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['gender']) && isset($_POST['birthdate']) && $_POST['confirm']==1){
	include 'connectDB.php'; 
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$gender = $_POST['gender'];
	$birthdate = $_POST['birthdate'];
	$count = 0;
	$num = count($_POST['name']);

	
	$total = 0;
	if(isset($_POST['username'])){
		$sql = "select * from iusers where name = '$username'";
		$strSQL = $sql;
		$objParse = oci_parse($objConnect, $strSQL);
        $objExecute = oci_execute($objParse, OCI_DEFAULT);
		$total = oci_fetch_all($objParse, $Result);
	}
	//echo $total;
	//for ($i=0;$i<$num;$i++){
		if ($total == 0){	
			$sql = "INSERT INTO $table (NAME, username, password, gender, birthdate) VALUES ('$name','$username','$password','$gender',to_date('" . $_POST['birthdate'] . "','dd/mm/yyyy'))";
			$strSQL = $sql;
			//echo $sql;
			$objParse = oci_parse($objConnect , $strSQL);
			$objExecute = oci_execute($objParse, OCI_DEFAULT);
			if($objExecute){
				oci_commit($objConnect);
				$count++;
			}
		}
	//}
	echo '<br><br><br><center><div class="textC1">';
	if($objExecute && $total==0){
		echo 'Add Succesful '.$count.' items<P>';
		echo '<a href="addMul.php"  class="button_addmore">Add more User</a>';
	} else {
		echo 'Unsuccessful, some input are incorect.';
	}
	echo '</div></center>';
} else {
?>
<div style="width:400">
<form action="" method="post" id="addUser">
<div>
    <table align="center" id="dynamic_tb">
	    <tr class="labelF">
	      <td align="right" class="labelF">ชื่อ :</td>
	      <td><input name="name" type="text"  required class="input" id="name" tabindex="1" ></td>
        </tr>
	    <tr>
	      <td align="right" class="labelF">Username :</td>
	      <td><input name="username" type="text"  required class="input number" id="username" tabindex="2"></td>
        </tr>
	    <tr>
	      <td align="right" class="labelF">Password :</td>
	      <td><input name="password" type="password" required class="input" id="password" tabindex="2"></td>
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
	      <td><input name="birthdate" type="date" required class="input" id="birthdate" tabindex="2"></td>
        </tr>
    </table>
</div>
	<footer>
	  <p>
	    <input name="confirm" type="hidden" value="1">
		<input name="chk" type="hidden" value=<?if($total==0){echo 0;}else{echo 1;}?>>
	    <br>
<center><input type="submit" class="button_sub" value="เพิ่ม" tabindex="4"></center>
      </p>
</footer>
</form>
</div>
<? } ?>

</body>
</html>
