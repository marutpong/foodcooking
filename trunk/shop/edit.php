<!DOCTYPE HTML>
<html>
<head>
<title>Add Ingredient</title>
<meta charset="UTF-8" />
<link href="css/mystyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/jquery.numeric.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#name').focus();
	});
	var checkNum = function(evt) {
		$(evt).numeric({ negative: false }, function() { 
			alert("No negative values"); this.value = ""; this.focus(); 
		});
		$('#button_sub').click(function () {
			$('#googleMap').show();
		});
	}
</script>
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
<body>
<?
	if (isset($_POST['sid']) && isset($_POST['name']) && isset($_POST['latitude']) && isset($_POST['longitude']) && $_POST['confirm']==2) {
	$count = 0;
	$num = count($_POST['sid']);
	include 'connectDB.php'; 
	for ($i=0;$i<$num;$i++){
		if (is_numeric($_POST['latitude'][$i]) && is_numeric($_POST['longitude'][$i])){
			$strSQL = "UPDATE $table SET ";
			$strSQL .="NAME = '".$_POST["name"][$i]."'";
			$strSQL .=", LATITUDE = '".$_POST["latitude"][$i]."' ";
			$strSQL .=", LONGITUDE = '".$_POST["longitude"][$i]."' ";
			$strSQL .=" WHERE SID = '".$_POST["sid"][$i]."' ";
			$objParse = oci_parse($objConnect, $strSQL);
			$objExecute = oci_execute($objParse);
			if($objExecute){
				$count++;
			}
		}
	}
	echo '<br><center><div class="textC1">';
	if($count){
		echo 'Edited '.$count.' items.';
	} else {
		echo 'Edit Unsuccessful, some input are incorect.';
	}
	echo '</div></center>';
} else {
	
if (isset($_GET['ids']) && $_GET['confirm']==1) {
?>
<form action="" method="post">
<div>
	  <table>
	    <tr class="labelF">
	      <td>ชื่อร้านค้า :</td>
	      <td>ละติจูด :</td>
	      <td>ลองจิจูด :</td>
        </tr>
<?
	$ids = $_GET['ids'];
	$nameArray = split(",|and",$ids);
	include 'connectDB.php'; 
	foreach($nameArray as $id){
	if ($id!=""){
		$strSQL = "SELECT * FROM $table Where SID=$id";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$rows = array();
		while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
?>
	    <tr>
			<td>
          	<input name="sid[]" type="hidden" id="sid[]" value="<? echo $id?>">
          	<input name="name[]" type="text"  required class="input" id="name[]" tabindex="1" value="<? echo $row['NAME']?>">
			</td>
	      	<td>
            <input name="latitude[]" type="number" required class="input" id="latitude[]" tabindex="2" value="<? echo $row['LATITUDE']?> " size="10" onfocus="javascript:checkNum(this)">
            </td>
	      	<td>
            <input name="longitude[]" type="number" required class="input" id="longitude[]" tabindex="2" value="<? echo $row['LONGITUDE']?>" size="10" onfocus="javascript:checkNum(this)">
            </td>
			<td>
			<input type="button" id="button_sub" class="button_sub" value="เลือกพิกัด" tabindex="4" >
			</td>
        </tr>
<?
		}
	}
}
?>
	
    </table>
	<div id="googleMap" style="width:300px;height:200px;display:none;"></div>
</div>
	<footer>
    	<input name="confirm" type="hidden" id="confirm" value="2">
		<input type="submit" class="button_sub" value="แก้ไข" tabindex="4">
	</footer>
</form>
<? }
} ?>
</body>
</html>