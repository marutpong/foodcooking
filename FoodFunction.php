<?php
	include 'connectDB.php'; 
function myExe($strSQL){
	include 'connectDB.php'; 
	$objParse = oci_parse($objConnect , $strSQL);
	$objExecute = oci_execute($objParse);   	
	return $objExecute;  
}

function myExeAndReturnID($strSQL){
	include 'connectDB.php'; 
	$objParse = oci_parse($objConnect, $strSQL);
	oci_bind_by_name($objParse,":ID",$id,32);
	$objExecute = oci_execute($objParse);
	if ($objExecute){
		return($id);
	} else return($objExecute);
}
function getSingleRow($strSQL){
	include 'connectDB.php';
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	return(oci_fetch_array($objParse, OCI_BOTH));
}
function getIngeIdByName($inname){
	include 'connectDB.php'; 
	$strSQL = "SELECT IID FROM IINGREDIENT WHERE INNAME = '$inname'";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$row = oci_fetch_array($objParse, OCI_BOTH);		
	return $row['IID'];
}

function getTypeIdByName($typename){
	include 'connectDB.php'; 
	$strSQL = "SELECT TYPEID FROM IFOODTYPE WHERE TYPENAME = '$typename'";
	$objParse = oci_parse($objConnect , $strSQL);
	$objExecute = oci_execute($objParse);   
	$row = oci_fetch_array($objParse, OCI_BOTH);	
	return $row['TYPEID'];
}

function getToolIdByName($name){
	include 'connectDB.php'; 
	$strSQL = "SELECT TID FROM ITOOLS WHERE TOOLNAME = '$name'";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$row = oci_fetch_array($objParse, OCI_BOTH);	   	
	return $row['TID'];   	
}
function getFoodIdByName($name){
	include 'connectDB.php'; 
	$strSQL = "SELECT FID FROM IFOODS WHERE FOODNAME = '$name'";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$row = oci_fetch_array($objParse, OCI_BOTH);	   	
	return $row['FID'];   	
}

function insertIngredient($inname, $unit){
	include 'connectDB.php'; 
	$strSQL = "SELECT IID FROM IINGREDIENT WHERE INNAME = '$inname'";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	if ($row = oci_fetch_array($objParse, OCI_BOTH)){
		return($row['IID']);
	}
	$strSQL = "INSERT INTO IINGREDIENT (INNAME, UNIT) VALUES ('$inname','$unit') returning IID into :ID";
	return(myExeAndReturnID($strSQL));
}

function insertTool($name){
	include 'connectDB.php'; 
	$strSQL = "SELECT TID FROM ITOOLS WHERE TOOLNAME = '$name'";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	if ($row = oci_fetch_array($objParse, OCI_BOTH)){
		return($row['TID']);
	}
	$strSQL = "INSERT INTO ITOOLS (TOOLNAME) VALUES ('$name') returning TID into :ID";
	return(myExeAndReturnID($strSQL));
}

function insertFoodType($name,$des){
	include 'connectDB.php'; 
	$strSQL = "SELECT TYPEID FROM IFOODTYPE WHERE TYPENAME = '$name'";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	if ($row = oci_fetch_array($objParse, OCI_BOTH)){
		return($row['TYPEID']);
	}
	$strSQL = "INSERT INTO IFOODTYPE (TYPENAME, DESCRIPTION) VALUES ('$name','$des') returning TYPEID into :ID";
	return(myExeAndReturnID($strSQL));
}

function insertContain($fid,$iid,$quantity){
	$strSQL = "INSERT INTO ICONTAIN (FID, IID, QUANTITY) VALUES ('$fid','$iid','$quantity')";
	return(myExe($strSQL));
}

function insertHave($sid,$iid){
	$strSQL = "INSERT INTO IHAVE (SID, IID) VALUES ('$sid','$iid')";
	return(myExe($strSQL));
}

function insertUse($fid,$tid){
	$strSQL = "INSERT INTO IUSE (FID, TID) VALUES ('$fid','$tid')";
	return(myExe($strSQL));
}
function insertFood($name,$picture,$method,$views,$owner,$foodtypeID){
	$strSQL = "INSERT INTO IFOODS (FOODNAME, PICTURE, METHOD, VIEWS, UIDS, TYPEID) VALUES ('$name','$picture','$method','$views','$owner','$foodtypeID') returning FID into :ID";
	return(myExeAndReturnID($strSQL));
}
function insertShop($name,$latitude,$longitude){
	$strSQL = "INSERT INTO ISHOP (SHOPNAME, LATITUDE, LONGITUDE) VALUES ('$name','$latitude','$longitude') returning SID into :ID";
	return(myExeAndReturnID($strSQL));
}
function optionIngredient($id){
	include 'connectDB.php';
	$strSQL = "SELECT IID,INNAME FROM IINGREDIENT ORDER BY INNAME";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$rows="";
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		$selected = "";
		if (!empty($id) && ($row['IID']==$id) ){
			$selected = "selected";
		}
		$rows.= '<option value="'.$row['IID'].'" '.$selected.' >'.$row['INNAME'].'</option>';
	}
	return($rows);
}
function optionTool($id){
	include 'connectDB.php';
	$strSQL = "SELECT TID,TOOLNAME FROM ITOOLS ORDER BY TOOLNAME";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$rows="";
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		$selected = "";
		if (!empty($id) && ($row['TID']==$id) ){
			$selected = "selected";
		}
		$rows.= '<option value="'.$row['TID'].'" '.$selected.' >'.$row['TOOLNAME'].'</option>';
	}
	return($rows);
}
function optionUser($id){
	include 'connectDB.php';
	$strSQL = "SELECT UIDS,NAME FROM IUSERS ORDER BY NAME";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$rows="";
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		$selected = "";
		if (!empty($id) && ($row['UIDS']==$id) ){
			$selected = "selected";
		}
		$rows.= '<option value="'.$row['UIDS'].'" '.$selected.' >'.$row['NAME'].'</option>';
	}
	return($rows);
}
function optionFoodType($id){
	include 'connectDB.php';
	$strSQL = "SELECT TYPEID,TYPENAME FROM IFOODTYPE ORDER BY TYPENAME";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$rows="";
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		$selected = "";
		if (!empty($id) && ($row['TYPEID']==$id) ){
			$selected = "selected";
		}
		$rows.= '<option value="'.$row['TYPEID'].'" '.$selected.' >'.$row['TYPENAME'].'</option>';
	}
	return($rows);
}
function Login($username,$password){
	$strSql = "SELECT * FROM IUSERS WHERE USERNAME = '".$username."' AND PASSWORD = '".sha1($password)."'";
	if($row = getSingleRow($strSql)){
		return $row;
	}
	return (false);
}
function authenIdUser(){
	if(isset($_SESSION['UIDS']) && isset($_SESSION['USERNAME']) ){
		include 'connectDB.php';
		$strSql = "SELECT * FROM IUSERS WHERE UIDS = '".$_SESSION['UIDS']."' AND USERNAME = '".$_SESSION['USERNAME']."'";
		$objParse = oci_parse($objConnect, $strSql);
		oci_execute($objParse, OCI_DEFAULT);
		if($row = oci_fetch_array($objParse, OCI_BOTH)){
			return (true);
		}
	}
	return (false);
}
function authenAdmin($levels=1){	
	if(isset($_SESSION['UIDS']) && isset($_SESSION['USERNAME']) ){
		$arrLevels = Explode(",", $levels); 
		include 'connectDB.php';
		$strSql = "SELECT * FROM IUSERS WHERE UIDS = '".$_SESSION['UIDS']."' AND USERNAME = '".$_SESSION['USERNAME']."'";
		$objParse = oci_parse($objConnect, $strSql);
		oci_execute($objParse, OCI_DEFAULT);
		$row = oci_fetch_array($objParse, OCI_BOTH);
		if($row && in_array($row['USER_LEVEL'], $arrLevels)){
			return (true);
		}
	}
	return (false);

}
function authenLevel($id,$user,$levels){
	$arrLevels = Explode(",", $levels); 
	include 'connectDB.php';
	$strSql = "SELECT * FROM IUSERS WHERE UIDS = '".$id."' AND USERNAME = '".$user."'";
	$objParse = oci_parse($objConnect, $strSql);
	oci_execute($objParse, OCI_DEFAULT);
	$row = oci_fetch_array($objParse, OCI_BOTH);
	if($row && in_array($row['USER_LEVEL'], $arrLevels)){
	   	return (true);
	}else{
		return (false);
	}
}
function isFoodOwner($id,$fid){
	include 'connectDB.php';
	$strSql = "SELECT FID FROM IFOODS WHERE FID = '".$fid."' AND UIDS = '".$id."'";
//	echo $strSql;
	$objParse = oci_parse($objConnect, $strSql);
	oci_execute($objParse, OCI_DEFAULT);
	if($row = oci_fetch_array($objParse, OCI_BOTH)){
		return (true);
	}else{
		return (false);
	}
}
function isCommentOwner($id,$fid){
	include 'connectDB.php';
	$strSql = "SELECT FID FROM ICOMMENTS WHERE UIDS = '".$id."' AND FID = '".$fid."' ";
	echo $strSql;
	$objParse = oci_parse($objConnect, $strSql);
	oci_execute($objParse, OCI_DEFAULT);
	if($row = oci_fetch_array($objParse, OCI_BOTH)){
		return (true);
	}else{
		return (false);
	}
}

function numberOfComment($fid){
	include 'connectDB.php';
	$total = 0;
	if (is_numeric($fid)){
		$strSQL = "SELECT COUNT(FID) NUM FROM ICOMMENTS WHERE FID='$fid'";
		$row = getSingleRow($strSQL);
		$total=$row['NUM'];
	}
	return $total;
}
function numberOfHave($sid){
	include 'connectDB.php';
	$total = 0;
	if (is_numeric($sid)){
		$strSQL = "SELECT COUNT(SID) NUM FROM IHAVE WHERE SID='$sid'";
		$row = getSingleRow($strSQL);
		$total=$row['NUM'];
	}
	return $total;
}
function numberOfLike($fid){
	include 'connectDB.php';
	$total = 0;
	if (is_numeric($fid)){
		$strSQLlike = "SELECT COUNT(FID) as \"LIKE\" FROM IFAVORITE WHERE FID = ".$fid;
		$rowlike = getSingleRow($strSQLlike);
		$total=$rowlike['LIKE'];
	}
	return $total;
}
/**
* ฟังก์ชั่นตรวจสอบว่าเป็นไฟล์รูปภาพหรือไม่
* bool isImage(resource $file_obj)
*/
function isImage($file_obj){
	$IMG_TYPE = array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/png', 'image/x-png');
	$file_type = $file_obj['type'];
	return(in_array($file_type, $IMG_TYPE));
}
/**
* ฟั่งชั่น resize รูปภาพโดยกำหนด ความกว้าง,สูง สูงสุด
* $save_filename ชื่อไฟล์ไม่ต้องมีนามสกุล
* $ww ความกว้าง สูงสุด
* $hh ความสูง สูงสุด
* return เป็นชื่อไฟล์ที่ถูกเก็บ
* string uploadResizeTo(resource $file_obj,string $save_path,string $save_filename[,int $ww,int $hh])
*/
function uploadResizeTo($file_obj, $save_path,$entername, $ww=660, $hh=1000){
	$file_name = $file_obj['name'];
	$file_type = $file_obj['type'];
	$tmp_name = $file_obj['tmp_name'];
	switch($file_type){
		case "image/pjpeg" :
		case "image/jpeg" :
		$images_orig = ImageCreateFromJPEG($tmp_name);
		break;
		case "image/gif":
		$images_orig = ImageCreateFromGIF($tmp_name);
		break;
		case "image/png":
		case "image/x-png":
		$images_orig = ImageCreateFromPNG($tmp_name);
		break;
		case "image/bmp":
		$images_orig = ImageCreateFromWBMP($tmp_name);
		break;
		default:
		return(false);
	}
	$orig_width = ImagesX($images_orig);
	$orig_height = ImagesY($images_orig);
	//if($orig_width > $ww || $orig_height>$hh){
		if($orig_width > $orig_height){
			$hh = ($ww/$orig_width)*$orig_height;
		}else{
			$ww = ($hh/$orig_height)*$orig_width;
		}
	/*}else{
		$hh = $orig_height;
		$ww = $orig_width;
	}*/
	$images_fin = ImageCreateTrueColor($ww, $hh);
	@imagecopyresized($images_fin, $images_orig, 0, 0, 0, 0, $ww, $hh, $orig_width, $orig_height);
	$ext = end(explode(".", $file_name));
	$newfilename = $entername.".".$ext;
	$save = $save_path.$newfilename;
	switch($file_type){
		case "image/pjpeg" :
		case "image/jpeg" :
		case "image/jpg" :
		ImageJPEG($images_fin, $save ,90); // image quality = 90
		
		break;
		case "image/gif":
		ImageGIF($images_fin,$save);
		break;
		case "image/png":
		case "image/x-png":
		ImagePNG($images_fin,$save);
		break;
		case "image/bmp":
		imageWBMP($images_fin,$save);
		default:
		return(false);
	}
	postToServer($save);
	ImageDestroy($images_orig);
	ImageDestroy($images_fin);
	return($newfilename);
}
function postToServer($save){
	$file_path = realpath($save);
	$post = array('filUpload'=>'@'.$file_path);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, 'http://10.10.188.254/group10/upload.php');
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
	$result = curl_exec ($curl);
	curl_close ($curl); 
}
function uploadImage($path,$files){
	$SAVE_PATH = $path;//$_SERVER['DOCUMENT_ROOT']."/foodcooking/TestUploadPic/MyResize"; //พาสที่ต้องการนำไฟล์ไปเก็บไว้
	if(isset($files)){
		if($files["size"]>0){
			if(!file_exists($SAVE_PATH)) mkdir($SAVE_PATH); //สร้าง Folder ปลายทางเมื่อไม่พบ
			if(isImage($files)){ //ตรวจสอบว่าเป็นไฟล์รูปภาพ
				$hashname = md5_file($files["tmp_name"]);
				if( ($newfilename = uploadResizeTo($files, $SAVE_PATH,$hashname, 660, 1000)) &&
				    ($newfilename2 = uploadResizeTo($files, $SAVE_PATH,"_".$hashname, 300, 500)) ){
						return($newfilename);
				} else return(false);
			}else{
				 return(false);
			}		
		}else{
			return(false);
		}
	}
}

function sendmail($email,$msgheader,$msgcontent){
	require("core/PHPMailer_5.2.4/class.phpmailer.php");
	$htmlbody = "<b>$msgcontent</b>";
	$mail = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->SMTPDebug = 0;
	$mail->IsHTML(true);
	$mail->CharSet = "UTF-8"; 
	$mail->SMTPAuth = true;
	$mail->Host = "smtp.mail.yahoo.com"; 
	$mail->Username = "foodcooking_g10@yahoo.com"; 
	$mail->Password = "Emailg10"; 
	$mail->SetFrom("foodcooking_g10@yahoo.com", "Webmaster"); 
	$mail->Subject = "$msgheader"; 
	$mail->AltBody = "$msgcontent"; 
	$mail->Body = $htmlbody;
	$mail->AddAddress("$email"); 
	if ( $mail->Send() )
	{ 
		return (true); 
	}else
	{
		echo (false);
	}
}
function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}
function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}
function url_exists($file) {
	$file_headers = @get_headers($file);
	if($file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.1 403 Forbidden') {
		return false;
	}
	else {
		return true;
	}
}
function picture_url($url){
	$src=NULL;
	if (file_exists('files/'.$url)) {
		$src = "files/".$url;
	} else if (url_exists("http://10.10.188.254/group10/files/".$url)) {
		$src = "http://10.10.188.254/group10/files/".$url;
	} else {
		$src = "core/images/no-img.png";
	}
	return($src);
}
function hasLiked($fid=NULL){
	if(isset($_SESSION['UIDS']) && isset($_SESSION['USERNAME']) && is_numeric($fid)){
		$strSQLlike = "SELECT* FROM IFAVORITE WHERE FID = ".$fid."AND UIDS = ".$_SESSION['UIDS'];
		if($rowlike = getSingleRow($strSQLlike)){
			return (true);
		}
	}
	return (false);
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return round(($miles * 1.609344), 4);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}
?>