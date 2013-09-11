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
	 <center> <span class="textC1">Welcome User : <?=$_SESSION['USERNAME']?></span>
	 </center>
</div>
	<footer><center>
    	<br>
        <input type="button" value="ข้อมูลส่วนตัว" onclick="location.href='show_profile.php'">
        </br><br>
        <input type="button" value="เพิ่มอาหาร" onclick="">
        </br><br>
        <input type="button" value="Logout" onclick="location.href='../logout.php'">
        </br>
        </center>
	</footer>
</form>
</body>
</html>