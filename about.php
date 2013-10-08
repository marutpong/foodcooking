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
<!-- Basic Page Needs -->
<meta charset="utf-8">
<title>About Us</title>
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
        <li>ABOUT US</li>
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
            <h2>Our Staff</h2>
            <article class="staff-list">
              <div class="img-box"><img src="http://10.10.188.254/group10/files/6b58900b8e0e79a8faa79b301f214d84.jpg" alt=""></div>
              <aside class="det-bar">
                <h3>Chalermpong Somdulyawat</h3>
                <em class="title4">Owner</em>
                <p>Student ID : 540610596</p>
                <p><a href="http://www.facebook.com/chalermpong.somdulyawat" target="_blank"><img src="images/facebook.png" alt="Facebook" width="18" height="18"> www.facebook.com/chalermpong.somdulyawat</a></p>
              </aside>
            </article>
            <article class="staff-list">
              <div class="img-box"><img src="http://10.10.188.254/group10/files/1097c37d897ad5f4a1e94117d7c20708.jpg" alt=""></div>
              <aside class="det-bar">
                <h3>Marutpong Chailangka</h3>
                <em class="title4">Owner</em>
                <p>Student ID : 540610639</p>
                <p><a href="http://www.facebook.com/MrJamesMrp" target="_blank"><img src="images/facebook.png" alt="Facebook" width="18" height="18">www.facebook.com/MrJamesMrp</a></p>
              </aside>
            </article>
            <article class="staff-list">
              <div class="img-box"><img src="http://10.10.188.254/group10/files/9d94e5f04cbbed775fe3b04b357f125d.jpg" alt=""></div>
              <aside class="det-bar">
                <h3>Panupong Jantapoon</h3>
                <em class="title4">Owner</em>
                <p>Student ID : 540610633</p>
                <p><a href="http://www.facebook.com/PanupongJantapoon" target="_blank"><img src="images/facebook.png" alt="Facebook" width="18" height="18">www.facebook.com/PanupongJantapoon</a></p>
              </aside>
            </article>
            <article class="staff-list">
              <div class="img-box"><img src="http://10.10.188.254/group10/files/357170fa12ec2fe62e2e75523512ca18.jpg" alt=""></div>
              <aside class="det-bar">
                <h3>Phasit Panyaphruek</h3>
                <em class="title4">Owner</em>
                <p>Student ID : 540610635</p>
                <p><a href="http://www.facebook.com/bungyugi" target="_blank"><img src="images/facebook.png" alt="Facebook" width="18" height="18">www.facebook.com/bungyugi</a></p>
              </aside>
            </article>
            <article class="staff-list">
              <div class="img-box"><img src="http://10.10.188.254/group10/files/01b465544c0f7694329182148eae1d6d.jpg" alt=""></div>
              <aside class="det-bar">
                <h3>Tanaphon Aunhinkong</h3>
                <em class="title4">Owner</em>
                <p>Student ID : 540610611</p>
                <p><a href="http://www.facebook.com/tanaphonble" target="_blank"><img src="images/facebook.png" alt="Facebook" width="18" height="18">www.facebook.com/tanaphonble</a></p>
              </aside>
            </article>
            <p>&nbsp;</p>
          </figure>
        </section>
      </section>
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
<script type="text/javascript" src="js/jquery06.js"></script><!-- UItoTop plugin  --> 
<script type="text/javascript" src="js/focus.js"></script><!-- text field clear & celander Seting-->

<script type="text/javascript" src="core/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="core/fancyapps/source/jquery.fancybox.pack.js"></script>
</body>
</html>
