<!DOCTYPE html>
<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Google Maps Multiple Markers</title> 
  <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
</head> 
<body>
  <div id="map" style="width: 1000px; height: 600px;"></div>
	<?
		include '../../connectDB.php';
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

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(18.6943830036,98.8549804688),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker;

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
</body>
</html>