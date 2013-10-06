<?
if (!isset($_SESSION)) {
  session_start();
}
include '../../FoodFunction.php';
if (!(isset($_SESSION['UIDS']) && isset($_SESSION['USERNAME']) && authenIdUser())) {
	header ("Location: ../../login.php?relog=1&msg=Permission denied. Please login.&ref=".$_SERVER['PHP_SELF']);

}
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
	$sid=$_POST['sid'];
	include 'connectDB.php'; 
		if (is_numeric($_POST['latitude']) && is_numeric($_POST['longitude'])){
			$strSQL = "UPDATE $table SET ";
			$strSQL .="SHOPNAME = '".$_POST["name"]."'";
			$strSQL .=", LATITUDE = '".$_POST["latitude"]."' ";
			$strSQL .=", LONGITUDE = '".$_POST["longitude"]."' ";
			$strSQL .=" WHERE SID = '".$sid."' ";
			//echo $strSQL;
			$objParse = oci_parse($objConnect, $strSQL);
			$objExecute = oci_execute($objParse);
			if($objExecute){
				$count++;
			}
	}
	echo '<br><center><div class="textC1">';
	if($count){
		$strSQL = "DELETE FROM IHAVE WHERE SID = ".$sid;
		if(myExe($strSQL)){
			/////// Add INGREDIENT  ////////
			if ( isset($_POST['ingredient']) && isset($_POST['newingredient'])){
				$ingredient = $_POST['ingredient'];
				$newIG = $_POST['newingredient'];
				$num = count($_POST['ingredient']);
				for ($i=0;$i<$num;$i++){
						$theIngreID = "";
						if ( !empty($newIG[$i]) ) {			
							$theIngreID = insertIngredient($newIG[$i],$_POST['unit'][$i]);
						} else if (!empty($ingredient[$i])){
							$theIngreID = $ingredient[$i];
						}
						if(is_numeric($theIngreID)) {insertHave($sid,$theIngreID); }
				}
			}
		}
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
          	<input name="sid" type="hidden" id="sid" value="<? echo $dId ?>">
          	<input name="name" type="text"  required class="input" id="name" tabindex="1" value="<? echo $dName?>">
			</td>
	      	<td>
            <input name="latitude" type="number" required class="input" id="lat" tabindex="2" value="<? echo $dLat?>" size="10" onfocus="javascript:checkNum(this)">
            </td>
	      	<td>
            <input name="longitude" type="number" required class="input" id="long" tabindex="2" value="<? echo $dLong ?>" size="10" onfocus="javascript:checkNum(this)">
            </td>
			<td>&nbsp;</td>
        </tr>
<?


?>
	
    </table>
    <table>
        <tr>
        <td><div id="map_canvas" style="float: left; width: 550px; height: 300px"></div></td>
        </tr>
    </table>
	
    
  <table>
    <tr>
      <td valign="top" class="labelF">ส่วนผสม :</td>
      <td><div>
        <table border="0" id="addIngre">
        <?
		$strSQL = "SELECT * FROM IHAVE NATURAL JOIN IINGREDIENT Where SID=".$dId;
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		while ($rowContain = oci_fetch_array($objParse, OCI_BOTH)) {
		?>
          <tr>
            <td width="200"><select class="labelF combobox" id="combobox" name="ingredient[]" >
              <option value=""></option>
              <? echo optionIngredient($rowContain['IID']);?>
            </select>
              <input name="newingredient[]" type="hidden" id="newingredient[]">
            </td>
            <td>&nbsp;</td>
            <td><input name="unit[]" type="text" readonly  required class="input unit" id="unit[]" tabindex="1" size="10" placeholder="หน่วย" value="<? echo $rowContain['UNIT']; ?>" style="width:100px;">
            </td>
            <td><div class="remove" onClick="removeOb(this)" id="<? echo $rowContain['IID']; ?>"><img src="../../core/css/images/close.png" alt="Remove this row" width="16" height="16"></div>
            </td>
          </tr>
          <? }
		  ?>
        </table>
      </div></td>
    </tr>
  </table>
    <div class="button_addmore" id="addmore" tabindex="4" ><img src="../../core/css/images/add.png" width="16" height="16">เพิ่มส่วนผสม</div>
    
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