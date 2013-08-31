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
			$dId = $id;
			$dName = $row['SHOPNAME'];
			$dLat = $row['LATITUDE'];
			$dLong = $row['LONGITUDE'];
		}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Add Ingredient</title>
<meta charset="UTF-8" />
<link href="../core/css/mystyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../core/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../core/js/jquery.numeric.js"></script>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">

function initialize ()
   {
   Gloucester = new google.maps.LatLng (<? echo $dLat?>, <? echo $dLong?>);

   myOptions = 
      {
      zoom: 14,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      center: Gloucester,
      streetViewControl: false
      }
   
   map = new google.maps.Map (document.getElementById ("map_canvas"), myOptions);

   marker = new google.maps.Marker ({position: Gloucester, title: ""});
   marker.setMap (map);
   marker.setDraggable (true);

   google.maps.event.addListener(marker, "dragend", function(event) {

   var point = marker.getPosition();
   map.panTo(point);
		$('#lat').val(point.lat());
  		$('#long').val(point.lng());
    });
   }

</script>
</head>
<body style="margin:0px; padding:0px;" onload="initialize();">
<?
	if (isset($_POST['sid']) && isset($_POST['name']) && isset($_POST['latitude']) && isset($_POST['longitude']) && $_POST['confirm']==2) {
	$count = 0;
	$num = count($_POST['sid']);
	include 'connectDB.php'; 
	for ($i=0;$i<$num;$i++){
		if (is_numeric($_POST['latitude'][$i]) && is_numeric($_POST['longitude'][$i])){
			$strSQL = "UPDATE $table SET ";
			$strSQL .="SHOPNAME = '".$_POST["name"][$i]."'";
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

	    <tr>
			<td>
          	<input name="sid[]" type="hidden" id="sid[]" value="<? echo $dId ?>">
          	<input name="name[]" type="text"  required class="input" id="name[]" tabindex="1" value="<? echo $dName?>">
			</td>
	      	<td>
            <input name="latitude[]" type="number" required class="input" id="lat" tabindex="2" value="<? echo $dLat?>" size="10" onfocus="javascript:checkNum(this)">
            </td>
	      	<td>
            <input name="longitude[]" type="number" required class="input" id="long" tabindex="2" value="<? echo $dLong ?>" size="10" onfocus="javascript:checkNum(this)">
            </td>
			<td>&nbsp;</td>
        </tr>
<?


?>
	
    </table>
	<div id="map_canvas" style="float:left;width:400px; height:300px"></div>
	<footer><center>
    	<input name="confirm" type="hidden" id="confirm" value="2">
		<input type="submit" class="button_sub" value="แก้ไข" tabindex="4">
        </center>
	</footer>
</form>
<? 
		}
	}
	}
} ?>
</body>
</html>