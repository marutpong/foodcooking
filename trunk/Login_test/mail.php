<?
include("../FoodFunction.php");
include("connectDB.php");
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
}else{
	echo "Invalid E-mail";
}
$strSQL = "update iusers set password = '$newpass' where EMAIL = '$email'";
$objParse = oci_parse($objConnect, $strSQL);
$objExecute = oci_execute($objParse);
?>