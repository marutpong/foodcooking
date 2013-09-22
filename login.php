<? 
if (!isset($_SESSION)) {
  session_start();
}
include 'FoodFunction.php';
if (isset($_GET['relog']) && ($_GET['relog']==1)){
	unset($_SESSION['UIDS']);
	unset($_SESSION['USERNAME']);
}
if (authenIdUser()) {
	if (!($_GET['noredirect']==1)) {
		header ("Location: index.php");
	}
}

if(isset($_POST["username"]) && isset($_POST["password"])){
	include 'connectdb.php';
	$username = $_POST["username"];
	$password = $_POST["password"];
	if($row = Login($username,$password)){
		$_SESSION["UIDS"] = $row["UIDS"];
		$_SESSION["NAME"] = $row["NAME"];
		$_SESSION["USERNAME"] = $row["USERNAME"];
		$_SESSION["USER_LEVEL"] = $row["USER_LEVEL"];

		//$_SESSION["PASSWORD"] = $row["PASSWORD"];
		//$_SESSION["GENDER"] = $row["GENDER"];
		//$_SESSION["BIRTHDATE"] = $row["BIRTHDATE"];
		//$_SESSION["EMAIL"] = $row["EMAIL"];
		session_write_close();
		if (!empty($_GET['ref'])){
			header( "location: {$_GET['ref']}" );	
		}else{
			header( "location: index.php" );
		}
		//echo '<meta http-equiv="refresh" content="0;url=show_pro.php"> ';
	}else{
			header( "location: login.php?msg=Invalid Username or Password!" );
			//echo '<meta http-equiv="refresh" content="0;url=login.php?msg=Wrong Username or Password"> ';
	}
} else {
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="stylesheet" href="css/calendar.css" media="all">
<!-- Basic Page Needs -->
<meta charset="utf-8">
<title>Login</title>
<meta name="description" content>
<meta name="author" content>
<!-- CSS Style -->
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<!-- Short Codes Style -->
<link rel="stylesheet" href="css/shortcode.css" type="text/css" media="all">
<!-- Start Java CSS -->
<link rel="stylesheet" href="css/javascri.css" type="text/css" media="all">
<!-- Color Schemes CSS -->
<link rel="stylesheet" href="css/colors-scheme.css" type="text/css" media="all">
<!--[if lt IE 9]>
      <script src="js/html5.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="css/boxstyle.css">

</head>
<body id="def">
<div class="wrapper"> 
  <!-- header -->
  <header id="header">
    <div class="main-holder">
      <h1 id="logo"><a href="index.php"></a></h1>
      <nav class="nav">
        <? include('_navbar.php'); ?>
      </nav>
    </div>
  </header>
  
  <div class="sloganwrapper">
    <div class="main-holder ">
      <ul class="breadcrumb">
        <li><a href="index.php">HOME</a></li>
        <li>Login</li>
      </ul>
    </div>
  </div>
  <!-- Content -->
  <section class="main-content">
  <span class="top-bg"></span>
  <div class="holder-container">
  	<center>
    <? if(isset($_GET['msg'])) {?>
  	  <div class="alert error hideit" style="width:300px;">
  	    <p><? echo $_GET['msg']; ?></p>
  	    <span class="close"></span></div>
        <? } ?>
  	  <br>
      <div class="form1" style="float:none">
            <div class="formtitle">Login</div>
          <form action="" method="post">
            <div class="form_login">
              <input name="username" type="text" class="logUsername" id="username" placeholder="Username" required autofocus>
              <input type="password" name="password" placeholder="Password" class="logPassword" required>
              <br><br>
              <a href="forgetPassword.php">Forgot password.</a>
              <br>
              <br>
            </div>
            <div class="buttons">
              <input class="orangebutton" type="submit" value="Login" />
              <input class="greybutton" type="submit" value="Register" />
            </div>
          </form>
      </div><br><br><br>
      </center>
  </div>
  <? include '_footer.php' ?>
</div>
<!-- Start JavaScript --> 
<script src="core/js/jquery-1.9.1.js"></script>
<script src="core/js/jquery-2.0.0.min.js"></script>

<script type="text/javascript" src="js/jquery-u.js"></script><!-- jQuery Ui -->
<script type="text/javascript" src="js/ddsmooth.js"></script><!-- Nav Menu ddsmoothmenu -->
<script type="text/javascript" src="js/jquery03.js"></script><!-- Sliding Text and Icon Menu Style  -->
<script type="text/javascript" src="js/jquery04.js"></script><!-- jQuery Prettyphoto  -->
<script type="text/javascript" src="js/focus.js"></script><!-- text field clear & celander Seting-->

<script type="text/javascript" src="core/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="core/fancyapps/source/jquery.fancybox.pack.js"></script>
</body>
</html>
<? } ?>