<?
/**
* ฟังกชั่น Upload และ Resize รูป
* By Rakyimdesign.com, E-mail info@rakyimdesign.com
*/
$SAVE_PATH = $_SERVER['DOCUMENT_ROOT']."/TestUploadPic/MyResize/"; //พาสที่ต้องการนำไฟล์ไปเก็บไว้
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
function uploadResizeTo($file_obj, $save_path, $save_filename, $ww=200, $hh=200){
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
@imagecopyresized($images_fin, $images_orig, 0, 0, 0, 0, $ww, $hh, $orig_width, $orig_height);$ext = end(explode(".", $file_name));
$newfilename = $save_filename.".".$ext;
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
return($newfilename);}
/**
* เริ่มต้นการใช้งาน
*
*/
if(isset($_FILES["file"])){
if($_FILES["file"]["size"]>0){
if(!file_exists($SAVE_PATH)) mkdir($SAVE_PATH); //สร้าง Folder ปลายทางเมื่อไม่พบ
if(isImage($_FILES["file"])){ //ตรวจสอบว่าเป็นไฟล์รูปภาพ
//เรียกฟังก์ชั่น Resize
if($newfilename = uploadResizeTo($_FILES["file"], $SAVE_PATH, "new_file2", 1000, 1000)){
echo 'upload ok <strong>'.$newfilename.'</strong>';
?>

<img src="<?="MyResize/".$newfilename;?>">
<?
}else echo 'upload fail';
}else{
echo 'use pic only';

}
}else{
echo 'mung yung mai dai up sus';
}
}
?>