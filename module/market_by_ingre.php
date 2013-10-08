<?
if (!isset($_SESSION)) {
  session_start();
}
include '../FoodFunction.php';
$editable=false;
if ( ( isset($_SESSION['UIDS']) && isset($_SESSION['USERNAME']) )
		&& authenIdUser() ) {
		$editable = true;
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
<title>Market</title>
<meta name="description" content>
<meta name="author" content>
<!-- CSS Style -->
<!-- Short Codes Style -->
<link rel="stylesheet" href="../css/shortcode.css" type="text/css" media="all">
<!-- Start Java CSS -->
<link rel="stylesheet" href="../css/javascri.css" type="text/css" media="all">
<!-- Color Schemes CSS -->
<link rel="stylesheet" href="../css/colors-scheme.css" type="text/css" media="all">
<!--[if lt IE 9]>
      <script src="js/html5.js"></script>
<![endif]-->
<link rel="stylesheet" href="../core/css/box.css" type="text/css" media="all">
  <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
          
          <script src="../core/js/jquery-1.9.1.js"></script>
<script src="../core/js/jquery-2.0.0.min.js"></script>
<style>
	body {
		background-color:#E6E6E6;
	}
</style>
</head>
<body id="def" >
<figure class="column c-one-half">
  <h2 class="awesome">Market ที่มี <? if($_GET['iname']!=""){ echo $_GET['iname'];} else { echo getIngeNameById($_GET['iid']); } ?></h2>
  <article class="staff-list">
    <div id="map" style="width: 100%; height: 300px;"></div>
    <?	$rows = array();
		$tmp = array();
		$shop=array();
		$shopDic=array();
		if (is_numeric($_GET['iid'])) { 
		include '../connectDB.php';
    	$strSQL = "SELECT * FROM IHAVE H JOIN ISHOP S ON H.SID=S.SID WHERE IID = ".$_GET['iid'];
		//echo $strSQL;

		$j=1;
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			$tmp = array();
			$tmp2 = array();
			$dis="";
			if (is_numeric($_SESSION['lat']) && is_numeric($_SESSION['lng'])){
					$dis = distance($_SESSION['lat'], $_SESSION['lng'],(double)$row['LATITUDE'],(double)$row['LONGITUDE'], "K")." km.";
				}
			$tmp2['SHOPNAME']=$row['SHOPNAME'];
			$tmp2['LATITUDE']=(double)$row['LATITUDE'];
			$tmp2['ORDER']=$j;
			$tmp2['LONGITUDE']=(double)$row['LONGITUDE'];
			$tmp2['DIS']=$dis;
			$tmp2['SID']=$row['SID'];
			array_push($shopDic,$tmp2);
			
			array_push($tmp,$row['SHOPNAME'],(double)$row['LATITUDE'],(double)$row['LONGITUDE'],$j,$row['LATITUDE'],$dis,$row['SID']);
			array_push($shop,$tmp);
			$j++;
		}
		function cmp($a, $b) {
		if ($a['DIS'] == $b['DIS']) {
			return 0;
		}
		return (floatval($a['DIS']) < floatval($b['DIS'])) ? -1 : 1;
	}
	uasort($shopDic, 'cmp');
		//print_r($shopDic);
		//echo json_encode($shop);
		}
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
		  var marker = new google.maps.Marker({
				  position: new google.maps.LatLng(lat,lng),
				  map: map,
				  icon: '../core/images/blue-dot.png',
				  title: 'Hello World!'
			  });
		  $.get( "module/setLoc.php?lat="+lat+"&lng="+lng, function( data ) {
				/*$( ".result" ).html( data );
				alert( "Load was performed." );*/
			});
		  //locations[1000] = ["Your Location", lat, lng, 1000];
		}
		
    for (i = 0; i < shop.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(shop[i][1], shop[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
			var text = shop[i][0]+' '+shop[i][5];
          infowindow.setContent(text);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
	 
  </script>
  </article>
  <div id="sort">
    <? 
	foreach ($shopDic as $row){
	/*	$strSQL = "SELECT * FROM ISHOP order by SHOPNAME";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
			//array_push($tmp,$row['SHOPNAME'],(double)$row['LATITUDE'],(double)$row['LONGITUDE'],$j);
			//array_push($shop,$tmp);*/
?>
    <article class="box14 boxB">
      <h3><? echo $row['SHOPNAME']."  " ?><span style="font-size:14px" id="theDistance">
        <script src="../core/js/calcDistance.js"></script>
        <script type="text/javascript">
var distance = distanceFrom({
    // NYC
    'lat1': <?=$_SESSION['lat']?>,
    'lng1': <?=$_SESSION['lng']?>,
    // Philly
    'lat2': <?=(double)$row['LATITUDE']?>,
    'lng2': <?=(double)$row['LONGITUDE']?>
});
document.write(""+distance+" kilometers");
</script>
        <?=$rowShop['SHOPNAME']?></span></h3>

    </article>
    <? } 		 ?>
  </div>
</figure>


<? if (!$row) { ?>

 <article class="box14 boxB">
      <h3>No market have the Ingredient.</h3>
    </article>
    
<? }  ?>

</body>
</html>
