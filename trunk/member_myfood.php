<?
if (!isset($_SESSION)) {
  session_start();
}
include 'FoodFunction.php';
if ( !authenIdUser() ) {
	header ("Location: login.php?ref=".$_SERVER['PHP_SELF']);
}
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
<title>Favorite Fods</title>
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
        <li><a href="member.php">MEMBER</a></li>
        <li>MY FOODS</li>
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
            <h2>My Foods</h2>
            <?
			$count=0;
    $strSQL = " Select * FROM IFOODS F JOIN IUSERS U  ON (F.UIDS=U.UIDS) JOIN IFOODTYPE FT ON (F.TYPEID=FT.TYPEID) WHERE F.UIDS=".$_SESSION['UIDS'];
	//echo $strSQL;
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		$src=picture_url("_".$row['PICTURE']);
		$count++;
	?>
          <figure class="column three-col <?=$row['TYPEID']?> portfolio-item item alpha" ><a href="foodDetail.php?foodid=<?=$row['FID']?>">
            <div style="background-image:url('<?=$src?>');" class="myfoodpic">
            	<div class="myfoodpic_title"><?=$row['FOODNAME']?></div>
            </div>
            </a>
            <ul class="b-top-links">
              <li class="author-name">by
                <?=$row['NAME']?>
              </li>
              <li class="pic-icon">
                <?=$row['TYPENAME']?>
              </li>
              <li class="catagory">
                <?=$row['VIEWS']?>
                views</li>
            </ul>
          </figure>
          <? } ?>
          <? if (!$count) {
			  echo "<br><br><br><br>No have your food yet.";
		  }?>
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
