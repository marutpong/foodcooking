<?
	include('../../FoodFunction.php');
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Add User</title>
	<meta charset="UTF-8" />
	<link href="../../core/css/flexigrid2.css" rel="stylesheet" type="text/css">
	<link href="../../core/css/mystyle.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../../core/css/jquery-ui-1.10.3.css">
	<script src="../../core/js/jquery-2.0.0.min.js"></script>
	<script src="../../core/js/jquery-ui-1.10.3.js"></script>
	<script src="../../core/js/validate/jquery.validate.min.js"></script>
	<script src="../../core/js/validate/additional-methods.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="../../core/css/tooltipster/reset.css">
    <link rel="stylesheet" type="text/css" href="../../core/css/tooltipster/style.css">
    <link rel="stylesheet" type="text/css" href="../../core/css/tooltipster/tooltipster.css">
    <script src="../../core/js/tooltipster/jquery.tooltipster.js"></script>
    
<script type="text/javascript" charset="UTF-8">
var checkUser = 1;
$(document).ready(function() {
		$("#birthdate").datepicker({
			changeMonth: true,
			changeYear: true,
			maxDate: "+0D",
			dateFormat: 'dd/mm/yy'
		});
$('input').tooltipster({ 
        trigger: 'custom', // default is 'hover' which is no good here
        onlyOne: true,    // allow multiple tips to be open at a time
        position: 'right'  // display the tips to the right of the element
    });
$( "#addUser" ).validate({
	rules: {
		username: {
			required: true,
			remote: {
				url: "chkuser.php",
				type: "get",
				data: {
					username: function() {
						return $( "#username" ).val();
					}
				}
			}
		},
		email: {
			required: true,
			remote: {
				url: "chkemail.php",
				type: "get",
				data: {
					email: function() {
						return $( "#email" ).val();
					}
				}
			}
		}
	},
	messages: {
	//name: "Please specify your name",
		username: {
		//required: "We need your email address to contact you",
		remote: "This Username already used."
		},
		email: {
		//required: "We need your email address to contact you",
		remote: "This E-mail already used."
		}
	},
		 errorPlacement: function (error, element) {
            $(element).tooltipster('update', $(error).text());
            $(element).tooltipster('show');
        },
        success: function (label, element) {
            // $(element).tooltipster('hide'); // normal validate behavior
            $(element).tooltipster('update', 'accepted'); // as per OP
        }
});
	});
</script>
</head>
<body>

<p>
  <?
if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['gender']) && isset($_POST['birthdate']) && isset($_POST['email']) && $_POST['confirm']==1){
	include 'connectDB.php'; 
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = sha1($_POST['password']);
	$gender = $_POST['gender'];
	$birthdate = $_POST['birthdate'];
	$email = $_POST['email'];
	$user_level = $_POST['user_level'];
	$count = 0;
	$num = count($_POST['name']);
	$total = 0;
		$sql = "select * from iusers where name = '$username'";
		$strSQL = $sql;
		$objParse = oci_parse($objConnect, $strSQL);
        $objExecute = oci_execute($objParse, OCI_DEFAULT);
		$total = oci_fetch_all($objParse, $Result);
	//echo $total;
	//for ($i=0;$i<$num;$i++){
		if ($total == 0){	
			$sql = "INSERT INTO $table (NAME, username, password, gender, birthdate, email, user_level) VALUES ('$name','$username','$password','$gender',to_date('" .$birthdate. "','dd/mm/yyyy'),'$email','$user_level')";
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
</p>
<div style="width:400">
  <form action="" method="post" id="addUser">
<div align="center" >
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table width="400" align="center" id="dynamic_tb">
	    <tr class="labelF">
	      <td width="100" height="36" align="right" valign="middle" class="labelF">ชื่อ :</td>
	      <td width="300" height="36" valign="middle" class="labelF"><input name="name" type="text"  required class="input" id="name" tabindex="1" ></td>
        </tr>
	    <tr>
	      <td width="100" height="36" align="right" valign="middle" class="labelF">Username :</td>
	      <td width="300" height="36" valign="middle" class="labelF"><input name="username" type="text"  required class="input" id="username" tabindex="2"></td>
        </tr>
	    <tr>
	      <td width="100" height="36" align="right" valign="middle" class="labelF">Password :</td>
	      <td width="300" height="36" valign="middle" class="labelF"><input name="password" type="password" required class="input" id="password" tabindex="2"></td>
        </tr>
	    <tr>
	      <td width="100" height="36" align="right" valign="middle" class="labelF">เพศ :</td>
	      <td width="300" height="36" valign="middle" class="labelF">
          
          <select name="gender" id="gender">
	        <option value="MALE">MALE</option>
	        <option value="FEMALE">FEMALE</option>
          </select></td>
        </tr>
	    <tr>
	      <td width="100" height="36" align="right" valign="middle" class="labelF">วันเกิด :</td>
	      <td width="300" height="36" valign="middle" class="labelF"><input name="birthdate" type="text" required class="input" id="birthdate" tabindex="2"></td>
        </tr>
	    <tr>
	      <td height="36" align="right" valign="middle" class="labelF">E-mail :</td>
	      <td height="36" valign="middle" class="labelF"><input name="email" type="email"  required class="input" id="email" tabindex="2"></td>
        </tr>
	    <tr>
	      <td height="36" align="right" valign="middle" class="labelF">User Level</td>
	      <td height="36" valign="middle" class="labelF"><select name="user_level" id="user_level">
	        <option value=""></option>
	        <option value="1">Admin</option>
	        <option value="2">User</option>
          </select></td>
        </tr>
    </table>
</div>
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
