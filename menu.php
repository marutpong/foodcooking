<?
if (!isset($_SESSION)) {
  session_start();
}
	include('FoodFunction.php');
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
<title>Menu</title>
<meta name="description" content>
<meta name="author" content>
<!-- CSS Style -->
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<!-- Slider Style -->
<link rel="stylesheet" href="css/slider.css" type="text/css" media="all">
<!-- Calender Style -->
<link rel="stylesheet" href="css/calendar.css" type="text/css" media="all">
<!-- Gallery Style -->
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
</head>
<body id="def">
<div class="wrapper"> 
  <!-- header -->
  <header id="header">
    <div class="main-holder">
      <h1 id="logo"><a href="index.html"></a></h1>
      <nav class="nav">
        <? include('_navbar.php'); ?>
      </nav>
    </div>
   
  </header>
  <div class="main-holder"></div>
  <div class="sloganwrapper">
    <div class="main-holder ">
      <ul class="breadcrumb">
        <li><a href="#">HOME</a></li>
        <li>ALL FOOD</li>
      </ul>
    </div>
  </div>
  <!-- Content -->
  <section class="main-content"> <span class="top-bg"></span>
  <ul class="category-list" id="portfolio-item-filter">
  	<li><a href="#" data-value="All">All</a></li>
    <?
    $strSQL = " Select TYPEID,TYPENAME from IFOODTYPE ORDER BY TYPENAME";
	//echo $strSQL;
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$searchOB = array();
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		echo '<li><a href="#" data-value="'.$row['TYPEID'].'">'.$row['TYPENAME'].'</a></li>';
	}
	?>
    <li><a href="#" data-value="Chinese">Chinese</a></li>
  </ul>
  <div class="holder-container last">
  	<section class="grid-holder">
      	  <section class="grid lightbox gallery" id="portfolio-item-holder">
	<?
    $strSQL = " Select FID,FOODNAME,PICTURE,VIEWS,UIDS,TYPEID,TYPEID,TYPENAME,NAME from IFOODS NATURAL JOIN IUSERS NATURAL JOIN IFOODTYPE";
	//echo $strSQL;
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$searchOB = array();
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		?>
      <figure class="column three-col <?=$row['TYPEID']?> portfolio-item item alpha">
        <a href="foodDetail.php?foodid=<?=$row['FID']?>"><h2 style="background:#4e4e4e;color:#CCC;border-radius:5px;"><?=$row['FOODNAME']?></h2></a>
        <ul class="b-top-links">
              <li class="author-name">by <?=$row['NAME']?></li>
              <li class="pic-icon"><?=$row['TYPENAME']?></li>
              <li class="catagory"><?=$row['VIEWS']?> views</li>
        </ul>
              <? if (file_exists('files/_'.$row['PICTURE'])) {
		  
	  ?>
      <img src="files/_<? echo $row['PICTURE']; ?>"><?
	  } else {?>
      <img src="http://10.10.188.254/group10/files/_<? echo $row['PICTURE']; ?>">
      <? } ?>
      
        <a href="images/image05.jpg" rel="prettyPhoto[gallery1]" class="caption"><span class="hover-effect big zoom"></span></a>
        <article class="menu-det">
          <p>Nullam mi turpis, ultricies eu mattis vel, tincidunt vitae velit. Nullam quis ante sapien. Praesent sollicitudin volutpat fringilla. </p>
        </article>
      </figure>
      <? } ?>
      <figure class="column three-col Chinese portfolio-item item alpha">
        <h2>Chinese Food</h2>
        <a href="images/image31.jpg" rel="prettyPhoto[gallery1]" class="caption"><img src="images/image31.jpg" class="offer-img" alt=""><span class="hover-effect big zoom"></span></a>
        <article class="menu-det">
          <p>Nullam mi turpis, ultricies eu mattis vel, tincidunt vitae velit. Nullam quis ante sapien. Praesent sollicitudin volutpat fringilla.</p>
        </article>
      </figure>
      
   	    </section>
      </section>
  </div>
    <? include '_footer.php' ?>
</div>
<!-- Start JavaScript --> 
<script src="core/js/jquery-2.0.0.min.js"></script>
<script type="text/javascript" src="js/sourtin-jquery.js"></script><!-- sourtin Slider -->
<script type="text/javascript" src="js/jquery-u.js"></script><!-- jQuery Ui -->
<script type="text/javascript" src="js/ddsmooth.js"></script><!-- Nav Menu ddsmoothmenu -->
<script type="text/javascript" src="js/jquery03.js"></script><!-- Sliding Text and Icon Menu Style  -->
<script type="text/javascript" src="js/colortip.js"></script><!-- Colortip Tooltip Plugin  -->
<script type="text/javascript" src="js/tytabs00.js"></script><!-- jQuery Plugin tytabs  -->
<script type="text/javascript" src="js/jquery04.js"></script><!-- jQuery Prettyphoto  -->
<script type="text/javascript" src="js/custom00.js"></script><!-- Custom Js file for javascript in html -->
<script type="text/javascript" src="js/focus.js"></script><!-- text field clear & celander Seting-->
<script type="text/javascript" src="js/supersized.3.2.7.min.js"></script><!-- Image Gallery -->
</body>
</html>
