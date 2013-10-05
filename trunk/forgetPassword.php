<?
if (!isset($_SESSION)) {
  session_start();
}
include 'FoodFunction.php';
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<link rel="stylesheet" href="css/calendar.css" media="all">
<!-- Basic Page Needs -->
<meta charset="utf-8">
<title>Forget Password</title>
<meta name="description" content>
<meta name="author" content>
<!-- CSS Style -->
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<!-- Slider Style -->
<link rel="stylesheet" href="skin/supersized.css" type="text/css" media="screen" />
<!-- Short Codes Style -->
<link rel="stylesheet" href="css/shortcode.css" type="text/css" media="all">
<!-- Start Java CSS -->
<link rel="stylesheet" href="css/javascri.css" type="text/css" media="all">
<!-- Video Gallery CSS -->
<link rel="stylesheet" href="css/galleria.classic.css" type="text/css" media="all">
<!-- Color Schemes CSS -->
<link rel="stylesheet" href="css/colors-scheme.css" type="text/css" media="all">
<!--[if lt IE 9]>
      <script src="js/html5.js"></script>
<![endif]-->
<script src="../../foodcooking/core/js/jquery-1.9.1.js"></script>
<script src="../../foodcooking/core/js/jquery-2.0.0.min.js"></script>
  <link href="core/css/mystyle.css" rel="stylesheet" type="text/css">
  
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
        <li>Forget Password</li>
      </ul>
    </div>
  </div>
  <!-- Content -->
  <section class="main-content"> <span class="top-bg"></span>
    <div class="holder-container">
      <section class="grid-holder">
        <section class="grid w-padd">
          <figure class="column forth-col">
            <? include('_side.php'); ?>
          </figure>
          <figure class="column c-one-half">
            <h2>Forget password</h2>
            <div style="width:400" align="center" ><p><p><p>
            
            <?
if (isset($_POST['email'])){
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
	
	$total = 0;
	$strSQL = "SELECT * FROM IUSERS WHERE EMAIL='$email'";
	$objParse = oci_parse($objConnect, $strSQL);
	oci_execute($objParse, OCI_DEFAULT);
	$total = oci_fetch_all($objParse, $Result);
	if($total==1){
		$strSQL = "update iusers set password = '$newpass' where EMAIL = '$email'";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse);
		sendmail($email,$msgheader,$msgcontent);
?>

            <div class="alert success hideit">
              <p>New password has been sent to your E-mail.</p>
              <span class="close"></span></div>
<?		
	} else {
		$msgError = "Invalid E-mail address.";
?>
<?
	}

}
	if (isset($msgError)){
?>
            <div class="alert error hideit" >
              <p><?=$msgError?></p>
              <span class="close"></span></div>
              <? }?>
<form action="" method="post" id="addUser">
                  <p>&nbsp;</p>
                  <table width="400" align="center" id="dynamic_tb">
                    <tr>
                      <td width="100" height="36" align="right" valign="middle" class="labelF">E-mail :</td>
                      <td width="300" height="36" valign="middle" class="labelF"><input name="email" type="email" class="input" id="email" placeholder="E-mail"></td>
                    </tr>
                </table>
                  <p>
                    <center>
                      <input type="submit" class="button_sub" value="Submit" tabindex="4">
                    </center>
                  </p>
              </form>
            </div>
            <p>&nbsp;</p>
          </figure>
        </section>
      </section>
    </div>
    <? include '_footer.php' ?>
</div>
<!-- Start JavaScript --> 
<script type="text/javascript" src="js/sourtin-jquery.js"></script><!-- sourtin Slider -->
<script type="text/javascript" src="js/jquery-u.js"></script><!-- jQuery Ui -->
<script type="text/javascript" src="js/ddsmooth.js"></script><!-- Nav Menu ddsmoothmenu -->
<script type="text/javascript" src="js/jquery03.js"></script><!-- Sliding Text and Icon Menu Style  -->
<script type="text/javascript" src="js/colortip.js"></script><!-- Colortip Tooltip Plugin  -->
<script type="text/javascript" src="js/tytabs00.js"></script><!-- jQuery Plugin tytabs  -->
<script type="text/javascript" src="js/jquery04.js"></script><!-- jQuery Prettyphoto  -->
<script type="text/javascript" src="js/jquery06.js"></script><!-- UItoTop plugin  -->
<script type="text/javascript" src="js/custom00.js"></script><!-- Custom Js file for javascript in html -->
<script type="text/javascript" src="js/focus.js"></script><!-- text field clear & celander Seting-->

</body>
</html>
