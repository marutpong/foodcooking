<?php
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

function getIngeIdByName($inname){
	include 'connectDB.php'; 
	$strSQL = "SELECT * FROM IINGREDIENT WHERE INNAME = '$inname'";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$row = oci_fetch_array($objParse, OCI_BOTH);		
	return $row['IID'];
}

function getTypeIdByName($typename){
	include 'connectDB.php'; 
	$strSQL = "SELECT * FROM IFOODTYPE WHERE TYPENAME = '$typename'";
	$objParse = oci_parse($objConnect , $strSQL);
	$objExecute = oci_execute($objParse);   
	$row = oci_fetch_array($objParse, OCI_BOTH);	
	return $row['TYPEID'];
}

function getToolIdByName($name){
	include 'connectDB.php'; 
	$strSQL = "SELECT * FROM ITOOLS WHERE TOOLNAME = '$name'";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$row = oci_fetch_array($objParse, OCI_BOTH);	   	
	return $row['TID'];   	
}
function getFoodIdByName($name){
	include 'connectDB.php'; 
	$strSQL = "SELECT * FROM IFOODS WHERE FOODNAME = '$name'";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$row = oci_fetch_array($objParse, OCI_BOTH);	   	
	return $row['FID'];   	
}

function insertIngredient($inname, $unit){
	$strSQL = "INSERT INTO IINGREDIENT (INNAME, UNIT) VALUES ('$inname','$unit') returning IID into :ID";
	return(myExeAndReturnID($strSQL));
}

function insertTool($name){
	$strSQL = "INSERT INTO ITOOLS (TOOLNAME) VALUES ('$name') returning TID into :ID";
	return(myExeAndReturnID($strSQL));
}

function insertFoodType($name,$des){
	$strSQL = "INSERT INTO IFOODTYPE (TYPENAME, DESCRIPTION) VALUES ('$name','$des') returning TYPEID into :ID";
	return(myExeAndReturnID($strSQL));
}

function insertContain($fid,$iid,$quantity){
	$strSQL = "INSERT INTO ICONTAIN (FID, IID, QUANTITY) VALUES ('$fid','$iid','$quantity')";
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
function optionIngredient($id){
	include 'connectDB.php';
	$strSQL = "SELECT * FROM IINGREDIENT ORDER BY INNAME";
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
	$strSQL = "SELECT * FROM ITOOLS ORDER BY TOOLNAME";
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
	$strSQL = "SELECT * FROM IUSERS ORDER BY NAME";
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
	$strSQL = "SELECT * FROM IFOODTYPE ORDER BY TYPENAME";
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
function uploadResizeTo($file_obj, $save_path,$entername, $ww=200, $hh=200){
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
	if($orig_width > $ww || $orig_height>$hh){
		if($orig_width > $orig_height){
			$hh = ($ww/$orig_width)*$orig_height;
		}else{
			$ww = ($hh/$orig_height)*$orig_width;
		}
	}else{
		$hh = $orig_height;
		$ww = $orig_width;
	}
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
	ImageDestroy($images_orig);
	ImageDestroy($images_fin);
	return($newfilename);
}

function uploadImage($path,$files){
	$SAVE_PATH = $path;//$_SERVER['DOCUMENT_ROOT']."/foodcooking/TestUploadPic/MyResize"; //พาสที่ต้องการนำไฟล์ไปเก็บไว้
	if(isset($files)){
		if($files["size"]>0){
			if(!file_exists($SAVE_PATH)) mkdir($SAVE_PATH); //สร้าง Folder ปลายทางเมื่อไม่พบ
			if(isImage($files)){ //ตรวจสอบว่าเป็นไฟล์รูปภาพ
				$hashname = md5_file($files["tmp_name"]);
				if( ($newfilename = uploadResizeTo($files, $SAVE_PATH,$hashname, 500, 375)) &&
				    ($newfilename2 = uploadResizeTo($files, $SAVE_PATH,"_".$hashname, 180, 135)) ){
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
?>