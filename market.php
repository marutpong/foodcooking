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
  <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
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
        <li>MARKET</li>
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
            <h2>Market</h2>
            <article class="staff-list">
              <div id="map" style="width: 669px; height: 400px;"></div>
	<?
		include 'connectDB.php';
    	$strSQL = "SELECT * FROM ISHOP order by sid";
		//echo $strSQL;
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rows = array();
		$tmp = array();
		$shop=array();
		$j=1;
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			$tmp = array();
			array_push($tmp,$row['SHOPNAME'],(double)$row['LATITUDE'],(double)$row['LONGITUDE'],$j);
			array_push($shop,$tmp);
			$j++;
		}
		//echo json_encode($shop);
    ?>
  <script type="text/javascript">

  var i;
  var shop=<?php echo json_encode($shop); ?>;
  //alert();
   /* var locations = [
      ["Bondi Beach", -33.890542, 151.274856, 1],
      ["Coogee Beach", -33.923036, 151.259052, 2],
      ["Cronulla Beach", -34.028249, 151.157507, 3],
      ["Manly Beach", -33.80010128657071, 151.28747820854187, 4],
      ["Maroubra Beach", -33.950198, 151.259302, 5]
    ];*/

     getLocation();
	 
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 14,
      center: new google.maps.LatLng(18.795633199999997,98.9529055),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker;
 function getLocation() {
		  if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
		  } else {
			alert("Geolocation is not supported by this browser.");
		  }
		}
		function showPosition(position) {
		  var lat = position.coords.latitude;
		  var lng = position.coords.longitude;
		  map.setCenter(new google.maps.LatLng(lat, lng));
		  //locations[1000] = ["Your Location", lat, lng, 1000];
		}
		
    for (i = 0; i < shop.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(shop[i][1], shop[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(shop[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
	 
  </script>
            </article>
<?            
		$strSQL = "SELECT * FROM ISHOP order by SHOPNAME";
		//echo $strSQL;
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rows = array();
		$tmp = array();
		$shop=array();
		$j=1;
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			//array_push($tmp,$row['SHOPNAME'],(double)$row['LATITUDE'],(double)$row['LONGITUDE'],$j);
			//array_push($shop,$tmp);
?>
            <article class="staff-list">
              <aside class="det-bar">
                <h3><? $row['SHOPNAME'] ?></h3>
                <em class="title4">Owner</em>
                <p>Pellentesque fermentum lorem at odio gravida consectetur. Fusce id nulla quam, vitae vehicula tellus. Sed et lectus eget ipsum vulputate mollis eu et dolor. Nunc hendrerit sapien eu ante fringilla consectetur. Sed ut diam neque, vel pharetra dui.</p>
                <p>Aenean tempor nunc sit amet dolor porta cursus. Morbi sit amet dolor orci. Donec consequat egestas condimentum. Sed eu libero non velit elementum dapibus vel at urna. Etiam in quam congue lorem varius interdum.</p>
              </aside>
            </article>
            
<? }   ?>
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
