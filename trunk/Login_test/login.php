<? 
if (!isset($_SESSION)) {
  session_start();
}
if(isset($_POST["username"]) && isset($_POST["password"])){
	include '../connectdb.php';
	$username = $_POST["username"];
	$password = $_POST["password"];
	$strSql = "SELECT * FROM IUSERS WHERE USERNAME = '".$username."' AND PASSWORD = '".$password."'";
	$objParse = oci_parse($objConnect, $strSql);
	oci_execute($objParse, OCI_DEFAULT);
	if($row = oci_fetch_array($objParse, OCI_BOTH)){
		$_SESSION["UIDS"] = $row["UIDS"];
		$_SESSION["USERNAME"] = $row["USERNAME"];
		session_write_close();
		header( "location: show_pro.php" );
		//echo '<meta http-equiv="refresh" content="0;url=show_pro.php"> ';
	}else{
		echo '<meta http-equiv="refresh" content="0;url=login.php?msg=Wrong Username or Password"> ';
	}
} else {
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Login</title>
	<meta charset="UTF-8" />
	<link href="../core/css/flexigrid2.css" rel="stylesheet" type="text/css">
	<link href="../core/css/mystyle.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../core/css/jquery-ui-1.10.3.css">
	<script src="../core/js/jquery-2.0.0.min.js"></script>
	<script src="../core/js/jquery-ui-1.10.3.js"></script>
	<script src="../core/js/validate/jquery.validate.min.js"></script>
	<script src="../core/js/validate/additional-methods.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="../core/css/tooltipster/reset.css">
    <link rel="stylesheet" type="text/css" href="../core/css/tooltipster/style.css">
    <link rel="stylesheet" type="text/css" href="../core/css/tooltipster/tooltipster.css">
    <script src="../core/js/tooltipster/jquery.tooltipster.js"></script>
    
<script type="text/javascript" charset="UTF-8">
var checkUser = 1;
$(document).ready(function() {
		$("#birthdate").datepicker({
			changeMonth: true,
			changeYear: true,
			maxDate: "+0D",
			dateFormat: 'dd/mm/yy'
		});
	});
</script>
</head>
<body>

<p>

</p>
<div style="width:400">
  <form action="" method="post" id="addUser">
<div align="center" >
    <p>&nbsp;</p>
    <span class="textC1">    Log In</span>
<table width="400" align="center" id="dynamic_tb">
	    <tr>
	      <td width="100" height="36" align="right" valign="middle" class="labelF">Username :</td>
	      <td width="300" height="36" valign="middle" class="labelF"><input name="username" type="text"  required class="input" id="username" tabindex="2"></td>
        </tr>
	    <tr>
	      <td width="100" height="36" align="right" valign="middle" class="labelF">Password :</td>
	      <td width="300" height="36" valign="middle" class="labelF"><input name="password" type="password" required class="input" id="password" tabindex="2"></td>
        </tr>
    </table>
</div>
	<footer><center>
	  <? if(isset($_GET['msg'])) {echo $_GET['msg'];} ?><br>
<input type="submit" class="button_sub" value="Login" tabindex="4">
<a href="singup.php">Sign up for a new account</a>
	</center>
      </p>
</footer>
</form>
</div>
</body>
</html>
<? } ?>