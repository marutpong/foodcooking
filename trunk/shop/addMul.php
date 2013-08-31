<!DOCTYPE HTML>
<html>
<head>
<title>Add Ingredient</title>
<meta charset="UTF-8" />
<link href="../core/css/flexigrid2.css" rel="stylesheet" type="text/css">
<link href="../core/css/mystyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../core/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../core/js/jquery.numeric.js"></script>
<script type="text/javascript">
$(document).ready(function() {
		$('#name[0]').focus();
		$('#addmore').click(function () {
			var htmlStr = ' <tr>\
	      <td><input name="name[]" type="text"  required class="input number" id="name[]" tabindex="2" ></td>\
	      <td><input name="latitude[]" type="number" required class="input" id="latitude[]" tabindex="2" size="10" onfocus="javascript:checkNum(this)"></td>\
		  <td><input name="longitude[]" type="number" required class="input" id="longitude[]" tabindex="2" size="10" onfocus="javascript:checkNum(this)"></td>\
        </tr>';
			$('#dynamic_tb').append(htmlStr);
		});
		$('#button_sub').click(function () {
			$('#googleMap').show();
		});

	});
var checkNum = function(evt) {
		$(evt).numeric({ negative: false }, function() { 
			alert("No negative values"); this.value = ""; this.focus(); 
		});
}
</script>
<script
src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false">
</script>
<script>
var map;
var myCenter=new google.maps.LatLng(18.769814809450903,98.96072387695312);
var markers;
var close =0;
function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:10,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

  map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

  google.maps.event.addListener(map, 'click', function(event) {
	placeMarker(event.latLng);
  });
}

function placeMarker(location) {
	if(close==0){
  //marker.setMap(null);
  marker = new google.maps.Marker({
    position: location,
    map: map,
  });
  var infowindow = new google.maps.InfoWindow({
    content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
  });
  infowindow.open(map,marker);
  $('#latitude').val(location.lat());
  $('#longitude').val(location.lng());
  close =1;
  }
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>
</head>
<body onload="initialize();">
<?
if ( isset($_POST['name']) && isset($_POST['latitude']) && isset($_POST['longitude']) && $_POST['confirm']==1){
	$name = $_POST['name'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$count = 0;
	$num = count($_POST['name']);
	include 'connectDB.php'; 
	for ($i=0;$i<$num;$i++){
		if (is_numeric($_POST['latitude'][$i]) && is_numeric($_POST['longitude'][$i])){	
			$sql = "INSERT INTO $table (SHOPNAME, LATITUDE, LONGITUDE) VALUES ('$name[$i]','$latitude[$i]','$longitude[$i]')";
			$strSQL = $sql;
			//echo $sql;
			$objParse = oci_parse($objConnect , $strSQL);
			$objExecute = oci_execute($objParse);
			if($objExecute){
				$count++;
			}
		}
	}
	echo '<br><br><br><center><div class="textC1">';
	if($objExecute){
		echo 'Add Succesful '.$count.' items<P>';
		echo '<a href="addMul.php"  class="button_addmore">Add more Shop</a>';
	} else {
		echo 'Unsuccessful, some input are incorect.';
	}
	echo '</div></center>';
} else {
?>
<div style="width:400">
<form action="" method="post">
<div>
    <table id="dynamic_tb">
	    <tr class="labelF">
	     
	      <td>ชื่อร้านค้า:</td>
	      <td>ละติจูด :</td>
		  <td>ลองจิจูด :</td>
        </tr>
	    <tr>
	  
	      <td><input name="name[]" type="text"  required class="input number" id="name[]" tabindex="2"  > </td>
	      <td><input name="latitude[]" type="text" required class="input" id="latitude" tabindex="2" onfocus="javascript:checkNum(this)" size="10" readonly></td>
		  <td><input name="longitude[]" type="text" required class="input" id="longitude" tabindex="2" onfocus="javascript:checkNum(this)" size="10" readonly></td>
		  <td>&nbsp;</td>
        </tr>
    </table>
	<div id="googleMap" style="width:400px;height:300px;"></div>
</div>
	<footer>
	    <input name="confirm" type="hidden" value="1">
	    <br>
<center><input type="submit" class="button_sub" value="เพิ่ม" tabindex="4"></center>
</footer>
</form>
</div>
<? } ?>

</body>
</html>
