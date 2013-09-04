<?
$email = $_POST['email'];
$length=10;
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$randomString = '';
for ($i = 0; $i < $length; $i++) {
	$randomString .= $characters[rand(0, strlen($characters) - 1)];
}
$newpass = str_shuffle($randomString);
//echo $newpass;

require("PHPMailer_5.2.4/class.phpmailer.php");
$htmlbody = "<b>รหัสผ่านใหม่ของคุณคือ :$newpass</b>";
$mail = new PHPMailer();
$mail->IsSMTP(); 
$mail->SMTPDebug = 2;
$mail->IsHTML(true);
$mail->CharSet = "UTF-8"; 
$mail->SMTPAuth = true;
$mail->Host = "smtp.mail.yahoo.com"; 
$mail->Username = "foodcooking_g10@yahoo.com"; 
$mail->Password = "Emailg10"; 
$mail->SetFrom("foodcooking_g10@yahoo.com", "Webmaster"); 
$mail->Subject = "Reset Password from www.foodcooking.com"; 
$mail->AltBody = "รหัสผ่านใหม่ของคุณคือ :$newpass"; 
$mail->Body = $htmlbody;
$mail->AddAddress("$email"); 
if ( $mail->Send() )
{ 
	echo "<p>รหัสผ่านได้ส่งไปยัง E-mail ของคุณ</p>"; 
}else
{
echo "<p>ส่งอีเมลไม่สำเร็จ โปรดดูรายละเอียด debug</p>". $mail->ErrorInfo;
} 
?>