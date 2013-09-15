<?php

function isImage($file_obj){
	$IMG_TYPE = array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/png', 'image/x-png');
	$file_type = $file_obj['type'];
	return(in_array($file_type, $IMG_TYPE));
}
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