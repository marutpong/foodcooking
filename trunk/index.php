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
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="stylesheet" href="css/calendar.css" media="all">
<!-- Basic Page Needs -->
<meta charset="utf-8">
<title>Home</title>
<meta name="description" content>
<meta name="author" content>
<!-- CSS Style -->
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<!-- Slider Style -->
<link rel="stylesheet" href="css/slider.css" type="text/css" media="all">
<!-- Short Codes Style -->
<link rel="stylesheet" href="css/shortcode.css" type="text/css" media="all">
<!-- Start Java CSS -->
<link rel="stylesheet" href="css/javascri.css" type="text/css" media="all">
<!-- Video Gallery CSS -->
<!-- Color Schemes CSS -->
<link rel="stylesheet" href="css/colors-scheme.css" type="text/css" media="all">
<!--[if lt IE 9]>
      <script src="js/html5.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="core/css/styleShowcase.css">
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
  <div id="homeContent">
    <div id="featured">
      <div class="gallery">
        <div class="site"><img src="images/banner01.jpg" alt=""></div>
        <div class="site"> <img src="images/banner02.jpg" alt=""> </div>
        <div class="site"> <img src="images/banner03.jpg" alt=""> </div>
        <div class="site"> <img src="images/banner04.jpg" alt=""> </div>
      </div>
      <div class="pagination stopClickPropagation"> <a href="#" class="left"><img src="images/arrow_le.png" alt=""></a>
        <div class="pages" ></div>
        <a href="#" class="right"><img src="images/arrow_ri.png" alt=""></a> </div>
    </div>
  </div>
  <div class="main-holder">
    <div class="bannercon">
      <h2><span class="span-my">คุณเคยเจอปัญหามั้ย?<br>
        เวลามีวัตถุดิบอยู่<br>
        แล้วไม่รู้จะปรุงเมนูไหน</span></h2>
      <p><span class="span-my"> เรามีวิธีช่วยคุณในการหารายการอาหาร <br>
        ที่ใกล้เคียงกับวัตถุดิบที่คุณมี</span></p>
      <a href="search.php" class="bannerbtn">ค้นหาแบบพิเศษ</a> </div>
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
          
          <?
		  $foodList = array();
		  $rtitle = array("Recent Food","Random Food","Most Favorite Food","Most Viewed Food");
		  $rQuery = array(
		  	"SELECT *
				FROM( SELECT *FROM IFOODS ORDER BY FID DESC )
				WHERE rownum <= 8",
			"SELECT *
	FROM( SELECT *FROM IFOODS ORDER BY dbms_random.value )
	WHERE rownum <= 8",
			"SELECT * FROM (SELECT * FROM( select FID, count(FID) NUM from IFAVORITE Group by FID ORDER BY NUM DESC )  WHERE rownum <= 8) NATURAL JOIN IFOODS ORDER BY NUM DESC",
			"SELECT * FROM( SELECT * FROM IFOODS ORDER BY VIEWS DESC ) WHERE rownum <= 8");
			$foodList['title']=$rtitle;
			$foodList['query']=$rQuery;
			//print_r($foodList);
			for ($j=0 ; $j<count($foodList['title']) ; $j++){
		  ?>
          <article class="blog-main"><h2> <strong class="title"><?=$foodList['title'][$j]?></strong></h2>
            <div id="showcase<?=$j?>" class="showcase">
              <div class="showcase-slide">
                <div class="showcase-content">
                  <?
    $strSQL = $foodList['query'][$j];
	//echo $strSQL;
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$searchOB = array();
	$i=0;
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		$i++;
		$src=picture_url("_".$row['PICTURE']);

		?>
                  <figure class="column three-col <?=$row['TYPEID']?> portfolio-item item alpha" >
                    <div style="background-image:url('<?=$src?>');" class="myfoodpic">
                      <div class="myfoodpic_title"> <a href="foodDetail.php?foodid=<?=$row['FID']?>" style="color:#FFF;">
                        <?=$row['FOODNAME']?>
                      </a></div>
                    </div>
                  </figure>
                  <? 
	  if ($i%2==0 && $i!=8){
		 echo '</div></div> <div class="showcase-slide">
          <div class="showcase-content">';
	  }
	  } ?>
                </div>
              </div>
            </div>
          </article>
          <? } ?>
          </figure>
        </section>
      </section>
    </div>
    <div class="holder-container last">
      <section class="grid-holder"></section>
    </div>
    <? include '_footer.php' ?>
</div>
<!-- Start JavaScript --> 
<script src="core/js/jquery-1.9.1.js"></script> 
<script src="core/js/jquery-2.0.0.min.js"></script> 
<script type="text/javascript" src="js/slider.js"></script><!-- Main Slider --> 
<script type="text/javascript" src="js/sourtin-jquery.js"></script><!-- sourtin Slider --> 
<script type="text/javascript" src="js/jquery-u.js"></script><!-- jQuery Ui --> 
<script type="text/javascript" src="js/ddsmooth.js"></script><!-- Nav Menu ddsmoothmenu --> 
<script type="text/javascript" src="js/jquery03.js"></script><!-- Sliding Text and Icon Menu Style  --> 
<script type="text/javascript" src="js/colortip.js"></script><!-- Colortip Tooltip Plugin  --> 
<script type="text/javascript" src="js/tytabs00.js"></script><!-- jQuery Plugin tytabs  --> 
<script type="text/javascript" src="js/jquery04.js"></script><!-- jQuery Prettyphoto  --> 
<script type="text/javascript" src="js/jquery06.js"></script><!-- UItoTop plugin  --> 
<script type="text/javascript" src="js/focus.js"></script><!-- text field clear & celander Seting--> 

<script type="text/javascript" src="core/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js"></script> 
<script type="text/javascript" src="core/fancyapps/source/jquery.fancybox.pack.js"></script> 
<script src="core/js/jquery.aw-showcase.js"></script> 
<script type="text/javascript">
 
$(document).ready(function()
{
	<? for ($num=0;$num<4;$num++) { ?>
	$("#showcase<?=$num?>").awShowcase(
	{
		content_width:			660,
		content_height:			240,
		fit_to_parent:			false,
		auto:					true,
		interval:				2500,
		continuous:				true,
		loading:				true,
		tooltip_width:			200,
		tooltip_icon_width:		32,
		tooltip_icon_height:	32,
		tooltip_offsetx:		18,
		tooltip_offsety:		0,
		arrows:				false,
		buttons:				true,
		btn_numbers:			false,
		keybord_keys:			true,
		mousetrace:				false, /* Trace x and y coordinates for the mouse */
		pauseonover:			true,
		stoponclick:			false,
		transition:				'hslide', /* hslide/vslide/fade */
		transition_delay:		0,
		transition_speed:		500,
		show_caption:			'onload', /* onload/onhover/show */
		thumbnails:				false,
		thumbnails_position:	'outside-last', /* outside-last/outside-first/inside-last/inside-first */
		thumbnails_direction:	'vertical', /* vertical/horizontal */
		thumbnails_slidex:		1, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
		dynamic_height:			true, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
		speed_change:			true, /* Set to true to prevent users from swithing more then one slide at once. */
		viewline:				false, /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
		custom_function:		null /* Define a custom function that runs on content change */
	});
	<? } ?>
});

</script>
</body>
</html>
