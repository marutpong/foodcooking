<?
if (!isset($_SESSION)) {
  session_start();
}
	include('FoodFunction.php');
	include 'connectDB.php'; 
	$rows = optionIngredient("");
	$rowsTool = optionTool("");
	$rowsUser = optionUser("");
	$rowsFoodtype = optionFoodType("");
	if (isset($_POST['fsearch']) && ($_POST['fsearch']==1) ){
		$_SESSION["INPUT"] = array();
	}
	
	$input = array();//ที่กรอกมา
	for ($i=0 ; $i<count($_POST['ingredient']) ; $i++){
		$input[$_POST['ingredient'][$i]]=$_POST['quantity'][$i];
		$tmp3 = array('IID'=>$_POST['ingredient'][$i],'QUANTITY'=>$_POST['quantity'][$i],'UNIT'=>$_POST['unit'][$i]);
		array_push($_SESSION["INPUT"],$tmp3);
	}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Search Food</title>
	<meta charset="UTF-8" />
	<script type="text/javascript" src="core/js/jquery-1.6.4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="core/css/jquery-ui.css">
	<link href="core/css/mystyle.css" rel="stylesheet" type="text/css">
    <script src="core/js/jquery-2.0.0.min.js"></script>
    <script src="core/js/jquery-ui-1.10.3.js"></script>
	<script type="text/javascript" src="core/js/jquery.numeric.js"></script>
    <script src="core/js/combobox.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#name').focus();
		$( ".combobox" ).combobox();
		$( "#foodtype" ).combobox();
		$('#addmore').click(function () {
			var htmlStr = '<tr>\
              <td width="200"><select class="labelF combobox" id="combobox" name="ingredient[]">\
                <option value=""></option><? echo $rows;?></select>\
                <input name="newingredient[]" type="hidden" id="newingredient[]"></td>\
              <td><input name="quantity[]" type="number"  required class="input number" id="quantity[]" min="0" tabindex="1" \
            onFocus="checkNum(this)" size="10" placeholder="จำนวน"></td>\
              <td><input name="unit[]" type="text" readonly  required class="input unit" id="unit[]" tabindex="1" size="10" placeholder="หน่วย"></td>\
              <td><div class="remove" onClick="removeOb(this)"><img src="core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>\
            </tr>';
			$('#addIngre').append(htmlStr);
			$( ".combobox" ).combobox();
		});
		$('#addToolMore').click(function () {
			var htmlStr = '<tr>\
            <td width="200"><select class="labelF combobox" id="tool[]" name="tool[]" >\
              <option value=""></option>\
              <? echo $rowsTool;?></select>\
              <input name="newtool[]" type="hidden" id="newtool[]"></td>\
            <td><div class="remove" onClick="removeOb(this)"><img src="core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>\
            </tr>';
			$('#addTool').append(htmlStr);
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
</head>
<body>
<div style="width:400">
  <form action="" method="post" enctype="multipart/form-data">
<div>
    <table id="dynamic_tb">
	    <tr class="labelF">
	      <td align="right" valign="top">ชื่ออาหาร :</td>
	      <td><input name="name" type="text"  autofocus class="input" id="name" tabindex="1" autocomplete="on" value="<?=$_POST['name']?>" size="32" >
          <input name="fsearch" type="hidden" id="fsearch" value="1"></td>
        </tr>
	    <tr>
	      <td align="right" valign="top" class="labelF">ประเภท :</td>
	      <td><select class="labelF" id="foodtype" name="foodtype" >
	        <option value=""></option>
        <? echo optionFoodType($_POST['foodtype']);?></select><input name="newfoodtype" type="hidden"></td>
        </tr>
    </table>
    <table>
      <tr>
        <td valign="top" class="labelF">ส่วนผสม :</td>
        <td><div>
          <table border="0" id="addIngre">
			<? 
			for($i = 0; (isset($_SESSION["INPUT"])) && ($i < count($_SESSION["INPUT"])) ; $i++){
			?>
            <tr>
              <td width="200"><select class="labelF combobox" id="combobox" name="ingredient[]">
                <option value=""></option><?=optionIngredient($_SESSION["INPUT"][$i]['IID']);?>
              </select>
                <input name="newingredient[]" type="hidden" id="newingredient[]"></td>
              <td><input name="quantity[]" type="number"   class="input number" id="quantity[]" min="0" tabindex="1" 
            onFocus="checkNum(this)" size="10" placeholder="จำนวน" value="<?=$_SESSION["INPUT"][$i]['QUANTITY']?>"></td>
              <td><input name="unit[]" type="text"   class="input unit" id="unit[]" placeholder="หน่วย" tabindex="1" size="10" readonly value="<?=$_SESSION['INPUT'][$i]['UNIT']?>" ></td>
              <td><div class="remove" onClick="removeOb(this)"><img src="core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>
            </tr>
            <? } ?>
          </table>
        </div></td>
        </tr>
    </table>
    <div class="button_addmore" id="addmore" tabindex="4" ><img src="core/css/images/add.png" width="16" height="16">เพิ่มส่วนผสม</div>
</div>
<footer>
  <p>
    <center>
      <input type="submit" class="button_sub" value="ค้นหา" tabindex="4">
    </center>
      </p>
</footer>
</form>
</div>
<?
$foundFood = array();
$keyword = array();
if (isset($_POST['name']) && !empty($_POST['name'])){
	$tmp = array('attr'  => 'FOODNAME', 'value'  => $_POST['name']);
	array_push($keyword,$tmp);
}
if (isset($_POST['foodtype']) && !empty($_POST['foodtype'])){
	$tmp = array('attr'  => 'TYPEID', 'value'  => $_POST['foodtype']);
	array_push($keyword,$tmp);}

$where = "";
for ($i=0 ; $i<count($keyword) ; $i++){
	if ($i==0){
		$where .= " WHERE ";
	} else {
		$where .= " AND ";
	}
	
	if ($keyword[$i]['attr']=='FOODNAME'){
		$where .= $keyword[$i]['attr']." LIKE '%".$keyword[$i]['value']."%'";
	} else {
		$where .= $keyword[$i]['attr']." = '".$keyword[$i]['value']."'";
	}
}


$strSQL = " Select * from IFOODS NATURAL JOIN IFOODTYPE $where ";
//echo $strSQL;
$objParse = oci_parse($objConnect, $strSQL);
$objExecute = oci_execute($objParse, OCI_DEFAULT);
$searchOB = array();
while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
	$subSearchOB = array();
	$subSearchOB['FID']=$row['FID'];
	$subSearchOB['FOODNAME']=$row['FOODNAME'];
	$subSearchOB['TYPENAME']=$row['TYPENAME'];
	$subSearchOB['MUSTUSE']=array();
	$subSearchOB['LACK']=array();//ที่ไม่พอ
	$qstrSQL = " Select * from ICONTAIN NATURAL JOIN IINGREDIENT where fid=".$row['FID'];
	$qobjParse = oci_parse($objConnect, $qstrSQL);
	$qobjExecute = oci_execute($qobjParse, OCI_DEFAULT);
	$column = array();//ที่ต้องใช้
	while ($qrow = oci_fetch_array($qobjParse, OCI_BOTH)) {
		$column[$qrow['IID']]=$qrow['QUANTITY'];
		$tmp2 = array();
		$tmp2['IID']=$qrow['IID'];
		$tmp2['INNAME']=$qrow['INNAME'];
		$tmp2['QUANTITY']=$qrow['QUANTITY'];
		$tmp2['UNIT']=$qrow['UNIT'];
		$subSearchOB['MUSTUSE'][$qrow['IID']]=$tmp2;
	}
	$inputIn = array_intersect_key($input, $column);//ส่วนที่เหมือนกัน
	$haveIn = array_intersect_key($column, $input);
	$percentHave = 0;
	if (count($column)!=0){
		$percentHave = (float)count($inputIn)/(float)count($column);// % ที่มี
	}
	$numHave = (float)count($inputIn);//จำนวนวัตถุดิบที่เจอ
	$percentSim = 0;//% ความใกล้เคียง
	foreach (array_keys($inputIn ) as $key){
		if ($inputIn[$key]>$haveIn[$key]){
			$percentSim += 1*$percentHave/$numHave;
		} else {
			$percentSim += ($inputIn[$key]/$haveIn[$key])*$percentHave/$numHave;
		}
	}
	
	foreach (array_keys($column ) as $key){
		if ($column[$key]>$inputIn[$key]){
			$tmp2 = array();
			$tmp2['IID']=$key;
			$tmp2['INNAME']=$subSearchOB['MUSTUSE'][$key]['INNAME'];
			$tmp2['QUANTITY']=$column[$key]-$inputIn[$key];
			$tmp2['UNIT']=$subSearchOB['MUSTUSE'][$key]['UNIT'];
			$subSearchOB['LACK'][$key]=$tmp2;
		}
	}
	$subSearchOB['PERCENT']=$percentSim*100;
	if ($percentSim!=0){
		$searchOB[$row['FID']]=$subSearchOB;
	}
	//array_push($searchOB,$subSearchOB);
}

	function cmp($a, $b) {
		if ($a['PERCENT'] == $b['PERCENT']) {
			return 0;
		}
		return ($a['PERCENT'] > $b['PERCENT']) ? -1 : 1;
	}
	uasort($searchOB, 'cmp');
	$_SESSION["RESULT"] = $searchOB;
	//print_r($searchOB);
?>
<table>
  <tr>
    <td>ชื่อ</td>
    <td>ประเภท</td>
    <td>ใกล้เคียง</td>
    <td>Ingredient</td>
    <td>Lack</td>
  </tr>
  <?
  
  	foreach ($searchOB as $ob){
		

	
	
	?>
  <tr>
    <td valign="top"><? echo $ob['FOODNAME']; ?></td>
    <td valign="top"><? echo $ob['TYPENAME']; ?></td>
    <td valign="top"><? echo "\t\t ใกล้เคียง ".$ob['PERCENT']." %"; ?></td>
    <td valign="top"><? foreach ($ob['MUSTUSE'] as $ig){
			echo $ig['INNAME']."\t".$ig['QUANTITY']."\t".$ig['UNIT']."<br>";
			}
	?></td>
    <td valign="top"><? foreach ($ob['LACK'] as $ig){
			echo $ig['INNAME']."\t".$ig['QUANTITY']."\t".$ig['UNIT']."<br>";
			}
	?></td>
  </tr>
  <?
	}
	?>
</table>
</body>
</html>
