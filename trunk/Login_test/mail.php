<?
include("../FoodFunction.php");
include("connectdb.php");
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
sendmail($email,$msgheader,$msgcontent);

$strSQL = "update iusers set password = '$newpass' where EMAIL = '$email'";
$objParse = oci_parse($objConnect, $strSQL);
$objExecute = oci_execute($objParse);
?>