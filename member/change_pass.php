<?
if (!isset($_SESSION)) {
  session_start();
}
include '../FoodFunction.php';
if ( !authenIdUser() ) {
	header ("Location: ../login.php?ref=".$_SERVER['PHP_SELF']);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Change Password</title>
	<link href="../core/css/mystyle.css" rel="stylesheet" type="text/css">

</head>

<body>
<?
	if (isset($_POST['password_old']) && isset($_POST['password1']) && isset($_POST['password2'])  && ($_POST['password2'] == $_POST['password1'])) {
		if($row = Login($_SESSION['USERNAME'],$_POST['password_old'])){
			
			$strSQL = "UPDATE IUSERS SET ";
			$strSQL .="password = '".sha1($_POST["password2"])."'";			
			$strSQL .=" WHERE UIDS = ".$_SESSION['UIDS']." ";
			//echo $strSQL;
			$result = myExe($strSQL);
		} else {
			$msg = "You enter wrong password.";
		}			
			
		echo '<br><center><div class="textC1">';
		if($result){
			echo 'Edited Successful';
		} else {
			echo $msg.'<br>Edit Unsuccessful, some input are incorect.';
		}
		echo '</div></center>';
}else{
?>
	
    	<div id="divmiddle">
        	<div id="logo"></div>
            <div id="form">
            	<form action="" method="post">
                
               		<table width="400" align="center" id="dynamic_tb">
                    <tr>
                    	
                      <td width="100" height="36" align="right" valign="middle" class="labelF">รหัสผ่านเก่า :</td>
                      <td width="300" height="36" valign="middle" class="labelF"><input name="password_old" type="password"  required class="input" id="password" tabindex="2"></td>
                    </tr>
                    <tr>
                      <td width="100" height="36" align="right" valign="middle" class="labelF">รหัสผ่านใหม่ :</td>
                      <td width="300" height="36" valign="middle" class="labelF"><input name="password1" type="password" required class="input" id="password" tabindex="2"></td>
                    </tr>
                    <tr>
                      <td width="100" height="36" align="right" valign="middle" class="labelF">ยืนยันรหัสผ่าน :</td>
                      <td width="300" height="36" valign="middle" class="labelF"><input name="password2" type="password" required class="input" id="password" tabindex="2"></td>
                    </tr>
                </table>
                    <center> <input type="submit" class="button_sub" id="button" value="ตกลง"></input> </center>
                </form>
                
            </div>
    	</div>
    <? } ?>
</body>
</html>
