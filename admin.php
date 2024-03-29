<?
if (!isset($_SESSION)) {
  session_start();
}
include 'FoodFunction.php';
if ( !(authenAdmin()) ) {
	header ("Location: login.php?relog=1&msg=Permission denied. Please login with admin user.&ref=".$_SERVER['PHP_SELF']);
}
?><!DOCTYPE html>
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
<title>Register</title>
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
    <link rel="stylesheet" type="text/css" href="core/css/jquery-ui-1.10.3.css">
    <script src="core/js/jquery-1.9.1.js"></script>
    <script src="core/js/jquery-ui-1.10.3.js"></script>
    <script>
    $(function() {
    /*$( "#tabs" ).tabs({
        collapsible: true
    }
    );*/
	$('#tabs').load('admin_src.php');
    });
    </script>
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
        <li>Administrator</li>
      </ul>
    </div>
  </div>
  <!-- Content -->
  <section class="main-content"> <span class="top-bg"></span>
<div class="holder-container">
  <section class="grid-holder">
        <h2>Administrator</h2>
        <section class="grid w-padd">
          <div id="tabs" style="height:630px;margin-left:25px;" align="center">
            <? /*
       <ul>
        <? $a = array("Users", "Food", "Shop", "Ingredient","Tools","Use","contain","have","Favorite","Comment","FoodType"); 
        
        for ($i =0 ;$i < count($a);$i++){
        ?>
        <li><a href="#tabs-<? echo ($i+1) ?>"><? echo $a[$i]?></a></li>
        <? } ?>
        </ul>
    
        <? for ($i =0 ;$i < count($a);$i++){ ?>
        <div id="tabs-<? echo ($i+1) ?>" >
        <iframe src="admin/<? echo $a[$i]?>" width="100%" height="550" frameborder="0" marginheight="0" marginwidth="0" hspace="0" vspace="0"></iframe>
        </div>
        <? } ?>
		
		*/ ?>
          </div>
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
