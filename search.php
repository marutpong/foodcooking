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
	if ((isset($_POST['fsearch']) && ($_POST['fsearch']==1) || (empty($_SESSION["INPUTCAL"]))) ){
		$_SESSION["INPUT"] = array();
		$input = array();//ที่กรอกมา
		$_SESSION["INPUTCAL"] = array();
	}
	
	for ($i=0 ; $i<count($_POST['ingredient']) ; $i++){
		$_SESSION["INPUTCAL"][$_POST['ingredient'][$i]]=$_POST['quantity'][$i];
		$tmp3 = array(  'IID'=>$_POST['ingredient'][$i],
						'QUANTITY'=>$_POST['quantity'][$i],
						'UNIT'=>$_POST['unit'][$i]);
		array_push($_SESSION["INPUT"],$tmp3);
	}
	$input = $_SESSION["INPUTCAL"];

$_SESSION['keyword'] = array();
if (isset($_POST['name']) && !empty($_POST['name'])){
	$tmp = array('attr'  => 'FOODNAME', 'value'  => $_POST['name']);
	array_push($_SESSION['keyword'],$tmp);
}
if (isset($_POST['foodtype']) && !empty($_POST['foodtype'])){
	$tmp = array('attr'  => 'TYPEID', 'value'  => $_POST['foodtype']);
	array_push($_SESSION['keyword'],$tmp);}
$keyword = $_SESSION['keyword'];
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
<title>Search</title>
<meta name="description" content>
<meta name="author" content>
<!-- CSS Style -->
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<link rel="stylesheet" type="text/css" href="core/css/bar-style.css">
<!-- Short Codes Style -->
<!-- Start Java CSS -->
<!-- Color Schemes CSS -->
<!--[if lt IE 9]>
      <script src="js/html5.js"></script>
<![endif]-->
<script src="core/js/jquery-1.9.1.js"></script>
<script src="core/js/jquery-2.0.0.min.js"></script>
<script type="text/javascript" src="core/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="core/fancyapps/source/jquery.fancybox.pack.js"></script>
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
        <li>SEARCH</li>
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
            <h2>Search</h2>
            <div style="width:400">
              <form action="" method="post" enctype="multipart/form-data" id="search">
                <div>
                  <table id="dynamic_tb">
                    <tr class="labelF">
                      <td width="70" align="right" valign="top">ชื่ออาหาร :</td>
                      <td><input name="name" type="text" autofocus class="input" id="name" tabindex="1" autocomplete="on" value="<?=$_POST['name']?>" size="32">
                        <input name="fsearch" type="hidden" id="fsearch" value="1"></td>
                    </tr>
                    <tr>
                      <td width="70" align="right" valign="top" class="labelF">ประเภท :</td>
                      <td><select class="labelF" id="foodtype" name="foodtype">
                          <option value=""></option>
                          <? echo optionFoodType($_POST['foodtype']);?>
                        </select>
                        <input name="newfoodtype" type="hidden"></td>
                    </tr>
                  </table>
                  <table width="500">
                    <tr>
                      <td width="80" align="right" valign="top" class="labelF">ส่วนผสม :</td>
                      <td width="400"><table width="420" border="0" id="addIngre">
                          <? 
			for($i = 0; (isset($_SESSION["INPUT"])) && ($i < count($_SESSION["INPUT"])) ; $i++){
			?>
                          <tr>
                            <td width="220"><select class="labelF combobox" id="combobox" name="ingredient[]">
                                <option value=""></option>
                                <?=optionIngredient($_SESSION["INPUT"][$i]['IID']);?>
                              </select>
                              <input name="newingredient[]" type="hidden" id="newingredient[]"></td>
                            <td><input name="quantity[]" type="number"   class="input number" id="quantity[]" min="0" step="any" tabindex="1" 
            onFocus="checkNum(this)" size="10" placeholder="จำนวน" value="<?=$_SESSION["INPUT"][$i]['QUANTITY']?>" style="width:60px;"></td>
                            <td><input name="unit[]" type="text"   class="input unit" id="unit[]" placeholder="หน่วย" tabindex="1" size="10" readonly value="<?=$_SESSION['INPUT'][$i]['UNIT']?>"  style="width:100px;"></td>
                            <td><div class="remove" onClick="removeOb(this)"><img src="core/css/images/close.png" alt="Remove this row" width="16" height="16"></div></td>
                          </tr>
                          <? } ?>
                        </table></td>
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
	$subSearchOB['PICTURE']=$row['PICTURE'];
	$subSearchOB['VIEWS']=$row['VIEWS'];
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
	$percentSim*=100;
	$percentSim = round($percentSim, 2);
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
	$subSearchOB['PERCENT']=$percentSim;
	if ($percentSim > 0 && $percentSim <= 20 ){ $color = "#f63a0f"; }
	else if ($percentSim > 20 && $percentSim <= 40 ){ $color = "#f27011"; }
	else if ($percentSim > 40 && $percentSim <= 60 ){ $color = "#f2b01e"; }
	else if ($percentSim > 60 && $percentSim <= 80 ){ $color = "#f2d31b"; }
	else { $color = "#86e01e"; }
	$subSearchOB['COLOR']=$color;

	if ($percentSim!=0 || ($percentSim==0 && empty($input) && (!empty($_POST['name']) || !empty($_POST['foodtype'])))){
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
<?	foreach ($searchOB as $ob){ 
	$src=picture_url("_".$ob['PICTURE']);
?>
            <article class="blog-main">
              <section class="grid" style="background:#E9E9E9;padding-top:20px;border-radius:15px;">
                <article class=" column three-col">
                  <? if (!empty($input)) { ?>
                  <div class="progress" style="margin-bottom:10px;margin-top:10px">
                    <div class="progress-bar" style="width:<?=$ob['PERCENT']?>%;background-color:<?=$ob['COLOR']?>"></div>
                  </div>
                  <span style="font-size:14px">
                  <? 
			  if (!empty($input)){
			  echo "\t\t    ใกล้เคียง ".$ob['PERCENT']." %"; } ?>
                  </span>
                  <? } ?>
                  <a href="foodDetail.php?foodid=<?=$ob['FID']?>">
                  <div style="background-image:url('<?=$src?>');" class="myfoodpic">
                    <div class="myfoodpic_title">
                      <?=$ob['FOODNAME']?>
                    </div>
                  </div>
                  </a>
                  <ul class="b-top-links">
                    <li class="pic-icon"><? echo $ob['TYPENAME']; ?></li>
                    <li class="catagory"><? echo $ob['VIEWS']; ?> views</li>
                  </ul>
                </article>
                <article class=" column three-col"> </article>
                <article class=" column three-col"><span class="title6">วัตถุดิบที่ต้องใช้</span>
                  <ul>
                    <? foreach ($ob['MUSTUSE'] as $ig){
					echo "<li>".$ig['INNAME']."\t".$ig['QUANTITY']."\t".$ig['UNIT']."</li>";
					} ?>
                  </ul>
                </article>
                <? if (!empty($input)) { ?>
                <article class=" column three-col"><span class="title6">วัตถุดิบที่ขาด</span>
                  <ul>
                    <? foreach ($ob['LACK'] as $ig){
					echo "<li>".$ig['INNAME']."\t".$ig['QUANTITY']."\t".$ig['UNIT']."</li>";
					} ?>
                  </ul>
                </article>
                <? } ?>
              </section>
              <section class="grid"></section>
            </article>
            <? } ?>
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
<script type="text/javascript" src="js/focus.js"></script><!-- text field clear & celander Seting--> 

<script type="text/javascript" src="core/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js"></script> 
<script type="text/javascript" src="core/fancyapps/source/jquery.fancybox.pack.js"></script> 
<script type="text/javascript" src="core/js/jquery-1.6.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="core/css/jquery-ui.css">
<link href="core/css/mystyle.css" rel="stylesheet" type="text/css">
<script src="core/js/jquery-ui-1.10.3.js"></script> 
<script type="text/javascript" src="core/js/jquery.numeric.js"></script> 
<script src="core/js/combobox.js"></script> 
<script type="text/javascript">
	$(document).ready(function() {
		$('#name').focus();
		$( ".combobox" ).combobox();
		$( "#foodtype" ).combobox();
/*		 $( ".number" ).spinner({
			min: 0,
			step: 1.00,
			numberFormat: "n"
			});
*/
		$('#addmore').click(function () {
			var htmlStr = '<tr>\
              <td width="200"><select class="labelF combobox" id="combobox" name="ingredient[]">\
                <option value=""></option><? echo $rows;?></select>\
                <input name="newingredient[]" type="hidden" id="newingredient[]"></td>\
              <td><input name="quantity[]" type="number"  required class="input number" id="quantity[]" min="0" step="any" tabindex="1" \
            onFocus="checkNum(this)" size="10" placeholder="จำนวน"   style="width:60px;"></td>\
              <td><input name="unit[]" type="text" readonly  required class="input unit" id="unit[]" tabindex="1" size="10" placeholder="หน่วย"   style="width:100px;"></td>\
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
</body>
</html>
