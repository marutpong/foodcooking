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
</head>
<body><center>
<?
if (isset($_POST['email'])){
	include("../FoodFunction.php");
	include("../connectdb.php");
	$email = $_POST['email'];
	$length=10;
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	$newpass = str_shuffle($randomString);
	$msgheader = "Reset Password from www.foodcooking.com";
	$msgcontent = "รหัสผ่านใหม่ของคุณคือ :$newpass";
	
	$total = 0;
	$strSQL = "SELECT * FROM IUSERS WHERE EMAIL='$email'";
	$objParse = oci_parse($objConnect, $strSQL);
	oci_execute($objParse, OCI_DEFAULT);
	$total = oci_fetch_all($objParse, $Result);
	
	if($total==1){
		sendmail($email,$msgheader,$msgcontent);
		echo "E-mail has send";
		$strSQL = "update iusers set password = '$newpass' where EMAIL = '$email'";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse);
	}else{
		echo "Invalid E-mail";
	}
}
if ($total!=1) {
?><br>
<form action="" method="post">
  <input type="email" id="email" name="email" placeholder="E-mail">
  </input>
  <input type="submit" id="button" value="Submit">
  </input>
</form>
<? } ?>
<a href="../login.php"><br>
Back to Login</a></center>
</body>
</html>