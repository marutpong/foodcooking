<?
if (!isset($_SESSION)) {
  session_start();
}
include('../../FoodFunction.php');
$rows = optionIngredient("");
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Add Ingredient</title>
	<meta charset="UTF-8" />
	<script type="text/javascript" src="../../core/js/jquery-1.6.4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../../core/css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="../../core/css/mystyle.css">
    <script src="../../core/js/jquery-2.0.0.min.js"></script>
    <script src="../../core/js/jquery-ui-1.10.3.js"></script>
    <script src="../../core/js/combobox.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#name').focus();
		$( ".combobox" ).combobox();
		$( "#foodtype" ).combobox();
		$('#addmore').click(function () {
			var htmlStr = '<tr>\
              <td width="200"><select class="labelF combobox" id="combobox" name="ingredient[]" required >\
                <option value=""></option><? echo $rows;?></select>\
                <input name="newingredient[]" type="hidden" id="newingredient[]"></td>\
				<td>&nbsp;</td>\
              <td><input name="unit[]" type="text" readonly  required class="input unit" id="unit[]" tabindex="1" size="10" placeholder="หน่วย" style="width:100px;"></td>\
              <td><div class="remove" onClick="removeOb(this)"><img src="../../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>\
            </tr>';
			$('#addIngre').append(htmlStr);
			$( ".combobox" ).combobox();
		});

	});
var checkNum = function(evt) { 
		$(evt).numeric({ negative: false }, function() { 
			alert("No negative values"); this.value = ""; this.focus();
		});
}
var removeOb = function(e) {
	var ob = $(e).parent().parent();
	ob.hide('slow', function(){ ob.remove();
	 } );
	//$(e).parent().parent().remove();
};
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
}
var mapProp = {
  center:myCenter,
  zoom:12,
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
		if (is_numeric($latitude) && is_numeric($longitude)){	
			if ($sid = insertShop($name,$latitude,$longitude)){
			$count++;
			/////// Add INGREDIENT  ////////
			if ( isset($_POST['ingredient']) && isset($_POST['newingredient']) && (is_numeric($sid)) ){
				$ingredient = $_POST['ingredient'];
				$newIG = $_POST['newingredient'];
				$num = count($_POST['ingredient']);
				for ($i=0;$i<$num;$i++){
						$theIngreID = "";
						if ( empty($ingredient[$i]) && !empty($newIG[$i]) ) {			
							$theIngreID = insertIngredient($newIG[$i],$_POST['unit'][$i]);
						} else if (!empty($ingredient[$i])){
							$theIngreID = $ingredient[$i];
						}
						insertHave($sid,$theIngreID);
				}
			}
			}
		}

	echo '<br><br><br><center><div class="textC1">';
	if($count){
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
	  
	      <td><input name="name" type="text"  required class="input number" id="name" tabindex="2"  > </td>
	      <td><input name="latitude" type="text" required class="input" id="latitude" tabindex="2" onfocus="javascript:checkNum(this)" size="10" readonly></td>
		  <td><input name="longitude" type="text" required class="input" id="longitude" tabindex="2" onfocus="javascript:checkNum(this)" size="10" readonly></td>
		  <td>&nbsp;</td>
        </tr>
	    <tr>
	      <td class="labelF">เลือกพิกัดจากแผนที่</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
        </tr>
    </table>
	<div id="googleMap" style="width: 550px; height: 300px;"></div>
    <table width="500">
      <tr>
        <td width="75" valign="top" class="labelF">ส่วนผสม :</td>
        <td width="425"><div>
          <table width="420" border="0" id="addIngre">
            <tr>
              <td width="200"><select class="labelF combobox" id="combobox" name="ingredient[]" required >
                <option value=""></option>
                <? echo $rows;?>
                </select>
                <input name="newingredient[]" type="hidden" id="newingredient[]"></td>
              <td>&nbsp;</td>
              <td><input name="unit[]" type="text"  class="input unit" id="unit[]" placeholder="หน่วย" tabindex="1" size="10" readonly style="width:100px;" required></td>
              <td><div class="remove" onClick="removeOb(this)"><img src="../../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table>
    <div class="button_addmore" id="addmore" tabindex="4" ><img src="../../core/css/images/add.png" width="16" height="16">เพิ่มส่วนผสม</div>
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
